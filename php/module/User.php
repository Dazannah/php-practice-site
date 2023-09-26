<?php
require_once("Database.php");

  class User{
    protected $properties = array();

    public function __construct($initialProperies) {
      foreach($initialProperies as $name => $value){
        $this -> properties[$name] = $value;
      }
    }

    public function addProperty($propertyName, $propertyValue){
      $this-> properties[$propertyName] = $propertyValue;
    }

    public function getProperty($propertyName){
      if(isset($this-> properties[$propertyName])){
        return $this-> properties[$propertyName];
      }else{
        return "Property don't exist.";
      }

    }

    public function deleteProperty($propertyName){
      unset($this-> properties[$propertyName]);
    }

    public function getAllProperties(){
      return $this -> properties;
    }

  }

  class LoginUser extends User{

    public function __construct($initialProperies) {
      parent::__construct($initialProperies);
    }

    public function loginProcess(){
      $database = new Database();
      $result = $database -> findUserWIthUsernamePassword($this->properties["username"], $this->properties["password"]);

      if(mysqli_num_rows($result) < 1){
        header('Content-Type: application/json');

        echo json_encode("Invalid username/password.");
        exit();
      }

      return $result->fetch_assoc();
    }
  }

  class RegisterUser extends User{

    protected $error = [];

    public function __construct($initialProperies){
      parent::__construct($initialProperies);
    }

    public function registrationProcess(){
      $isUsernameAvailable = $this->isUsernameTaken();
      $isEmailAvailable = $this->isEmailTaken();

      if(!$isUsernameAvailable || !$isEmailAvailable){
        return $this->error;
      }

      $isValidationOk = $this->validate();

      if($isValidationOk){
        return $this->error;
      }

      $database = new Database();
      $saveResult = $database -> saveUser($this->properties["username"], $this->properties["password"], $this->properties["email"]);

      return $saveResult;
    }

    private function isUsernameTaken(){
      try{
        $databse = new Database();
        $result = $databse -> findUserByUsername($this->properties["username"]);
  
        if(mysqli_num_rows($result) > 0){
          array_push($this->error, "Useranme is already taken"); 
        }
    
        return $this->checkIfAnyError();
      }catch(Exepsion $err){
        echo $err->getMessage();
      }
    }
  
    private function isEmailTaken(){
      try{
        $database = new Database();
        $result = $database -> findUserByEmail($this->properties["email"]);
  
        if(mysqli_num_rows($result) > 0){
          array_push($this->error, "Email is already taken"); 
        }
    
        return $this->checkIfAnyError();
      }catch(Exepsion $err){
        echo $err->getMessage();
      }
    }
  
    private function validate(){
  
      if (trim($this->properties["username"]) === "") array_push($this->error, "You must provide a username.");
      if (trim($this->properties["password"]) === "") array_push($this->error, "You must provide a password.");
      if ($this->properties["password"] != $this->properties["passwordAgain"]) array_push($this->error, "The two password is different.");
    
      $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!,_])(?!.*\s).{8,}$/";
      if (!preg_match($passwordRegex, $this->properties["password"])) array_push($this->error, "At least one upper case letter, a number and a special character have to be used in the password");
    
      $emailRegex = "/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/";
      if (!preg_match($emailRegex, $this->properties["email"])) array_push($this->error, "You must provide a valid e-mail address.");
  
      $this->checkIfAnyError();
    }
  
    private function checkIfAnyError(){
      if(count($this->error)>0){
        return false;
      }else{
        return true;
      }
    }
  }
?>
<?php
require_once("Database.php");

  class User{
    protected $username;
    protected $email;

    public function __construct($username, $email) {
      $this->username = $username;
      $this->email = $email;
    }

    public function username(){
      return $this -> username;
    }

    public function email(){
      return $this -> email;
    }
  }

  class LoginUser{
    protected $username;
    protected $password;

    public function __construct($user) {
      $this -> username = $user -> username;
      $this->password = $user -> password;
    }

    public function loginProcess(){
      $database = new Database();
      $result = $database -> findUserWIthUsernamePassword($this->username, $this->password);

      if(mysqli_num_rows($result) < 1){
        header('Content-Type: application/json');

        echo json_encode("Invalid username/password.");
        exit();
      }

      return $result->fetch_assoc();
    }
  }

  class RegisterUser{
    protected $username;
    protected $email;
    protected $password;
    protected $passwordAgain;
    protected $error = [];

    public function __construct($user){
      $this->username = $user -> username;
      $this->email = $user -> email;
      $this->password = $user -> password;
      $this->passwordAgain = $user -> passwordAgain;
      $this->error = [];
    }

    private function isUsernameTaken(){
      try{
        $databse = new Database();
        $result = $databse -> findUserByUsername($this->username);
  
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
        $result = $database -> findUserByEmail($this->email);
  
        if(mysqli_num_rows($result) > 0){
          array_push($this->error, "Email is already taken"); 
        }
    
        return $this->checkIfAnyError();
      }catch(Exepsion $err){
        echo $err->getMessage();
      }
    }
  
    private function validate(){
  
      if (trim($this->username) === "") array_push($this->error, "You must provide a username.");
      if (trim($this->password) === "") array_push($this->error, "You must provide a password.");
      if ($this->password != $this->passwordAgain) array_push($this->error, "The two password is different.");
    
      $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!,_])(?!.*\s).{8,}$/";
      if (!preg_match($passwordRegex, $this->password)) array_push($this->error, "At least one upper case letter, a number and a special character have to be used in the password");
    
      $emailRegex = "/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/";
      if (!preg_match($emailRegex, $this->email)) array_push($this->error, "You must provide a valid e-mail address.");
  
      $this->checkIfAnyError();
    }
  
    private function checkIfAnyError(){
      if(count($this->error)>0){
        return false;
      }else{
        return true;
      }
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
      $saveResult = $database -> saveUser($this->username, $this->password, $this->email);

      return $saveResult;
    }
  }
?>
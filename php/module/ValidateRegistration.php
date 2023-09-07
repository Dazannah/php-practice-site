<?php

require_once("Database.php");

class ValidateRegistration{
  public function __construct( $username, $password, $passwordAgain, $email) {
    $this->username = $username;
    $this->password = $password;
    $this->passwordAgain = $passwordAgain;
    $this->email = $email;
    $this->error = [];
  }

  public function isUsernameTaken(){
    try{
      $finduser = new FindUserByUsername($this->username);
      $result = $finduser->runQuerry();

      if(mysqli_num_rows($result) > 0){
        array_push($this->error, "Useranme is already taken"); 
      }
  
      return $this->checkIfAnyError();
    }catch(Exepsion $err){
      echo $err->getMessage();
    }
  }

  public function validate(){

    if (trim($this->username) === "") array_push($this->error, "You must provide a username.");
    if (trim($this->password) === "") array_push($this->error, "You must provide a password.");
    if ($this->password != $this->passwordAgain) array_push($this->error, "The two password is different.");
  
    $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!_])(?!.*\s).{8,}$/";
    if (!preg_match($passwordRegex, $this->password)) array_push($this->error, "At least one upper case letter, a number and a special character have to be used in the password");
  
    $emailRegex = "/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/";
    if (!preg_match($emailRegex, $this->email)) array_push($this->error, "You must provide a valid e-mail address.");

    $this->checkIfAnyError();
  }

  function checkIfAnyError(){
    if(count($this->error)>0){
      return false;
    }else{
      return true;
    }
  }
}
?>
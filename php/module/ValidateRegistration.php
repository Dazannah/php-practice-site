<?php
class ValidateRegistration{
  public function __construct( $username, $password, $passwordAgain, $email) {
    $this->username = $username;
    $this->password = $password;
    $this->passwordAgain = $passwordAgain;
    $this->email = $email;
    $this->error = [];
  }

  public function validate(){

    if (trim($this->username) === "") array_push($this->error, "You must provide a username.");
    if (trim($this->password) === "") array_push($this->error, "You must provide a password.");
    if ($this->password != $this->passwordAgain) array_push($this->error, "The two password is different.");
  
    $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&+=!_])(?!.*\s).{8,}$/";
    if (!preg_match($passwordRegex, $this->password)) array_push($this->error, "At least one upper case letter, a number and a special character have to be used in the password");
  
    $emailRegex = "/^[\w\-\.]+@([\w-]+\.)+[\w-]{2,4}$/";
    if (!preg_match($emailRegex, $this->email)) array_push($this->error, "You must provide a valid e-mail address.");

    if(count($this->error)>0){
      return false;
    }else{
      return true;
    }
  }
}
?>
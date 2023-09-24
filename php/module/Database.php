<?php

class Database{
  public function __construct() {
    $dbServername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "practice-site";

    $this->connection = new mysqli($dbServername, $dbUsername, $dbPassword, $dbname);

    if ($this->connection->connect_error) {
      return "Connection failed: " . $this->connection->connect_error;
      die();
    }
  }

  function __destruct(){
    $this->connection->close();
  }

  public function runQuerry($query){
    try{
        return $this->connection->query($query);

    }catch(Exception $err){
      return  $err -> getMessage();
    }
  }

  public function findUserByUsername($username){
    $query = "SELECT username FROM users WHERE username='$username'";

    return $this -> runQuerry($query);
  }

  public function FindUserByEmail($email) {
    $query = "SELECT email FROM users WHERE email='$email'";

    return $this -> runQuerry($query);
  }

  public function SaveUser($username, $password, $email) {
    $passwordHash = md5($password);
    $randomHash = md5(random_bytes(25));

    $query = "INSERT INTO users (username, email, password, randomhash) VALUES ('$username', '$email', '$passwordHash', '$randomHash')";

    return $this -> runQuerry($query);
  }

  public function FindUserWIthUsernamePassword($username, $password) {
    $passwordHash = md5($password);
    
    $query = "SELECT username, email FROM users WHERE username='$username' AND password='$passwordHash'";

    return $this -> runQuerry($query);
  }

  public function ConfirmUserRegistration($randomHash) {
    $query = "UPDATE users SET confirmed=1 WHERE randomhash='$randomHash'";

    return $this -> runQuerry($query);
  }
}

?>
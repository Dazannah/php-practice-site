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

  public function runQuerry(){
    try{
      $result = $this->connection->query($this->query);

      if (!$result) {
        throw new Exception("Error executing the SQL query: " . $this->connection->error);
      }else{
        return $result;
      }
    }catch(Exception $err){
      return  $err;
    }
  }
}

class FindUserByUsername extends Database{
  function __construct($username) {
    parent::__construct();

    $this->query = "SELECT username FROM users WHERE username='$username'";
  }

  function __destruct(){
    parent::__destruct();
  }
}

class SaveUser extends Database{
    function __construct($username, $password, $email) {
      parent::__construct();

      $passwordHash = md5($password);
      $this->query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$passwordHash')";
  }

  function __destruct(){
    parent::__destruct();
  }
}

class FindUserWIthUsernamePassword extends Database{
  function __construct($username, $password) {
    parent::__construct();

    $passwordHash = md5($password);
    $this->query = "SELECT username, email FROM users WHERE username='$username' AND password='$passwordHash'";
}

  function __destruct(){
    parent::__destruct();
  }
}

?>
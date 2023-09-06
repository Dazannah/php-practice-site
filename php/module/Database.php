<?php

class Database{
  public function __construct() {
    $dbServername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "practice-site";

    $this->connection = new mysqli($dbServername, $dbUsername, $dbPassword, $dbname);

    if ($this->connection->connect_error) {
      return "Connection failed: " . $conn->connect_error;
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

class FindUser extends Database{
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

      $this->passwordHash = crypt($password, '$6$rounds=5000$salt$');
      $this->query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$this->passwordHash')";
  }

  function __destruct(){
    parent::__destruct();
  }
}

?>
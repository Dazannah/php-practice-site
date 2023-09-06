<?php

class Database{
  public function __construct($username, $password, $email) {
    $dbServername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "practice-site";


    $this->username = crypt($username, '$6$rounds=5000$salt$');
    $this->password = $password;
    $this->email = $email;

    $this->connection = new mysqli($dbServername, $dbUsername, $dbPassword, $dbname);

    if ($this->connection->connect_error) {
      return "Connection failed: " . $conn->connect_error;
      die();
    }

    $this->querry = "INSERT INTO users (username, email, password) VALUES ('$this->username', '$this->email', '$this->password')";
  }

  function __destruct(){
    $this->connection->close();
  }

  public function save(){
    if ($this->connection->query($this->querry) === TRUE) {
      echo "success";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
}

?>
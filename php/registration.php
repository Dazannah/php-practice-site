<?php

require_once("./module/User.php");

if(!isset($_POST["username"], $_POST["password"], $_POST["passwordAgain"], $_POST["email"])){
  header('Content-Type: application/json');

  echo json_encode(["All four fields are required."]);
  exit();
}

$username = $_POST["username"];
$password = $_POST["password"];
$passwordAgain = $_POST["passwordAgain"];
$email = $_POST["email"];

$registerUser = new RegisterUser($username, $email, $password, $passwordAgain);
$result = $registerUser->registrationProcess();

header('Content-Type: application/json');

echo json_encode($result);

?>
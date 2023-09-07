<?php

require_once("./module/ValidateRegistration.php");
require_once("./module/Database.php");

if(!isset($_POST["username"], $_POST["password"], $_POST["passwordAgain"], $_POST["email"])){
  header('Content-Type: application/json');

  echo json_encode(["All four fields are required."]);
  exit();
}

$username = $_POST["username"];
$password = $_POST["password"];
$passwordAgain = $_POST["passwordAgain"];
$email = $_POST["email"];

$validateRegistration = new ValidateRegistration($username, $password, $passwordAgain, $email);
$isUsernameAvailable = $validateRegistration->isUsernameTaken();
$isEmailAvailable = $validateRegistration->isEmailTaken();

if(!$isUsernameAvailable || !$isEmailAvailable){
  header('Content-Type: application/json');
  
  echo json_encode($validateRegistration->error);
  exit();
}

$isValidationOk = $validateRegistration->validate();

if($isValidationOk){
  header('Content-Type: application/json');
  
  echo json_encode($validateRegistration->error);
  exit();
}

$saveUser = new SaveUser($username, $password, $email);
$saveResult = $saveUser->runQuerry();

header('Content-Type: application/json');

echo json_encode($saveResult);

?>
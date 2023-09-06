<?php
require_once("./module/ValidateRegistration.php");
require_once("./module/Database.php");
//header("Location: /php-practice-site/public/home.html"); redirect the browser

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
$isValidationOk = $validateRegistration->validate();

if(!$isValidationOk){
  header('Content-Type: application/json');
  
  echo json_encode($validateRegistration->error);
  exit();
}

$database = new Database($username, $password, $email);
$saveResult = $database->save();

header('Content-Type: application/json');
//$response = "success";

$dataToSend = array("result" => $saveResult);
echo json_encode($dataToSend);

?>
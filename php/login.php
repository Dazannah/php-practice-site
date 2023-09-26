<?php 
require_once("./module/User.php");

if(!isset($_POST["username"], $_POST["password"])){
  header('Content-Type: application/json');

  echo json_encode(["Username and password field are required."]);
  exit();
}

$userInputs = (object) array(
  "username" => $_POST["username"],
  "password" => $_POST["password"]
);

$loginUser = new LoginUser($userInputs);
$fetchedData = $loginUser->loginProcess();

$user = new User($fetchedData);

session_start();

$_SESSION["user"] = $user;
header('Content-Type: application/json');

echo json_encode(array("status" => true));
exit();
?>
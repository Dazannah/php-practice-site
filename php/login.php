<?php 
require_once("./module/User.php");

if(!isset($_POST["username"], $_POST["password"])){
  header('Content-Type: application/json');

  echo json_encode(["Username and password field are required."]);
  exit();
}

$username = $_POST["username"];
$password = $_POST["password"];

$loginUser = new LoginUser($username, $password);
$fetchedData = $loginUser->loginProcess();

session_start();

$_SESSION["username"] = $fetchedData['username'];
$_SESSION["email"] = $fetchedData['email'];
header('Content-Type: application/json');

echo json_encode(array("status" => true));
exit();
?>
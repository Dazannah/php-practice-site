<?php 
require_once("./module/Database.php");

if(!isset($_POST["username"], $_POST["password"])){
  header('Content-Type: application/json');

  echo json_encode(["Username and password field are required."]);
  exit();
}

$username = $_POST["username"];
$password = $_POST["password"];

$findUserWIthUsernamePassword = new FindUserWIthUsernamePassword($username, $password);
$result = $findUserWIthUsernamePassword->runQuerry();

if(mysqli_num_rows($result) < 1){
  header('Content-Type: application/json');

  echo json_encode("Invalid username/password.");
  exit();
}
$fetchedData = $result->fetch_assoc();

session_start();

$_SESSION["username"] = $fetchedData['username'];
$_SESSION["email"] = $fetchedData['email'];
header('Content-Type: application/json');

echo json_encode(array("status" => true));
exit();
?>
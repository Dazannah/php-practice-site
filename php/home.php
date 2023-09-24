<?php 
require_once("./module/User.php");

session_start();

if(!isset($_SESSION['user'])){
  header('Location: /php-practice-site/index.html');
}

$user = $_SESSION['user'];
$username = $user -> username();
$email = $user -> email();

echo <<<EOT
You are loged in as $username<br>
And your email is: $email
<br><br>
<button onclick="window.location.href = '/php-practice-site/php/logout.php'">Logout</button>
EOT;


?>
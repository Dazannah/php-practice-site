<?php 
session_start();

if(!isset($_SESSION['username'])){
  header('Location: /php-practice-site/index.html');
}

echo <<<EOT
You are loged in as $_SESSION[username] <br>
And your email is: $_SESSION[email]
<br><br>
<button onclick="window.location.href = '/php-practice-site/php/logout.php'">Logout</button>
EOT;


?>
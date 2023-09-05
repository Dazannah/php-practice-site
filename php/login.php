<?php 

if($_POST["username"] === "" || $_POST["password"] === ""){
  header("Location: /php-practice-site/index.html");
}

echo $_POST["username"], $_POST["password"];
?>
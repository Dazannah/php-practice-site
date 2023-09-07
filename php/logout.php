<?php

  session_start();
  session_destroy();
  header('Location: /php-practice-site/index.html');
  
?>
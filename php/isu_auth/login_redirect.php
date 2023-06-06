<?php
  if(!($_SESSION['logged_in'])){
    header('Location: /~laptops/kasnick/pages/login.php');
    exit();
  }
?>

<?php
require("../../../config.php");

if(!isset($_SESSION['EDIT_PID']) || !isset($_SESSION['EDIT_TEXT'])){
  $_SESSION['edit_sticky_error'] = "Varible not set! Please try again!";
  header("Location: ../edit.php");
}else{
  $text = $_POST['text'];
  $postID = $_SESSION['EDIT_PID'];
}

try{
  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $data = [
            "message" => $text,
            "pid" => $postID
          ];

  $sql = "UPDATE hmsu_sa_eos
          SET MESSAGE=:message
          WHERE PID=:pid";

  $edit_post = $conn->prepare($sql);
  $edit_post->execute($data);
  $conn = null;

  unset($_SESSION['EDIT_TEXT']);
  unset($_SESSION['EDIT_PID']);

  $_SESSION['eos_success'] = "System successfully updated sticky-$postID";
  header("Location: ../");

}catch(PDOException $e) {
  $_SESSION['edit_sticky_error'] = $e->getMessage();
  header("Location: ../edit.php");
}

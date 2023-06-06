<?php
  require('../config.php');

function updateReadStatus($i){
  $currentuser = $_SESSION['user'];
  global $dbserv; global $dbname; global $dbuser; global $dbpass; global $datetime;
  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "insert into hmsu_sa_readreceipt (PID, USER, READ_DATETIME)
          values ('$i', '$currentuser', '$datetime')";

  $updateReceipts = $conn->prepare($sql);
  $updateReceipts->execute();
  $conn = null;

  $_SESSION['index_success'] = "You have successfully submitted an acknowledgement to post-$i";

  header("Location: ../index.php");
}

try{
  updateReadStatus($_POST['postID']);
}catch(PDOException $e) {
  $_SESSION['index_error'] = $e->getMessage();
  $conn = null;
}
?>

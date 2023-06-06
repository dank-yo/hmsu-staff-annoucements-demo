<?php
  require('../config.php');

  if(!isset($_POST['postID'])){
   header("Location: ../index.php");
   $_SESSION['index_error'] = "Unable to find postID";
 }else{
   $postID = $_POST['postID'];
   try{
     $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $sql_message = "SELECT TITLE, MESSAGE
                 FROM hmsu_sa_message
                 WHERE PID=:postID";

     $getPost = $conn->prepare($sql_message);
     $getPost->execute(["postID" => $postID]);
     $text = $getPost->fetchAll();
     $conn = null;
     
     $_SESSION['EDIT_TITLE'] = $text[0][0];
     $_SESSION['EDIT_TEXT'] = $text[0][1];
     $_SESSION['EDIT_PID'] = $postID;

     header("Location: ../pages/edit.php");

   }catch(PDOException $e) {
     $_SESSION['index_error'] = $e->getMessage();
     header("Location: ../index.php");
   }
 }
?>

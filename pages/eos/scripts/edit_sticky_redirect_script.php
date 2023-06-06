<?php
  require('../../../config.php');

  if(!isset($_POST['postID'])){
   $_SESSION['eos_error'] = "Unable to find the post to edit.";
   header("Location: ../");
 }else{
   $postID = $_POST['postID'];
   try{
     $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

     $sql_message = "SELECT MESSAGE
                 FROM hmsu_sa_eos
                 WHERE PID='$postID'";

     $getPost = $conn->prepare($sql_message);
     $getPost->execute();
     $text = $getPost->fetchAll();
     $conn = null;
     $_SESSION['EDIT_TEXT'] = $text[0][0];
     $_SESSION['EDIT_PID'] = $postID;

     header("Location: ../edit.php");

   }catch(PDOException $e) {
     $_SESSION['eos_error'] = $e->getMessage();
     header("Location: ../");
   }
 }
?>

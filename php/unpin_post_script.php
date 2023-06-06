<?php
require("../config.php");

try{
  if(isset($_POST['postID'])){
    $postID = $_POST['postID'];
    $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "UPDATE hmsu_sa_message SET PINNED=0 WHERE PID='$postID'";

    $getPosts = $conn->prepare($sql);
    $getPosts->execute();
    $messages = $getPosts->fetchAll();

    $conn = null;
    header("Location: ../index.php");
  }
}catch(PDOException $e) {
  $SESSION['error'] = "<p>[FATAL ERROR]: " . $e->getMessage() . "</p><p>[CODE]: " . $e->getCode() . "</p>";
  header("Location: ../index.php");
}

?>

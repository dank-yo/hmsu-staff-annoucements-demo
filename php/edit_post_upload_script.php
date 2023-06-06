<?php
require("../config.php");

try{
  if(isset($_SESSION['EDIT_PID'])){
    $title = $_POST['title'];
    $text = $_POST['text'];
    $postID = $_SESSION['EDIT_PID'];

    $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = [
              "title" => $title,
              "message" => $text,
              "UPDT_DATETIME" => $datetime,
              "postID" => $postID
    ];

    $sql = "UPDATE hmsu_sa_message
            SET TITLE=:title,
            MESSAGE=:message,
            UPDT_DATETIME=:UPDT_DATETIME
            WHERE PID=:postID";

    $edit_post = $conn->prepare($sql);
    $edit_post->execute($data);
    $conn = null;

    unset($_SESSION['EDIT_TITLE']);
    unset($_SESSION['EDIT_TEXT']);
    unset($_SESSION['EDIT_PID']);

    $_SESSION['index_success'] = "System successfully updated post-$postID";

    header("Location: ../index.php");
  }
}catch(PDOException $e) {
  $_SESSION['edit_post_error'] = $e->getMessage();
  header("Location: ../pages/edit.php");
}

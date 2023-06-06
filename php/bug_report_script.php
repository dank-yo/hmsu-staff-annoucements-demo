<?php
require('../config.php');
if(!empty($_POST['title']) && !empty($_POST['text'])) {
/*Setting Variables*/
$title = $_POST['title'];
$text = $_POST['text'];

$sql; $data; $PID;

#This is to get the current postID
function getPostID(){
  global $PID;
  return $PID;
}
#This is used to set the PostID
function setPostID($p){
  global $PID;
  $PID = $p;
}

#This is used to search the database for the last number used for postIDs
function searchPostID(){
  global $dbserv; global $dbname; global $dbuser; global $dbpass;
  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = 'select PID from hmsu_sa_bugreport order by PID desc';

  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $POSTIDS = $stmt->fetchAll();
  $conn = null;

  if($POSTIDS != NULL){
    $currentID = end($POSTIDS[0]);
    setPostID($currentID + 1);
  }else{
    setPostID(1);
  }
}

#This is the main upload function. Connects to TBH and Does all the work uploading
try{
  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  searchPostID();

  $data = [
    'PID' => getPostID(),
    'REPORTER' => $_SESSION['user'],
    'DATETIME' => $datetime,
    'TITLE' => $title,
    'MESSAGE' => $text
  ];

  $sql = "insert into hmsu_sa_bugreport (PID, REPORTER, DATETIME, TITLE, MESSAGE)
          values (:PID, :REPORTER, :DATETIME, :TITLE, :MESSAGE)";

  $stmt = $conn->prepare($sql);
  $stmt->execute($data);
  $conn = null;

  header('Location: ../index.php');

}catch(PDOException $e){
  echo "failed: " . $e->getMessage();
  $conn = null;
  header("Location: ../pages/bugreport.php");
}
}else{
  $error = "Error: Please fill in all the fields!";
  $_SESSION["error"] = $error;
  header("Location: ../pages/bugreport.php");
}
?>

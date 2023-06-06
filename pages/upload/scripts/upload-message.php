<?php
require('../../../config.php');

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

  $sql = 'select PID from hmsu_sa_message order by PID desc';

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

if(!empty($_POST['title']) && !empty($_POST['text'])) {
  /*Setting Variables*/
  $title = $_POST['title'];
  $text = $_POST['text'];

  $PID;


  #This is the main upload function. Connects to TBH and Does all the work uploading
  try{
    searchPostID();

    $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $data = [
      'PID' => getPostID(),
      'PINNED' => 0,
      'PUBLISHER' => $_SESSION['firstlast'],
      'OG_DATETIME' => $datetime,
      'TITLE' => $title,
      'MESSAGE' => $text
    ];

    $sql = "insert into hmsu_sa_message (PID, PINNED, PUBLISHER, OG_DATETIME, TITLE, MESSAGE)
            values (:PID, :PINNED, :PUBLISHER, :OG_DATETIME, :TITLE, :MESSAGE)";

    $stmt = $conn->prepare($sql);
    $stmt->execute($data);

    $data = [
      'PID' => getPostID(),
      'USER' => $_SESSION['user'],
      'READ_DATETIME' => $datetime
    ];

    $sql = 'insert into hmsu_sa_readreceipt (PID, USER, READ_DATETIME)
            values (:PID, :USER, :READ_DATETIME)';

    $stmt = $conn->prepare($sql);
    $stmt->execute($data);

    $conn = null;

    $_SESSION['success'] = "Message successfully uploaded!";
    header('Location: ../../../');

  }catch(PDOException $e){
    $_SESSION["error"] = "[Error]" . $e->getMessage();
    $conn = null;
    header("Location: ../");
  }

}else{
  $_SESSION["error"] = "Error: Please fill in all the fields!";
  header("Location: ../");
}
?>

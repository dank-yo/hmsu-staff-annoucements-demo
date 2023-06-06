<?php
require('../../../config.php');
runLoginCheck('../../../');

if(!empty($_POST['text'])) {
$text = $_POST['text'];

$PID;

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

  $sql = 'select PID from hmsu_sa_eos order by PID desc';

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

function cleanInput($input) {
  $search = array(
                 '@<script[^>]*?>.*?</script>@si',   // Removes Javascript
                 '@<style[^>]*?>.*?</style>@siU',    // Remove CSS tags
                 '@<![\s\S]*?--[ \t\n\r]*>@'         // Remove Comments
                 );
  $output = preg_replace($search, '', $input);
  return $output;
}

#This is the main upload function. Connects to TBH and Does all the work uploading
try{
  searchPostID();

  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $data = [
    'PID' => getPostID(),
    'portalID' => $_SESSION['user'],
    'PUBLISHER' => $_SESSION['firstlast'],
    'DATE' => $date,
    'TIME' => $time,
    'TAG' => $_SESSION['groups'],
    'MESSAGE' => cleanInput($text)
  ];

  $sql = "insert into hmsu_sa_eos (PID, portalID, PUBLISHER, DATE, TIME, TAG, MESSAGE)
          values (:PID, :portalID, :PUBLISHER, :DATE, :TIME, :TAG, :MESSAGE)";

  $stmt = $conn->prepare($sql);
  $stmt->execute($data);

  $conn = null;

  $_SESSION["eos_success"] = 'Created sticky!';

  header('Location: ../index.php');

}catch(PDOException $e){
  $_SESSION["upload_eos_error"] = $e->getMessage();
  $conn = null;
  header("Location: ../upload.php");
}

}else{
  $conn = null;
  $_SESSION["upload_eos_error"] = "Please fill in all the fields!";
  header("Location: ../upload.php");
}
?>

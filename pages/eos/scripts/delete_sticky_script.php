<?php
//MUST RUN FIRST
require('../../../config.php');
?>
<head>
  <?php setPageHead('HMSU SA | Redirecting...'); ?>
</head>

<?php
if(!isset($_POST['postID'])){
 $_SESSION['eos_error'] = "The postID associated is not valid. Please try again. If this issue persists, please contact an administrator.";
 header("Location: ../index.php");
}

try{
  $postID = $_POST['postID'];
  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "DELETE FROM hmsu_sa_eos WHERE PID=$postID";

  $request = $conn->prepare($sql);
  $request->execute();

  $conn = null;

  $_SESSION['eos_success'] = 'Sticky-' . $postID . ' deleted!';
  header("Location: ../index.php");

}catch(PDOException $e) {
  $_SESSION['eos_error'] = $e->getMessage();
  header("Location: ../index.php");
}

?>

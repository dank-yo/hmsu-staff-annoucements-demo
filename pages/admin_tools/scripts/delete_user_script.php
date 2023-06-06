<?php
/*  This page is responsible for dropping a user from the hmsu_sa_users table when
    an admin clicks on the trash can icon.

*/

//MUST LOAD FIRST!
require('../../../config.php');
runAllChecks("../../../");
?>

<!-- HTML HEAD -->
<!doctype html>
<head>
  <?php setPageHead("HMSU SA | Redirecting..."); ?>
</head>

<?php
if(empty($_POST['sqlid'])){
  $_SESSION['view_users_error'] = 'User not found! Try again!';
  header("Location: ../view_users.php");
}else{
  $sqlid = $_POST['sqlid'];
  echo 'SQL ID: ' . $sqlid . '<br>';
}

try{
   $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   
   $sql = "DELETE FROM hmsu_sa_users WHERE id=:id";


   $stmt = $conn->prepare($sql);
   $stmt->execute(['id' => $sqlid]);

   $conn = null;

   $_SESSION['view_users_success'] = 'User ID ' . $sqlid . ' deleted from the database!';
   
   header("Location: ../view_users.php");

 }catch(PDOException $e) {
   $_SESSION['view_users_error'] = $e->getCode() . " " . $e->getMessage();
   header("Location: ../view_users.php");
 }

?>

<?php
/*    This page is resonsible for taking the postID from the $_POST array and
      deleting that specific post from the database.
*/
//MUST RUN FIRST
require('../config.php');
?>

<head>
  <?php setPageHead('HMSU SA | Redirecting...'); ?>
</head>

<?php
if(!isset($_POST['postID'])){
 header("Location: ../index.php");
 $_SESSION['index_error'] = "";
}else{
 $postID = $_POST['postID'];
 try{
   $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   $sql_message = "DELETE FROM hmsu_sa_message
               WHERE PID=$postID";

   $deletePost = $conn->prepare($sql_message);
   $deletePost->execute();

   $sql_message = "DELETE FROM hmsu_sa_readreceipt
                   WHERE PID=$postID";

   $deletePost = $conn->prepare($sql_message);
   $deletePost->execute();

   $conn = null;

   $_SESSION['index_success'] = "Post: $postID successfully deleted!";

   header("Location: ../index.php");

 }catch(PDOException $e) {
   $_SESSION['index_error'] = $e->getMessage();
   header("Location: ../index.php");
 }
}
?>

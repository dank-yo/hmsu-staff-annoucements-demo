<?php
/*  This file is the first php script for editing users. This script is responsible
    for taking the selected users, gathering the user information from the user database
    and redirecting that information to the modify_user.php page inputs. Done under session variables.

    -$_SESSION['edit_user']
*/
require('../../../config.php');
runAllChecks("../../../");
?>
<!doctype html>
<head>
<?php setPageHead("HMSU SA | Database Users"); ?>
</head>

<?php
if(empty($_POST['sqlid'])){
  $_SESSION['view_users_error'] = 'Error! User not found! Try again!';
  header("Location: ../view_users.php");
  exit();
}else{
  $sqlid = $_POST['sqlid'];
  $_SESSION['edit_sqlid'] = $sqlid;
}

try {
  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "SELECT * FROM hmsu_sa_users WHERE id=:id LIMIT 1";

  $getInfo = $conn->prepare($sql);
  $getInfo->execute(['id' => $sqlid]);
  $results = $getInfo->fetchAll();

  $conn = null;

  $_SESSION["edit_user"] = $results[0];
  header("Location: ../modify_user.php");
}catch(PDOException $e) {
  $_SESSION['view_users_error'] = $e->getCode() . $e->getMessage();
  header("Location: ../view_users.php");
}
?>

<?php
/* This file is responsible for adding the user to the database table `HMSU_SA_USERS`
   after filing out the information on the modify_user.php page. Following functions
   can be found in this file.

   - generateSQLid() -> Responsible for checking the database table and returning
   the id number in the database. The function then adds 1 to that number and returns
   as an interger.

   -{__main__} -> checks to make sure variables have been posted,
   appends all of the $_POST variables to the $data array then runs an SQL
   command. Finally sets a notification session variable and redirects.

*/
require('../../../config.php');
runAllChecks("../../../");
?>

<!doctype html>
<head>
  <?php setPageHead('HMSU SA | Redirecting...'); ?>
</head>

<?php
function generateSQLid(){
  global $dbserv; global $dbname; global $dbuser; global $dbpass;
  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //This checks the last ID used in the database and incriments it by 1.
  $sql = "SELECT id FROM hmsu_sa_users ORDER BY ID DESC LIMIT 1";

  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->fetchAll();

  $conn = null;

  //Newly generated SQL database ID, which is the primary key.
  return(intval($result[0]['id'] + 1));
}

if(empty($_POST['portal_id'])){
  $_SESSION['error'] = 'User not found! Try again!';
  header("Location: ../modify_user.php");
}else{
  $sqlID = generateSQLid();
  $student_id = $_POST['student_id'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $portal_id = $_POST['portal_id'];
  $role = $_POST['role'];
  $group = $_POST['group'];
  $active = $_POST['active'];
  echo "Student ID: " . $student_id . "<br>Firstname: " . $firstname . "<br>Lastname: " .
       $lastname . "<br>Portal ID: " . $portal_id . "<br>Role: " . $role . "<br>Active: " . $active;
}

try{
  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $data = [
    'id' => $sqlID,
    'student_id' => $student_id,
    'firstname' => $firstname,
    'lastname' => $lastname,
    'portal_id' => $portal_id,
    'role' => $role,
    'active' => $active,
    'groups' => $group,
    'lastlogin' => '0000-00-00 00:00:00'
  ];

  $sql = "INSERT INTO hmsu_sa_users (id, student_id, firstname, lastname, portal_id, role, isActive, groups, lastlogin)
          VALUES (:id, :student_id, :firstname, :lastname, :portal_id, :role, :active, :groups, :lastlogin)";

  $stmt = $conn->prepare($sql);
  $stmt->execute($data);
  $conn = null;

  $_SESSION['success'] = "$firstname added to the user list.";
  header("Location: ../modify_user.php");

}catch(PDOException $e) {
  $_SESSION['error'] = $e->getCode() . " " . $e->getMessage();
  header("Location: ../modify_user.php");
}
?>

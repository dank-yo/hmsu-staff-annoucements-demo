<?php
/*  This file is responsbile for modifying the user table when someone selects
    a user to edit from the view_users.php user table.

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
if(empty($_POST['portal_id'])){
  $_SESSION['modify_user_error'] = 'User not found! Try again!';
  header("Location: ../modify_user.php");
}else{
  $sqlid = $_SESSION['edit_sqlid'];
  $student_id = $_POST['student_id'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $portal_id = $_POST['portal_id'];
  $role = $_POST['role'];
  $group = $_POST['group'];
  $active = $_POST['active'];
  echo  "Student ID: " . $student_id . 
        "<br>Firstname: " . $firstname . "<br>Lastname: " .
        $lastname . "<br>Portal ID: " . $portal_id . "<br>Role: " . $role . 
      "<br>Group: " . $group . "<br>Active: " . $active . "<br>SQLID: " . $sqlid;

}

try{
  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $data = [
    'student_id' => $student_id,
    'firstname' => $firstname,
    'lastname' => $lastname,
    'portal_id' => $portal_id,
    'role' => $role,
    'active' => $active,
    'group' => $group,
    'sqlid' => intval($sqlid)
  ];

  $sql = "update hmsu_sa_users set 
          student_id=:student_id, 
          firstname=:firstname, 
          lastname=:lastname, 
          portal_id=:portal_id, 
          isActive=:active, 
          groups=:group, 
          role=:role
          where id=:sqlid";

  $stmt = $conn->prepare($sql);
  $stmt->execute($data);
  $conn = null;

  $_SESSION['modify_user_success'] = "$firstname has been updated in the user table.";
  unset($_SESSION['edit_user']);
  header("Location: ../modify_user.php");

}catch(PDOException $e) {
  $_SESSION['modify_user_error'] = $e->getCode() . " " . $e->getMessage();
  header("Location: ../modify_user.php");
}
?>

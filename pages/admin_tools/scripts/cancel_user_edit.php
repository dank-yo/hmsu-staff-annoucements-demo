<?php
/*  This file is responsbible for canceling the user edit variables. Very simple,
    it checks if the session variable is set, unsets it, then redirects the user
    back to the modify_user page.
*/
require('../../../config.php');
runAllChecks("../../../");
?>

<!doctype html>
<html>

<head>
<?php setPageHead("HMSU SA | Modify User"); ?>
</head>


<?php
if(isset($_SESSION['edit_user'])){
  unset($_SESSION['edit_user']);
}
$_SESSION['modify_user_success'] = 'User variables cleared from the cache.';
header("Location: ../modify_user.php");
?>

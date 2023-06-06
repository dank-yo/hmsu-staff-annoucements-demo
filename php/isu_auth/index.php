<!doctype html>
<?php
  require('../../config.php');
  runAllChecks('../../');
  checkNotificationMessage();
  header("Location: ../../")
 ?>

 <head>
   <?php setPageHead("HMSU SA Demo | Youre not supposed to be here"); ?>
 </head>

<?php unsetNotificationMessage(); ?>
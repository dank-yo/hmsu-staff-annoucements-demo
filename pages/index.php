<!doctype html>
<?php
  require('../config.php');
  runAllChecks('../');
  header("Location: ../")
 ?>

 <head>
   <?php setPageHead("HMSU SA | Admin Tools"); ?>
 </head>

 <body>
   <?php createPageNavBar(); ?>
   <div class="offcanvas offcanvas-start bg-dark text-white" id="menu">
     <?php displayOffCanvasMenu(); ?>
   </div>
   <div class="container text-center">
     <div class='p-2 m-2 w-100 text-center justfy-content-center'>
       <img src="" alt = "Pages" width='256px'></img>
     </div>
     <?php checkNotificationMessage(); ?>
     <div class='p-2 m-2 w-100 text-center justfy-content-center'>
       <a href='' type='button' class='btn btn-dark m-2'>
         <img src="img/title/view-staff-users.png" alt="View Staff Users" width='256px'></img>
       </a>
       <a href='' type='button' class='btn btn-dark m-2'>
         <img src="img/title/view-bug-reports.png" alt="View Bug Reports" width='256px'></img>
       </a>
       <a href='' type='button' class='btn btn-dark m-2'>
         <img src="img/title/phpMyAdmin.png" alt="phpMyAdmin" width='256px'></img>
       </a>
       <a href='' type='button' class='btn btn-dark m-2'>
         <img src="img/title/add-modify-users.png" alt="Modify User" width='256px'></img>
       </a>
     </div>
   </div>
   </div>
 </body>
</html>
<?php unsetNotificationMessage(); ?>
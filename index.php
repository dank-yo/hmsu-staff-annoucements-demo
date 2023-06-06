<?php
/*  This is the home page of the webapp.

*/
// MUST RUN FIRST!
require('config.php');
runLoginCheck();
//updateLastLogin($_SESSION['user']);
$_SESSION['lastlogin'] = $datetime;
?>

<!doctype html>
<html>
<head>
  <?php setPageHead("HMSU SA Demo | Home"); ?>
</head>

<body>
  <?php createPageNavBar(); ?>
  <div class="offcanvas offcanvas-start bg-dark text-white " id="menu">
    <?php displayOffCanvasMenu(); ?>
  </div>

  <div class="container bg-white">
    <!--CONTENT GETS DISPLAYED HERE -->
    <br>
    <?php checkNotificationMessage(); ?>

    <div class="justify-content-left" style="margin: 10px;">
        <?php
        //The original script is in create view. This is the function to call everything from the database and display it on the main page.
        require_once('php/getAnnoucements.php');
        __main__();
        ?>
        <br><br>
        <p class='text-center' style='font-size: 10px'><em>HMSU Staff Annoucements [Demo] - 2023 <br> Daniel Kasnick</em></p><br>
    </div>
  </div>
</body>
</html>
<?php unsetNotificationMessage(); ?>

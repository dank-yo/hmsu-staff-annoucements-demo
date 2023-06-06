<?php
/*    This page is the HTML document that is responsible for creating a valid post
      forum for administrators to create uploads for.

*/
//MUST RUN FIRST
require('../config.php');
runLoginCheck('../');
?>

<!doctype html>
<html>
  <head>
    <?php setPageHead("HMSU SA | About"); ?>
  </head>

  <body>
    <?php createPageNavBar(); ?>
  <div class="offcanvas offcanvas-start bg-dark text-white" id="menu">
    <?php displayOffCanvasMenu(); ?>
  </div>
  <div class="container">
    <div class='p-2 m-2 w-100 text-center'>
      <img src="img/logo/hmsu-logo-dark.png" alt = "About" style='min-width: 20%; max-width: 10%;'></img>
      <p>HMSU™ Staff Annoucements</p>
      <p><?php echo $version; ?></p>
      <p>by:</p>
      <p>Daniel Kasnick</p>
    </div>
    <!--CONTENT GETS DISPLAYED HERE -->
  </div>
</body>
</html>

<!doctype html>
<?php
/*    This page is the HTML document that is responsible for creating a valid post
      forum for administrators to create uploads for.

*/
//MUST RUN FIRST
require('../../config.php');
runLoginCheck('../../');
require('scripts/eos_view.php');

?>

<html>
<head>
  <?php setPageHead("HMSU SA | EOS Bulletin"); ?>
</head>

<body>
  <?php createPageNavBar(); ?>
  <div class="offcanvas offcanvas-start bg-dark text-white" id="menu">
    <?php displayOffCanvasMenu(); ?>
  </div>
  <div class="container">
    <div class='p-2 m-2 w-100 text-center'>
      <img src="img/title/sticky-bulletin.png" alt = "Sticky Bulletin" class='w-25 m-0 p-0'></img>
    </div>
    <div class='m-0 p-0 w-100 text-right'>
      <a class='btn btn-dark m-1 p-1 font-italic justify-right' href='pages/eos/upload.php'>Create note</a>
      <br><br>
    </div>
    
    <!--CONTENT GETS DISPLAYED HERE -->
    <?php displayEOS(); ?>

  </div>
</body>
</html>
<?php

?>

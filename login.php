<?php
require('config.php');
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
  $_SESSION['error'] = 'You are already logged in!';
  header("Location: ./");
}
?>

<html>
  <head>
    <?php setPageHead("HMSU SA Demo | Login"); ?>
  </head>

  <body>
    <div class="container">
      <div class="d-flex justify-content-center" style="margin: 10px; text-align: center;">
        <div class="p-2" style="width: 100%; display:inline-block; margin: 10px;">
          <img src="img/logo/hmsu-logo-dark.png" alt = "HMSU Logo" width=15%></img>
          <img src="img/logo/hmsu-sa-title-dark.png" alt = "Staff Annoucements" width=65%></img>
        </div>
      </div>
      <?php require_once('shell/notifications.php'); checkNotificationMessage(); ?>
      <div class="d-flex justify-content-center" style="margin: 10px;">
        <div class="p-2">
          <form method = "post" action ="./php/isu_auth/authenticate.php">
            <div class="mb-3 form-control-sm">
              <label class="form-label">Username: </label>
              <input id='user-input' type="username" class="form-control" name="user" disabled>
            </div>
            <div class="mb-3 form-control-sm">
              <label class="form-label">Password: </label>
              <input id='passwd-input' type="password" class="form-control" name="pass" disabled>
            </div>
            <button id='login-submit' type='submit' class='btn btn-dark' style='margin-left: 8px;' disabled>Login</button>
            <button id='login-submit' type='submit' class='btn btn-dark' style='margin-left: 8px;'>Continue as Guest</button>
          </form>
        </div>
        </div>
      </div>
    </div>
  </body>
</html>

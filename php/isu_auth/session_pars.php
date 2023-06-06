<?php
  session_set_cookie_params(0, "", "", true, true);
  if( session_id() == "" ) {
    session_start();
  }
  setcookie(session_name(),session_id(), 0, "", "", true, true);
?>

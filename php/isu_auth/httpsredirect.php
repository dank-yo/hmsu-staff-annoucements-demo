<?php
// Redirect HTTP to HTTPS
if ($_SERVER["SERVER_PORT"] != 443) {
  $newURL = "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
  header("location: $newURL");
}
?>
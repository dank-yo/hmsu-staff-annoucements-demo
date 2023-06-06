<?php 
require('../../config.php');

if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $clientIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $clientIP = $_SERVER['REMOTE_ADDR'];
}

$_SESSION['firstname'] = 'Daniel';
$_SESSION['lastname'] = 'Kasnick';
$_SESSION['user'] = 'dkasnick';
$_SESSION['role'] = 'admin';
$active = 1;
$_SESSION['groups'] = 'PGMR';
$_SESSION['logged_in'] = true;

$_SESSION['firstlast'] = $_SESSION['firstname'] . " " . $_SESSION['lastname'];
$_SESSION['lastlogin'] = date('Y-m-d h:i A');

$_SESSION['query_col'] = 0;
$_SESSION['query_range'] = 10;
$_SESSION['page_no'] = 1;
$_SESSION['success'] = "You are now logged in as: " . $_SESSION['firstlast'];
header("Location: ../../");

?>

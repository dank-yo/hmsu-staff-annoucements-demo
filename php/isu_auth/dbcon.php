<?php

// database connection config
$dbHost = 'localhost';
$dbUser = 'laptops';
$dbPass = 'LPTcheckout';
$dbName = 'laptops';

$dbcon = mysqli_connect ($dbHost, $dbUser, $dbPass) or die ('MySQL connect failed. ' . mysql_error());

mysqli_select_db($dbcon, $dbName) or die('Cannot select database. ' . mysql_error());

?>

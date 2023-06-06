<?php
/*  This file is the default website configuration for everyone. This file holds
    database credentials as well as other default website variables and functions.

    - default global session.

    - $dbserv, $dbname, $dbuser, $dbpass -> database credentials

    - default date/time set to Indiana/Vincennes
    - $datetime, $date, and $time are all global date/time variables

    - runLoginCheck($path) -> This checks if the user is logged in, if the user
    fails the check they are redirected to the $path directory.

    - runPrivilegeCheck($path) -> this checks if the user has priviliges to go to
    certian pages or run certian actions. Redirected to the $path directory if not.

    - runAllChecks($path) -> loader for all variable checkers. uses $path to redirect
    to correct directory.

*/
session_start();

#inject shell
require('shell/menu.php');
require('shell/notifications.php');

/* Global Database Variables */
$dbserv = '127.0.0.1';
$dbname = 'laptops';
$dbuser = 'root';
$dbpass = '';

$version = 'demo-2.0.1';


/*Global Date/Time Variables*/
date_default_timezone_set('America/Indiana/Vincennes');
$datetime = date('Y-m-d h:i A');
$date = date('Y-m-d');
$time = date('h:i A');

/* This function is there to check if a user is currently logged in */
function runLoginCheck($path=""){
  if(!isset($_SESSION['logged_in'])){
    $_SESSION['login_error'] = "You are not logged in!";
    header("Location: " . $path . "login.php");
  }
}

/* This function is there to check if any user has proper priviliges for an action*/
function runPrivilegeCheck($path){
  if($_SESSION['role'] != 'admin' || $_SESSION['role'] == 'user'){
      $_SESSION['error'] = "You do not have priviliges for that!";
      header("Location: " . $path . "index.php");
  }
}

function runAllChecks($txt){
  runLoginCheck($txt);
  runPrivilegeCheck($txt);
}

/*This is used in every web page*/
function setPageHead($text){
  echo "<title>".$text."</title>
        <link rel='shortcut icon' type='image/x-icon' href='img/logo/fav-icon.ico'>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <base href='http://127.0.0.1/hmsu-sa-demo/'>
        <!-- Latest compiled and minified CSS -->
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css' rel='stylesheet'>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js'></script>
        <!-- Latest compiled JQUERY -->
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>

        <!-- Default Stylesheet [Must load after bootstrap] -->
        <link rel='stylesheet' href='theme/default/css/style.css'>";
}

/*This is the navigation header at the top of every page*/
function createPageNavBar(){
  echo '<div class="d-flex justify-content-start bg-dark text-white text-center">
          <div class="p-2" style="display: flex; align-items: center; justify-content: left;">
            <a style="none" data-bs-toggle="offcanvas" data-bs-target="#menu">☰</a>
          </div>
          <div class="p-2 w-100 text-center">
            <img src="img/logo/hmsu-logo.png" alt = "HMSU Logo" width=7% ></img>
            <img src="img/logo/hmsu-sa-title.png" alt = "Staff Annoucements" width=35%></img>
          </div>
        </div>';
}

/** Last Login Script **/
function updateLastLogin($user){
  global $dbserver; global $dbname; global $dbuser; global $dbpass; global $datetime;
  $conn = new PDO("mysql:host=$dbserver;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $data = [ 'user' => $_SESSION['user'],
            'datetime' => $datetime
  ];

  $sql = "update hmsu_sa_users
          set lastlogin = :datetime
          where portal_id = :user";

  $stmt = $conn->prepare($sql);
  $stmt->execute($data);

  $conn = null;
}

function getDatabaseCount(){
  try {
    global $dbserv; global $dbname; global $dbuser; global $dbpass;
    $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT count(*) FROM hmsu_sa_message";

    $res = $conn->query($sql);
    $count = $res->fetchColumn();

    $conn = null;

    return $count;

  }catch(PDOException $e) {
    echo "[FATAL ERROR]: " . $e->getMessage();
    echo "[CODE]: " . $e->getCode();
  }
}

?>

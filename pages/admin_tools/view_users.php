<?php
/* This file is the main HTML document for the admin tool view_users.php
   This file contains a few scripts that pertain to the
*/
require('../../config.php');
runAllChecks('../../');
?>

<!doctype html>
<head>
<?php setPageHead("HMSU SA | Database Users"); ?>
</head>

<?php
function getUsers(){
  try {
    global $dbserv; global $dbname; global $dbuser; global $dbpass;
    $conn = new PDO("mysql:host=$dbserv;dbname=$dbname",$dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT *
            FROM hmsu_sa_users
            ORDER BY role ASC";

    $getPosts = $conn->prepare($sql);
    $getPosts->execute();
    $users = $getPosts->fetchAll();

    $conn = null;

    return $users;

  }catch(PDOException $e) {
    echo "[FATAL ERROR]: " . $e->getMessage();
    echo "[CODE]: " . $e->getCode();
  }
}

function displayUsers($array){
  if(count($array) > 0){
    echo "<div class='d-flex w-100'>
          <table class='table table table-dark table-striped table-hover'>
            <thead>
              <tr>
                <th>Firstname:</th>
                <th>Lastname:</th>
                <th>Username:</th>
                <th>Role:</th>
                <th>Group:</th>
                <th style='width:15%'>Last-Login:</th>
                <th style='text-align: center;'>Options: </th>
              </tr>
            </thead>
            <tbody>";
            for($j = 0; $j < count($array); $j++){
              $sqlid = $array[$j]['id'];
              $firstname = $array[$j]['firstname'];
              $lastname = $array[$j]['lastname'];
              $portal_id = $array[$j]['portal_id'];
              $role = $array[$j]['role'];
              $group = $array[$j]['groups'];
              $lastlogin = $array[$j]['lastlogin'];
              echo"<tr>
                    <td>" . $firstname ."</td>
                    <td>" . $lastname ."</td>
                    <td>" . $portal_id ."</td>
                    <td>" . $role ."</td>
                    <td>" . $group . "</td>
                    <td>" . $lastlogin ."</td>
                    <td><div class='d-flex justify-content-center'>
                    <form method = 'post' action = 'pages/admin_tools/scripts/edit_user_redirect_script.php'>
                      <input type='submit' name='editUser' class='btn btn-outline-dark p-0 m-0' value='🖊'></input>
                      <input type='hidden' name='sqlid' value='$sqlid'></input>
                    </form>
                    <form method = 'post' action = 'pages/admin_tools/scripts/delete_user_script.php'>
                      <input type='submit' name='$buttonDeleteID' class='btn btn-outline-dark p-0 m-0' value='🗑️'></input>
                      <input type='hidden' name='sqlid' value='$sqlid'></input>
                    </form></div></td>
                  </tr>";
              }
          echo "</tbody>
              </table>
            </div>";
  echo '
    <div class="form-check form-switch">
      <input class="form-check-input disabled" type="checkbox" id="flexSwitchCheckCheckedDisabled" checked disabled>
      <label class="form-check-label disabled" for="flexSwitchCheckCheckedDisabled">Show Inactive Users</label>
    </div>';
  }else{
    echo "<div class='row' style='display:inline-block; text-align: center; margin: 10px; width: 100%'>";
    echo "<div class='col' syle='text-align: center; width: 100%'><h1>No Users Found!</h1></div>";
  }
  echo "<hr style = '1px solid #afafaf'>";
}

function main(){
  $user_list = getUsers();
  displayUsers($user_list);
}

?>

<body>
 <?php createPageNavBar(); ?>
 <div class="offcanvas offcanvas-start bg-dark text-white" id="menu">
   <?php
       require_once('../../shell/menu.php');
       displayOffCanvasMenu(); ?>
 </div>
 <div class="container">
    <div class='p-2 m-2 w-100 text-center'>
      <img src="img/title/user-table.png" alt = "User Table" class='w-25'></img>
    </div>
    <?php require_once('../../shell/notifications.php'); checkNotificationMessage(); ?>
    <div class="p-2 m-2 w-100">
     <!-- PHP HOOK GOES HERE -->
     <?php main(); ?>
    </div>
 </div>
</body>

<?php require_once('../../shell/notifications.php'); unsetNotificationMessage(); ?>
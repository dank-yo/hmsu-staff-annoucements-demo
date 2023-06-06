<?php
/*  This file is part of the admin tools toolbox. This is the HTML page.
    This page is responsible for managing the user table. This page actually
    serves as the add/edit user page. If an admin is redirected to this page
    from the user view tool, this page will run the correct scripts to properly
    update the table.

    - $_SESSION VARIABLES -> ['edit_user', 'modify_user_success', 'modify_user_error']


*/

//MUST LOAD FIRST BEFORE ANYTHING ELSE
require('../../config.php');
runAllChecks("../../");
?>

<!doctype html>
<html>

<head>
<?php setPageHead("HMSU SA | Modify User"); ?>
</head>

<?php
/*  This checks if edit_user is a flagged session variable. If so it will set
    the html code accordingly.
*/
if(isset($_SESSION['edit_user'])){
  $form_redirect = './pages/admin_tools/scripts/edit_user_script.php';
  $button_text = 'Submit Edit';
}else{
  $form_redirect = './pages/admin_tools/scripts/add_user_script.php';
  $button_text = 'Add User';
}

?>

<body>
  <?php createPageNavBar(); ?>
  <div class="offcanvas offcanvas-start bg-dark text-white" id="menu">
  <?php displayOffCanvasMenu(); ?>
  </div>

  <div class="container">
  <div class='p-2 m-2 w-100 text-center'>
    <img src="img/title/modify-user.png" alt = "Modify User" class='w-25 text-center'></img>
  </div>
  <div>
  <?php checkNotificationMessage(); ?>
  </div>
  <form class='p-2 m-2' method="post" action="<?php echo $form_redirect; ?>">

    <div class="input-group mb-3 input-group-sm" >
      <span class="input-group-text">Student 991</span>
      <input type="text" class="form-control" name="student_id" value="<?php if(isset($_SESSION['edit_user'])){echo $_SESSION['edit_user']['student_id'];}?>">
    </div>

    <div class="input-group mb-3 input-group-sm">
      <span class="input-group-text">First Name</span>
      <input type="text" class="form-control" name="firstname" value="<?php if(isset($_SESSION['edit_user'])){echo $_SESSION['edit_user']['firstname'];}?>">
    </div>

    <div class="input-group mb-3 input-group-sm">
      <span class="input-group-text">Last Name</span>
      <input type="text" class="form-control" name="lastname" value="<?php if(isset($_SESSION['edit_user'])){echo $_SESSION['edit_user']['lastname'];}?>">
    </div>
  
    <div class="input-group mb-3 input-group-sm">
      <span class="input-group-text">Portal ID</span>
      <input type="text" class="form-control" name="portal_id" value="<?php if(isset($_SESSION['edit_user'])){echo $_SESSION['edit_user']['portal_id'];}?>">
    </div>

    <div class='row'>

      <!-- Role Dropdown -->
      <div class="col form-group">
        <label for="role">Role: </label>
        <select class="form-control" name="role">
          <?php if(isset($_SESSION['edit_user']) && $_SESSION['edit_user']['role'] == 'admin'){
            echo "<option>admin</oDefaulttion>
                  <option>user</option>";
          }else{
            echo "<option>user</option>
                  <option>admin</option>";
          }
          ?>
        </select>
      </div>

      <!-- Group Dropdown -->
      <div class="col form-group">
        <label for="active">Group: </label>
        <select class="form-control" name="group">
        <?php 
          $groups = array('DESK', 'SBT', 'PGMR', 'SPVS');
          if(isset($_SESSION['edit_user'])){
            echo "<option>".$_SESSION['edit_user']['groups']."</option>";
          }
          for($i=0;$i<count($groups); $i++){
            if($groups[$i]!=$_SESSION['edit_user']['groups'])
              {echo "<option>".$groups[$i]."</option>";}
          }
          
            ?>
        </select>
      </div>

      <!-- Active Dropdown -->
      <div class="col form-group">
        <label for="active">Active: </label>
        <select class="form-control" name="active">
          <option>1</option>
          <option>0</option>
        </select>
      </div>
    </div>
    <br>
    <button type='submit' class='btn btn-dark'><?php echo $button_text;?></button>

  <?php if(isset($_SESSION['edit_user'])){
    $button = "<a href='./pages/admin_tools/scripts/cancel_user_edit.php' type='button' class='btn btn-dark'>Clear</a>";
    echo $button;
  }
  ?>

  </form>
  <hr>
  </div>
</body>
</html>
<?php unsetNotificationMessage(); ?>
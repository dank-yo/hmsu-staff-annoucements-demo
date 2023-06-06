<?php 

function displayOffCanvasMenu(){
  echo "<div class='offcanvas-header text-light'>
            <h2 class='offcanvas-title'>Menu</h2>
            <button  class='btn-close btn-close-white' data-bs-dismiss='offcanvas'></button>
        </div>
        <div class='offcanvas-body'>
          <div class='d-flex justify-content-left'>
            <div class='p-2'>
              <label> You are logged in as: </label>
              <p>" . $_SESSION['firstlast'] . " </p>
              <p>portalID: " . $_SESSION['user'] . " </p>
              <label> Last Login: </label>
              <p>" . $_SESSION['lastlogin'] . "</p>
              <p><label>Group:</label><code> " . $_SESSION['groups'] . "</code></p>
              ";
              if($_SESSION['role'] == 'admin'){
                echo "<p><label>Status:</label><code> " . $_SESSION['role'] . "</code></p>";
              }

      echo "</div>
          </div>
          <div class='d-flex p-2 justify-content-center w-100'>
            <a href='./' class='btn btn-outline-secondary w-100'>Home</a>
          </div>";
          if($_SESSION['role'] == 'admin'){
            echo "<div class='d-flex p-2 justify-content-center w-100'>
                    <a href='pages/upload/'  class='btn btn-outline-secondary w-100'>Upload</a>
                  </div>
                  <div class='d-flex p-2 justify-content-center w-100'>
                    <a href='pages/admin_tools/'  class='btn btn-outline-secondary w-100'>Admin Tools (v2)</a>
                  </div>";
          }
    echo" <div class='d-flex p-2 justify-content-center w-100'>
            <a href='pages/eos/'  class='btn btn-outline-secondary w-100'>Sticky Bulletin</a>
          </div>";

    echo "<div class='d-flex p-2 justify-content-center w-100'>
            <a href='pages/bugreport.php'  class='btn btn-outline-secondary w-100'>Bug Report</a>
          </div>
          <div class='d-flex p-2 justify-content-center w-100'>
            <a href='pages/about.php'  class='btn btn-outline-secondary w-100'>About</a>
          </div>
          <div class='d-flex p-2 justify-content-center w-100'>
            <a href='php/isu_auth/logout.php'  class='btn btn-outline-secondary w-100'>Logout</a>
          </div>
        </div>
        ";
}

?>
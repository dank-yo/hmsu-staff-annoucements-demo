<?php 
function createSuccessNotification($var){
    echo "<div class='d-flex w-100 justify-content-center'>";
      echo "<div class='alert alert-success alert-dismissible'>
              <button type='button' class='btn-close' data-bs-dismiss='alert'></button><strong>Success! </strong>". $_SESSION["$var"]."
            </div>
        </div>";
  }
  
function createErrorNotification($var){
  echo "<div class='d-flex w-100 justify-content-center'>";
    echo "<div class='alert alert-danger alert-dismissible'>
            <button type='button' class='btn-close' data-bs-dismiss='alert'></button><strong>Error! </strong>". $_SESSION["$var"]."
          </div>
        </div>";
}

function checkNotificationMessage(){
  if(isset($_SESSION['success'])){createSuccessNotification('success');}
  if(isset($_SESSION['error'])){createErrorNotification('error');}
}

function unsetNotificationMessage(){
  if(isset($_SESSION['success'])){unset($_SESSION['success']);}
  if(isset($_SESSION['error'])){unset($_SESSION['error']);}
}
?>
<!doctype html>
<?php
/*    This page is the HTML document that is responsible for creating a valid post
      forum for administrators to create uploads for.

*/
//MUST RUN FIRST
require('../../config.php');
runAllChecks('../../');
?>

<html>
  <head>
    <?php setPageHead("HMSU SA | Create New Post"); ?>
    <!--This is TINYMY TEXT EDITOR PLUGIN -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
    
    <script src='js/upload.js'></script>
    <script> 
    function displayPopup(){
    console.log("test")
    }
    attach = this.document.getElementById("attach");
    attach.addEventListener("click", displayPopup());
    </script>

  </head>

  <body>
    <?php createPageNavBar(); ?>
  <div class="offcanvas offcanvas-start bg-dark text-white" id="menu">
    <?php require_once('../../shell/menu.php');
          displayOffCanvasMenu(); ?>
  </div>
  <div class="container">
    <div class='p-2 m-2 w-100 text-center'>
      <img src="img/title/upload-new-post.png" alt = "Upload new Post" class='w-25'></img>
    </div>
    <?php checkNotificationMessage(); ?>
    <!--CONTENT GETS DISPLAYED HERE -->
    <div class="d-flex justify-content-center" style="margin: 10px; text-align: left;">
      <div class="p-2 w-100 mx-auto">
      <form method='post' action='pages/upload/scripts/upload-message.php'>
          <div class='mb-3 mt-3 h-100 w-100'>
            <label for='Title' class='form-label'>Title:</label>
            <input type='text' class='form-control' placeholder='Post Title' name='title'>
          </div>
            <label for='comment'>Enter Message Here:</label>
            <textarea class='full-featured' id='comment' name='text' style='width: 100%; height: 500px'></textarea>
            <br>
            <button type='submit' id='upload' class='btn btn-dark'>Upload</button>
            <button type='button' id='attach' class='btn btn-dark' onlclick="displayPopup()">📎</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>
</html>

<?php unsetNotificationMessage(); ?>

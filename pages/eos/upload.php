<!doctype html>
<?php
/*    This page is the HTML document that is responsible for creating a valid post
      forum for administrators to create uploads for.

*/
//MUST RUN FIRST
require('../../config.php');
runLoginCheck('../../');

error_reporting(E_ALL);
ini_set('display_errors', 1);

function createPostForum($text){
  echo "<script>
          tinymce.init({
            selector: 'textarea#basic-example',
            height: 500,
            menubar: false,
            plugins: [
              'advlist autolink lists link image charmap print preview anchor',
              'searchreplace visualblocks code fullscreen',
              'insertdatetime media table paste code help wordcount'
          ],
          toolbar: 'undo redo | formatselect | ' +
          'bold italic backcolor | alignleft aligncenter ' +
          'alignright alignjustify | bullist numlist outdent indent | ' +
          'removeformat | help',
          content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
        </script>";
}

?>

<html>
  <head>
    <?php setPageHead("HMSU SA | Post EOS Sticky"); ?>
    <!--This is TINYMY TEXT EDITOR PLUGIN -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
  </head>

  <body>
    <?php createPageNavBar(); ?>
  <div class="offcanvas offcanvas-start bg-dark text-white" id="menu">
    <?php displayOffCanvasMenu(); ?>
  </div>
  <div class="container">
    <div class='p-2 m-2 w-100 text-center'>
      <img src="img/title/upload-sticky-note.png" alt = "Upload Sticky Notes" class='w-25'></img>
    </div>
    <?php if(isset($_SESSION['upload_eos_error'])){createErrorNotification('upload_eos_error');} ?>
    <!--CONTENT GETS DISPLAYED HERE -->
    <div class="d-flex justify-content-center">
      <form method='post' action='./pages/eos/scripts/upload_eos_script.php'>
          <div class='mb-3 mt-3 h-100 w-100'>
            <label for='comment'>Upload Message Here:</label>
            <textarea class='full-featured' id='comment' name='text' style='height: 500px'></textarea>
            <br>
            <button type='submit' class='btn btn-dark'>Submit</button>
          </div>
        </form>
    </div>
  </div>
</body>
</html>
<?php
if(isset($_SESSION['upload_eos_error'])){unset($_SESSION['upload_eos_error']);}

?>

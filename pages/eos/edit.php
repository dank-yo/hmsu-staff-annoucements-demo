<!doctype html>
<?php
  require('../../config.php');
  runLoginCheck("../../");
  if(!isset($_SESSION['EDIT_TEXT']) || !isset($_SESSION['EDIT_PID'])){
    $_SESSION['eos_error'] = "There was an issue editing this post.";
    header("Location: ./");
  }else{
    $text = $_SESSION['EDIT_TEXT'];
  }

  /*This function is responsible for inserting the script and creating the form to input text to */
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
          </script>

          <form method= 'post' action = './pages/eos/scripts/edit_sticky_upload_script.php'>
            <div class='mb-3 mt-3 h-100 w-100'>
            <label for='comment'>Edit Message Here:</label>
            <textarea class='full-featured w-100' id='comment' name='text' style='height: 500px'>$text</textarea>
            <br>
            <button type='submit' class='btn btn-dark'>Submit</button>
            </div>
            </div>
          </form>";
  }
?>

<html>
  <head>
    <?php setPageHead("HMSU SA | Sticky Editor"); ?>
    <!--This is TINYMY TEXT EDITOR PLUGIN -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
  </head>

  <body>
    <?php createPageNavBar(); ?>
  <div class="offcanvas offcanvas-start bg-dark text-white" id="menu">
        <?php  displayOffCanvasMenu(); ?>
  </div>
  <div class="container">
    <!--CONTENT GETS DISPLAYED HERE -->
    <?php if(isset($_SESSION['edit_eos_error'])){createErrorNotification('edit_eos_error');} ?>
    <div class="d-flex justify-content-center" style="margin: 10px; text-align: left;">
      <div class="p-2 w-100 mx-auto">
        <?php createPostForum($text);?>
      </div>
    </div>
  </div>
</body>
</html>

<?php if(isset($_SESSION['edit_eos_error'])){unset($_SESSION['edit_eos_error']);} ?>

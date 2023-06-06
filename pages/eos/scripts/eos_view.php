<?php

/* displaySticky($array) takes an array that is returned from any of the the getEOS() functions
   and is then properly formatted through this function before it gets echoed to the DOM. */
function displaySticky($message_array){
  if(count($message_array) > 0){

    for($i = 0; $i < count($message_array); $i++){
      $postID = $message_array[$i]['PID'];
      /** This creates "button IDs" **/
      $buttonEditID = "editSticky".$postID;
      $buttonDeleteID = "deleteSticky".$postID;

      if($date_line != $message_array[$i]['DATE'] || $i == 0){
        if($i!=0){
          echo "</div>";
          $date_line = $message_array[$i][3];
        }

        if($i==0){
          $date_line = $message_array[0][3];
        }

        echo "<h5 id='line-".$i."'>" . $date_line . "</h5>";
        echo "<div class='d-flex w-100'>";
      }

        echo "<div id='sticky$postID-wrapper' class='sticky-note-wrapper'>";
          echo "<div id='sticky$postID-header' class='d-flex'>";
            echo "<h1 id='sticky$postID-name' class='w-100'>". $message_array[$i][2] . "</h1> <p class='m-2 p-2'>" . $message_array[$i][5] ."</p>";
            if($message_array[$i][1] == $_SESSION['user'] || $_SESSION['role'] == 'admin'){
              echo "<div class='admin-buttons'>
                      <form method = 'post' action = 'pages/eos/scripts/edit_sticky_redirect_script.php'>
                        <input type='submit' name='$buttonEditID' class='btn btn-outline-dark p-0 m-0' value='🖊'></input>
                        <input type='hidden' name='postID' value='$postID'></input>
                      </form>
                      <form method = 'post' action = 'pages/eos/scripts/delete_sticky_script.php'>
                        <input type='submit' name='$buttonDeleteID' class='btn btn-outline-dark p-0 m-0' value='🗑️'></input>
                        <input type='hidden' name='postID' value='$postID'></input>
                      </form>
                    </div>";
            }
          echo "</div><div id='sticky$postID-text' class='p-1' style='overflow: auto;'>".$message_array[$i][6]."</div>";
          echo "</div><div class='p-1'></div>";
    }
  }
  echo "</div><hr class='w-100' style = '1px solid #afafaf'>";
}

/* getEOSMessages() returns all pinned posts from hmsu_sa_eos LIMIT 3; */
function getEOSMessages(){
  try {
    global $dbserv; global $dbname; global $dbuser; global $dbpass;
    $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT *
            FROM hmsu_sa_eos
            ORDER BY PID DESC LIMIT 0, 50";

    $getPosts = $conn->prepare($sql);
    $getPosts->execute();
    $messages = $getPosts->fetchAll();

    $conn = null;

    return $messages;

  }catch(PDOException $e) {
    $_SESSION['eos_error'] = $e->getMessage();
  }
}

function displayEOS(){
  $eos_messages = getEOSMessages();
  if(!empty($eos_messages)){
    displaySticky($eos_messages);
  }
}

?>

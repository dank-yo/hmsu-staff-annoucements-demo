<?php
/*    This page is responsible for holding most of the functions that request
      information from the database as well as format and display some of the
      information before sending to index.php

      This file does have redundancies and some of it needs to be re-organized.
*/

/* getStaffMessages() function returns all of the messages from hmsu_sa_messageS in the database */
function getStaffMessages($col, $range){
  try {
    global $dbserv; global $dbname; global $dbuser; global $dbpass;
    $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT * FROM hmsu_sa_message ORDER BY PID DESC LIMIT $col, $range";

    $getPosts = $conn->prepare($sql);
    $getPosts->execute();
    $results = $getPosts->fetchAll();

    $conn = null;

    return $results;

  }catch(PDOException $e) {
    echo "[FATAL ERROR]: " . $e->getMessage();
    echo "[CODE]: " . $e->getCode();
  }
}

/* getPinnedMessages() returns all pinned posts from hmsu_sa_message where PINNED = POSTID*/
function getPinnedMessages(){
  try {
    global $dbserv; global $dbname; global $dbuser; global $dbpass;
    $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT *
            FROM hmsu_sa_message
            WHERE PINNED=1
            ORDER BY PID DESC LIMIT 10";

    $getPosts = $conn->prepare($sql);
    $getPosts->execute();
    $messages = $getPosts->fetchAll();

    $conn = null;

    return $messages;

  }catch(PDOException $e) {
    echo "[FATAL ERROR]: " . $e->getMessage();
    echo "[CODE]: " . $e->getCode();
  }
}

/* displayView($array) takes an array that is returned from any of the the getMessages() functions
   and is then properly formatted through this function before it gets echoed to the DOM. */
function displayAnnoucement($message_array=[]){
  if(count($message_array) > 0){
    /** This right here needs to be fixed, if there are less than 5 posts then there needs to be reorganizing, if there are more than 5 posts it needs ot make more pages **/
    for($i = 0; $i < count($message_array); $i++){
      $postID = $message_array[$i][0];
      /** This creates "button IDs" **/
      $buttonViewID = "viewedList".$postID;
      $buttonPinID = "pinPost".$postID;
      $buttonEditID = "editPost".$postID;
      $buttonDeleteID = "deletePost".$postID;
      echo "<div id='annoucement$postID-wrapper' class='annoucement-wrapper justify-content-left'>";
        echo "<div id='annoucement$postID-title-wrapper' class='d-flex w-100'>";
        if($message_array[$i][1] == 1){
          echo "<div id='annoucement$postID-title' class='p-2 w-100'> <h1>📌". $message_array[$i][5] . "</h1></div>";
        }else{
          echo "<div id='annoucement$postID-title' class='p-2 w-100'> <h1>". $message_array[$i][5] . "</h1></div>";
        }
        /** This section is responsible for drawing the administrative buttons to the screen **/
        if($_SESSION['role'] == 'admin'){

          echo " <div id='annoucement$postID-admin-buttons' class='admin-buttons'>";
          if(isset($_POST[$buttonViewID])) {
            echo "    <a href='./index.php' name='$buttonViewID' class='btn btn-dark p-0 m-0'>👁</a>";
          }else{
            echo "    <form method='post'>
                        <input type='submit' name='$buttonViewID' class='btn btn-outline-dark p-0 m-0' value='👁'></input>
                      </form>";
          }
          if($message_array[$i][1] == 1){
            echo " <form method = 'post'  action = 'php/unpin_post_script.php'>
                      <input type='submit' name='$buttonPinID' class='btn btn-dark p-0 m-0' value='📌'></input>";
          }else{
            echo " <form method = 'post'  action = 'php/pin_post_script.php'>
                      <input type='submit' name='$buttonPinID' class='btn btn-outline-dark p-0 m-0' value='📌'></input>";
          }
          echo "      <input type='hidden' name='postID' value='$postID'></input>
                  </form>
                </div>
              <div id='annoucement$postID-admin-buttons' class='admin-buttons'>
                <form method = 'post' action = 'php/edit_post_redirect_script.php'>
                  <input type='submit' name='$buttonEditID' class='btn btn-outline-dark p-0 m-0' value='🖊'></input>
                  <input type='hidden' name='postID' value='$postID'></input>
                </form>
                <form method = 'post' action = 'php/delete_post_script.php'>
                  <input type='submit' name='$buttonDeleteID' class='btn btn-outline-dark p-0 m-0' value='🗑️'></input>
                  <input type='hidden' name='postID' value='$postID'></input>
                </form>
              </div>";
          }
      echo "</div>";

      /** This section is responsbile for displaying the actual content of the post **/
      echo "<div id='annoucement$postID-post-data' class='d-flex w-100'>
                <div class='w-100 p-2'>
                  <p>Publisher: " . $message_array[$i][2] . "</p>
                  <p>Published: " . $message_array[$i][3] . "</p>
                  ";
                  if(!empty($message_array[$i][4])){
                  echo "<p>Edited: " . $message_array[$i][4] . "</p>";
                  }
      echo "  </div>
              </div>
              <div id='annoucement$postID-post-content' class='d-flex w-100'>
                <div class='p-2 w-100'>". $message_array[$i][6] . "</div>
              </div>";

      echo getReadStatus($message_array[$i][0]);

      if(isset($_POST[$buttonViewID])) {

        echo "<div id='annoucement$postID-read-list' class='d-flex w-100 justify-content-center m-0 p-0' style='max-height: 256px; overflow: auto;'>";
        echo     getAllReadUsers($postID);
        echo "</div>";
      }
      echo   "</div>";
      echo "<hr style = '1px solid #afafaf'>";
    }
  }else{
    echo "<div class='row' style='display:inline-block; text-align: center; margin: 10px; width: 100%'>";
    echo "<div class='col' syle='text-align: center; width: 100%'><h1>Error! Array Empty</h1></div></div>";
  }
}


/* displayPinned() relies on the displayView function. This function automatically grabs
   the pinned information from the database and prints them out. */
function displayPinned(){
    $pinned_messages = getPinnedMessages();
    if(!empty($pinned_messages)){
      displayAnnoucement($pinned_messages);
    }
}

/* getReadStatus() is a function that scans the given post and returns to a user
   if the message has been acknowledged or not. */
function getReadStatus($i){
  global $dbserv; global $dbname; global $dbuser; global $dbpass;
  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = 'select *
          from hmsu_sa_readreceipt
          where PID='.$i.' and USER=:USER';

  $getReceipts = $conn->prepare($sql);
  $getReceipts->execute(['USER' => $_SESSION['user']]);
  $receipt = $getReceipts->fetchAll();
  $conn = null;

  if($receipt==null){
    return "<form method='post' action ='php/update_receipts.php'><div class='alert alert-danger' style='width: 100%; margin-bottom: 0px; padding-bottom: 0px;'>
            <input type='hidden' name='postID' value='$i'>
              <p><strong>Warning! </strong>Please read this message and click the link to show that you have read the message.<button type='submit' class='btn btn-link' style='padding-top: 2px;'>Click Here.</button></p>
            </div></form><br>";
  }else{
    return "<div class='alert alert-success' style='width: 100%'>You read this message on " . $receipt[0][2] . "</div>";
  }
}

/* getAllReadUsers() function is used for returning all of the users that have read a post.
   This is only for admin groups */
function getAllReadUsers($i){
  $string = "<table class='table table-sm text-center' style='min-width: 70%'><thead class='table-dark '><tr><th>User: </th><th>Read On: </th></tr></thead><tbody>";
  $string1 = '';
  $string2 = '</tbody></table>';
  global $dbserv; global $dbname; global $dbuser; global $dbpass;
  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql_messages ='select *
                  from hmsu_sa_readreceipt
                  where PID='.$i;

  $getReceipts = $conn->prepare($sql_messages);
  $getReceipts->execute();
  $receipt = $getReceipts->fetchAll();
  $conn = null;

  for($j = 0; $j<count($receipt); $j++){
      $string1 = $string1 . "<tr><td>". $receipt[$j][1] ."</td><td>" . $receipt[$j][2] . "</td></tr>";
  }
  echo $string . $string1 . $string2;
}


/* This is responsible for creating the page navigation at the bottom of the page */
function createPagination($count){
  $max_pages = ceil($count / ($_SESSION['query_range']));
  echo '<ul class="pagination pagination-sm justify-content-center">';
    echo '<li class="page-item"><form method="post" action="php/pagination.php"><button type="submit" class="page-link text-muted" name="pagination_input" value="previous">🡐</button></form>
          </li>';
    for($i=1; $i<=$max_pages; $i++){
      if($i==($_SESSION['page_no'])){
        echo '<li class="page-item"><form method="post" action="php/pagination.php"><button class="page-link bg-light text-muted" name="pagination_input" value=current>'.$i.'</button></form></li>';
      }else{
        echo '<li class="page-item"><form method="post" action="php/pagination.php"><button class="page-link text-muted" name="pagination_input" value='.$i.'>'.$i.'</button></form></li>';
      }
    }
    echo '<li class="page-item"><form method="post" action="php/pagination.php"><button type="submit" class="page-link text-muted" name="pagination_input" value="next">🡒</button></form></li>
       </ul>';
}

/* displayOffCanvasMenu is the callout function to display the menu bar on the
   left side of the page */


/* __main__() is the callout function used to format the views per
   user group and display the posts on the home page */
   //qmin- query limit min | qmax- query limit max | page_no- page number | pmax- pageno. max
function __main__(){
  $c = $_SESSION['query_col']; $r = $_SESSION['query_range'];
  $database_count = getDatabaseCount();
  $messages = getStaffMessages($c, $r);
  //This will display the Pinned messages first of course
  if($_SESSION['page_no'] == 1){
      displayPinned();
  }

  displayAnnoucement($messages);
  createPagination($database_count);
}

?>

<!doctype html>
<?php
  require('../../config.php');
  runAllChecks("../../");

  function getBugReports(){
    try {
      global $dbserv; global $dbname; global $dbuser; global $dbpass;
      $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $sql = "SELECT *
              FROM hmsu_sa_bugreport
              ORDER BY PID DESC";

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

  function formatBoolean($var){
    if ($var == 0){
      return "False";
    }
    if ($var == 1){
      return "True";
    }
  }

  function displayReportsList($array){
    $page_no = 0;
    if(count($array) > 0){
      echo "<div class='d-flex w-100'>
      <table class='table table table-dark table-striped table-hover w-100 table-responsive-sm'>
        <thead>
          <tr>
            <th>#</th>
            <th>User:</th>
            <th>Date:</th>
            <th>Title:</th>
            <th>Message:</th>
            <th>Seen:</th>
            <th>Fixed:</th>
          </tr>
        </thead>
        <tbody>";
        for($j = $page_no; $j < count($array); $j++){
          $postID = $array[$j][0];
          echo"<tr>
                <td>" . $array[$j][0] ."</td>
                <td>" . $array[$j][1] ."</td>
                <td>" . $array[$j][2] ."</td>
                <td>" . $array[$j][3] ."</td>
                <td>" . $array[$j][4] ."</td>
                <td>" . formatBoolean($array[$j][5]) ."</td>
                <td>" . formatBoolean($array[$j][6]) ."</td>
              </tr>";
          }
      echo "</tbody>
          </table>
        </div>";
    }else{
      echo "<div class='row' style='display:inline-block; text-align: center; margin: 10px; width: 100%'>";
      echo "<div class='col' syle='text-align: center; width: 100%'><h1>No reports have been submitted!</h1></div>";
    }
  }

  function main(){
    $report_list = getBugReports();
    displayReportsList($report_list);
  }
 ?>

 <head>
   <?php setPageHead("HMSU SA: BugReport Viewer"); ?>
 </head>

 <body>
   <?php createPageNavBar(); ?>
   <div class="offcanvas offcanvas-start bg-dark text-white" id="menu">
     <?php
         require_once('../../shell/menu.php');
         displayOffCanvasMenu(); ?>
   </div>
   <div class="container">
     <div class="d-flex justify-content-left" style="margin: 10px;">
       <div class="p-2 w-100">
       <?php
          main();
         ?>
       </div>
     </div>
   </div>
 </body>
</html>

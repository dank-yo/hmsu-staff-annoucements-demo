<?php
/* This file is responsible for handling the pagination behavior. This file
   relies on the updatePagnationVars Function found
*/
require('../config.php');
?>
<head>
  <?php setPageHead('HMSU SA | Redirecting...'); ?>
</head>

<?php
$input = $_POST['pagination_input'];
$col = $_SESSION['query_col'];
$range = $_SESSION['query_range'];
$page = $_SESSION['page_no'];
$count = getDatabaseCount();
$max_pages = ceil($count / $range);

echo "--Original--" . "
      <br>Input: " . $input . "
      <br>CurrCol: " . $col . "
      <br>CurrRange: " . $range . "
      <br>CurrPageNo.: " . $page . "
      <br>Count: " . $count . "
      <br>Max Pages: " . $max_pages . "
      <br><br>";

if($input == 'next'){
  if($page < $max_pages){
    $page = $page + 1;
  }else{
    $page = $page;
  }
}else if($input == 'previous'){
  if($page > 1){
    $page = $page - 1;
  }else{
    $page = $page;
  }
}else if($input == 'current'){
  $page = $page;
}else{
  $page = $input;
}

$col = ($page - 1) * $range;

$_SESSION['page_no'] = $page;
$_SESSION['query_col'] = $col;

header("Location: ../index.php")
?>

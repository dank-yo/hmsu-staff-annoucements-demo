<?php
// Prototype sanatize(potential input to database)
function sanitize($input) {
  // If the item is an array, function will recusively
  // call itself until the item is no longer an array
  // and will sanitize each index of an array
  if (is_array($input)) 
    foreach($input as $var=>$val) 
      $output[$var] = sanitize($val);

  // Initially will check for magic quotes enabled
  // (pre-PHP 5.4) to see if it needs to remove 
  // magic quotes auto backslashes for return 
  // characters. Will then continue to remove 
  // slashes for to make it database safe.
  else{ 
    if (get_magic_quotes_gpc())
      $input = stripslashes($input);
    $input  = cleanInput($input);
    $output = mysql_real_escape_string($input);
    }
    return $output;
  }
function cleanInput($input) {
    $search = array(
                   '@<script[^>]*?>.*?</script>@si',   // Removes Javascript
                   '@<[\/\!]*?[^<>]*?>@si',            // Removes HTML
                   '@<style[^>]*?>.*?</style>@siU',    // Remove CSS tags
                   '@<![\s\S]*?--[ \t\n\r]*>@'         // Remove Comments
                   );
    $output = preg_replace($search, '', $input);
    return $output;
  }
?>

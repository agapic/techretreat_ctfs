<?php

function log_event($description) {
  $time = date('H:i:s');
  $ip = $_SERVER['REMOTE_ADDR'];
  $type = strtolower(substr($description, 1, 3));
  file_put_contents("logs/$ip.log", $time . ' ' . $description
   . "\n", FILE_APPEND);
  file_put_contents("logs/all.log", $time . ' ' . $ip . ' ' . $description
   . "\n", FILE_APPEND);
  file_put_contents("logs/$type.log", $time . ' ' . $ip . ' ' . $description
   . "\n", FILE_APPEND);
}

?>

<?php
require_once "assets/stalking.php";

if (strpos($_SERVER["HTTP_ACCEPT"], "text/html") !== FALSE) {
    log_event("[HAL] Accepts HTML");
    header("Content-type: text/html");
    $headers = getallheaders ();
    foreach ($headers as $name => $value) {
      if ($name == "Accept") {
        echo "<i>";
      }
      echo $name . ": " . $value . "<br>";
      if ($name == "Accept") {
        echo "</i>";
      }
    }
    readfile('hal_no.png');
} else {
    log_event("[HAL] Does not accept HTML (" . $_SERVER["HTTP_ACCEPT"] . ")");
    header("Content-type: image/png");
    readfile('hal_yes.png');
}
?>

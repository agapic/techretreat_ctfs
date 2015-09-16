<?php
  require_once "assets/stalking.php";

  if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    header("Allow: GET, SOLUTION, REFRESH");
    log_event('[OPTIONS] OPTIONS method received');
  } else if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_COOKIE["youmayproceed"])) {
      log_event('[OPTIONS] Challenge accepted (GET)');
      require "assets/proceed1.php";
    } else {
      log_event('[OPTIONS] Challenge completed');
      $url = 'http://' . $_SERVER['HTTP_HOST'];
      $url .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $url .= '/weneedtogodeeper.php';
      header('Location: ' . $url, true, 303);
    }
  } else if ($_SERVER["REQUEST_METHOD"] == "SOLUTION") {
    log_event('[OPTIONS] SOLUTION method received');
    header("HTTP/1.1 204 No Content");
    setcookie("youmayproceed", "true");
  }
  die();
?>

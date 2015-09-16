<?php
require_once "assets/statusbar.php";
require_once "assets/stalking.php";

if (isset($_GET['a'])) {
  if (strtolower($_GET['a']) == "teapot") {
    require "assets/teapotdone.php";
    log_event("[Teapot] Correct password: " . $_GET['a']);
    die();
  }
  log_event("[Teapot] Incorrect password: " . $_GET['a']);
} else {
  log_event("[Teapot] Load page");
}
header("HTTP/1.1 418 I'm a teapot");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>What am I?</title>
  </head>
  <body>
    <header>
      <h1>Challenge 5</h1>
    </header>
    <p>
      HTTP &mdash; HyperText Transfer Protocol &mdash; is one of the most
      important technologies of the modern day. This challenge will introduce
      some of its fundamentals.
      <a href="http://www.answers.com/Q/Why_is_http_important">
        Why is HTTP important?</a>
    </p>
    <p>
      Want a cup of coffee? Well, look at what happened to Starbucks when they
      were <a href="http://sakurity.com/blog/2015/05/21/starbucks.html">cooking
      too many muffins</a> and not giving enough attention to their... err...
      cookies.
    </p>
    <p>
      The theme of this challenge is HTTP,<br />
      The theme of this page may be an RFC.<br />
      There's more to a response, you see,<br />
      than just the body, where you will not find me.
    </p>
    <p>
      What am I?
    </p>
    <form action="" method="get">
      <p>I'm a <input type="text" name="a" /></p>
      <input type="submit" value="Submit"/>
    </form>

    <?php statusbar(10); ?>
  </body>
</html>

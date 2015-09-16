<?php
  require_once "assets/statusbar.php";
  require_once "assets/stalking.php";

  if (isset($_GET["me"])) {
    if (strpos(strtolower($_GET["me"]), "sascha") !== FALSE) {
      log_event('[BIRTHDAY] Correct answer received ' . $_GET["me"]);
?><!DOCTYPE html><html lang="en"><head><title>Happy Birthday!</title>
</head><body>
    <p>Happy birthday to you</p>
    <p>Happy birthday to you</p>
    <p>Happy birthday dear /saschaschumann.php</p>
    <p>Happy birthday to you!</p>
    <br>
    <input type="submit" value="Submit"/>
    <br>
    <br>
    <p>Fun Fact:</p>
    <p>Did you know the Copyright on <i>Happy Birthday</i> will <i>expire</i> on December 31, 2016 in the EU?</p>
<?php statusbar(70); ?></body></html><?php
      die();
    } else {
      log_event('[BIRTHDAY] Incorrect answer received: ' . $_GET['me']);
    }
  } else {
    log_event('[BIRTHDAY] Challenge Accepted!');
  }
  header("Expires: Thu, 19 Nov 1981 08:52:00 GMT");
?>
<!DOCTYPE html><html><head><title>Happy Birthday!</title></head><body>
<form action="weneedtogodeeper.php" method="get">
  &lt;?<em>php</em>
  <p>&nbsp;&nbsp;&nbsp;&nbsp;Happy birthday to you</p>
  <p>&nbsp;&nbsp;&nbsp;&nbsp;Happy birthday to you</p>
  <p>&nbsp;&nbsp;&nbsp;&nbsp;Happy birthday dear <input type="text" name="me" /></p>
  <p>&nbsp;&nbsp;&nbsp;&nbsp;Happy birthday to you</p>
  ?&gt;
  <br>
  <br>
  <input type="submit" value="Submit"/>
  <br>
  <br>
  <p>Fun Fact:</p>
  <p>Did you know the Copyright on Happy <em>Birthday</em> will <i>expire</i> on December 31, 2016 in the EU?</p>
</form>
<?php statusbar(55); ?></body></html>

<?php
require_once "assets/stalking.php";

function err($cause, $line1, $line2, $link = 'http://php.net/docs.php') {
  header("HTTP/1.1 500 Internal Server Error");
  log_event('[PHP] PHP good until line: ' . $line2);
  ?>
  <!DOCTYPE html>
  <html lang="en">
    <head>
      <title>500 Internal Server Error</title>
      <style type="text/css">
          pre {
              font-size: 1.2em;
          }
          pre span {
              color: #9F0000;
          }
      </style>
    </head>
    <body>
      <h1>Internal Server Error</h1>
      <p>The server encountered an internal error or misconfiguration and was unable to complete your request.</p>

      <p>Caused by: <?php echo $cause; ?></p>
      <blockquote><pre>...
<?php echo $line1; ?>

<?php if (!isset($line3)) echo '<span>'; echo $line2;
      if (!isset($line3)) echo '</span>';
      if (!isset($line3)) echo ' <b>&larr;</b>'; ?>

<?php if (isset($line3)) { echo '<span>' . $line3 . '</span>'; ?> <b>&larr;</b>

<?php } ?>
      ...</pre></blockquote>

      <p>In addition, the webserver has specified a custom message to display for errors of this kind:</p>
      <blockquote>
        <p style="color: #5F5F5F;">Psst... if you don't know PHP, have a look at the <a href="<?php echo $link; ?>">documentation</a></p>
      </blockquote>
    </body>
  </html>
  <?php
}

  if (isset($_GET["referer"])) {
    if ($_GET["referer"] == "weneedtogodeeper") {
      if (isset($_COOKIE["secret"])) {
        if (strpos($_COOKIE["secret"], " techretreat is awesome") !== FALSE) {
          $magicnumber = 18 + $_COOKIE["secret"];
          if ($magicnumber == 42) {
            if (isset($_GET["cast"])) {
              $cast = $_GET["cast"];
              $fakecast = '$magicvalue' . " = " . "($cast) " . '$magicnumber;';
              if ($cast == "unset") {
                if (isset($_GET["firstnumber"]) && isset($_GET["secondnumber"])) {
                  $illegal = array(0,false,"","0",NULL,array());
                  if (!in_array($_GET["firstnumber"], $illegal, TRUE) && !in_array($_GET["secondnumber"], $illegal, TRUE)) {
                    $value1 = $_GET["firstnumber"];
                    $value2 = $_GET["secondnumber"];
                    if ($value1 - $value2 == 0 && $value1 !== $value2) {
                      err("invalid_syntax_error", '//TODO: Fix bugs in code, link to next part cantthinkofagoodname.php', 'echo "That\'s all we got for now"');
                    } else {
                      err("assertion_error", '$value2 = $_GET["secondnumber"];', 'assert($value1 - $value2 == 0 && $value1 != $value2);', 'http://php.net/manual/en/types.comparisons.php');
                    }
                  } else {
                    err("assertion_error", '$illegal = array(0,false,"","0",NULL,array());', 'assert(!in_array($_GET["firstnumber"], $illegal, TRUE) && !in_array($_GET["secondnumber"], $illegal, TRUE));', "http://php.net/manual/en/types.comparisons.php");
                  }
                } else {
                  err("no_such_index_error", 'assert($magicvalue == NULL);', 'if (isset($_GET["firstnumber"]) && isset($_GET["secondnumber"])) {', "http://php.net/manual/en/reserved.variables.get.php");
                }
              } else {
                err("assertion_error", "$fakecast", 'assert($magicvalue == NULL);', "http://php.net/manual/en/language.types.null.php");
              }
            } else {
              err("no_such_index_error", 'assert($magicnumber == 42);', 'if (isset($_GET["cast"])) {', "http://php.net/manual/en/reserved.variables.get.php");
            }
          } else {
            err("assertion_error", '$magicnumber = 18 + $_COOKIE["secret"];', 'assert($magicnumber == 42);', "https://stackoverflow.com/questions/11026796/adding-string-with-number-in-php");
          }
        } else {
          err("assertion_error", 'if (isset($_COOKIE["secret"])) {', '    assert(strpos($_COOKIE["secret"], " techretreat is awesome") !== FALSE);', "http://php.net/manual/en/function.strpos.php");
        }
      } else {
        err("no_such_index_error", 'assert($_GET["referer"] == "weneedtogodeeper");', 'if (isset($_COOKIE["secret"])) {', "https://stackoverflow.com/questions/1538701/how-to-set-a-cookie-in-the-address-bar");
      }
    } else {
      err("assertion_error", 'if (isset($_GET["referer"])) {', '    assert($_GET["referer"] == "weneedtogodeeper");', "http://php.net/manual/en/reserved.variables.get.php");
    }
  } else {
    err("no_such_index_error", 'echo "This portion is dedicated to PHP. You\'ll need to work around the bugs... all from your browser";', 'if (isset($_GET["referer"])) {', "http://php.net/manual/en/reserved.variables.get.php");
  }
?>

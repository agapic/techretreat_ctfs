<?php
   file_put_contents("robotip.txt", $_SERVER["REMOTE_ADDR"], FILE_APPEND);
?>
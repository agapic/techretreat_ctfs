<?php
require_once "assets/statusbar.php";
require_once "assets/stalking.php";

if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'googlebot')) {
    log_event('[GOOGLE] Done');
    ?>OK Google please index this page: <a href="ur_done">thx</a><?php
} else {
    log_event('[GOOGLE] Fail: ' . $_SERVER['HTTP_USER_AGENT']);
    ?>Not quite! Only Google spider can access this page<?php
}
?>

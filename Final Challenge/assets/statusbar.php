<?php

function statusbar($percent) {
?><aside>
<p>Your progress: <progress max="100" value="<?php echo $percent; ?>"><!--
--><?php echo $percent; ?>%<!--
--></progress></p>
</aside>
<style type="text/css">
aside {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  border-top: 1px solid black;
  background-color: #FFFF9F;
}

aside p {
  display: inline-block;
  padding: 3px;
  font-size: 0.8em;
  margin: 0;
  vertical-align: middle;
  min-width: 50%;
}

aside p progress {
  width: 70%;
}
</style><?php
}
?>

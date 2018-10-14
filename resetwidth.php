<?php
session_start();
$newheight = $_SESSION['w'];
$_SESSION['w'] = $_SESSION['h'];
$_SESSION['h'] = $newheight;
?>
<script type="text/javascript">
var x = document.referrer;
window.location.assign(x);
</script>
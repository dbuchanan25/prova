<?php
session_start();
    if (isset($_GET["w"]))
    {
        $_SESSION['w'] = $_GET['w'];
    }
?>
<script type="text/javascript">
    window.location.assign = (history.go(-1));
</script>


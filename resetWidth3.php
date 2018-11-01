<?php
session_start();
if (!isset($_SESSION['username']))
{
    require_once ('includes/login_functions.inc.php');
    $url = absolute_url();
    header("Location: $url");
    exit();
}
else
{
    if (isset($_GET['w']))
    {
        $_SESSION['w'] = $_GET['w'];
    }
    ?>
    <script type="text/javascript">
        window.location.assign = (history.go(-1));
    </script>
    <?php
}
?>


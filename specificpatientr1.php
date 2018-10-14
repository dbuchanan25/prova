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
    $_SESSION['revise1'] = true;
    echo'
    <script>
    window.location = "specificpatient.php";
    </script>
    ';
}


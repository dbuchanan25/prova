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
    require_once ($_SESSION['loginstring']);
    $q = "UPDATE patients SET active = 0 WHERE id = ".$_SESSION['currentptnum'];
    $r = mysqli_query($dbc, $q);
    echo'
    <script>
    window.location="patientinfo.php";
    </script>
    ';
}


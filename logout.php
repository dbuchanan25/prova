<?php #Script 11.11 - logout.php
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
$winwidth = $_SESSION['w']; 

echo'
<html>
<title>Logout</title>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>  
    .row:after 
    {
        content: "";
        display: table;
        clear: both;
    } 
    </style>
<link rel="stylesheet" href="styles/stylew3.css" type="text/css">
</head>
<div class="row" style="background-color:#7db4dc;">
  <center><img src="includes/ProvidenceSmall.png" alt="PAA" height='.($winwidth*0.2369*.5*.7).'; width='.($winwidth*.5*.7).';" /></center>
  <div class="w3-padding w3-center"><h1>Patient Information</h1></div>
</div>';


$page_title = 'Logged Out!';

echo "<h1 align=center>Logged Out!</h1>
<p align=center> You are now logged out </p>
<p align=center> You will be redirected in 3 seconds. </p>
<script>
        var timer = setTimeout(function() {
            window.location='login.php'
        }, 3000);
    </script>
<br>
<br>
<br>";

$_SESSION = array();
session_destroy();
setcookie ('PHPSESSID', '', time()-3600, '/', '', 0, 0);
setcookie('authentication', ":", time()-3600);
}
?>

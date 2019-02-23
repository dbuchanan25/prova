<?php
//////////////////////////////////////////////////////////////////////////////////////////////////
//VERSION 01_03                                                                                 //
//LAST REVISED 20190222                                                                         //
//Revision page reference for day 2.  Makes $_SESSION['revise2'] = true                         //
//It forwards information to the page "specificpatient.php"                                     //
//////////////////////////////////////////////////////////////////////////////////////////////////
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
    $_SESSION['revise2'] = true;
    echo'
    <script>
    window.location = "specificpatient.php";
    </script>
    ';
}


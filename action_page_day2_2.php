<?php
//////////////////////////////////////////////////////////////////////////////////////////////////                                                                             //
//VERSION 01_03                                                                                 //
//LAST REVISED 20190222                                                                         //
//Page enters data into the database which has been confirmed by a physician user about a       //
//patient's follow-up day 2.                                                                    //
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
    require_once ($_SESSION['loginstring']);
    $_SESSION['comments2'] = trim(str_replace("Comments:","",$_SESSION['comments2']));
    $q = "UPDATE patients ".
         "SET painscore2 = ".$_SESSION['painscore2'].", ".
            "sensoryblock2 = ".$_SESSION['sensoryblock2'].", ".
            "motorblock2 = ".$_SESSION['motorblock2'].", ".
            "nsaids2 = ".$_SESSION['nsaids2'].", ".
            "acetaminophen2 = ".$_SESSION['acetaminophen2'].", ".
            "narcotics2 = ".$_SESSION['narcotics2'].", ".
            "drainage2 = ".$_SESSION['drainage2'].", ".
            "comments2 = '".$_SESSION['comments2']."' ".
         "WHERE id = ".$_SESSION['currentptnum'];
    $r = mysqli_query($dbc, $q);
    echo'
    <script>
        window.location="patientinfo.php";
    </script>
    ';
}


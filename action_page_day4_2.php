<?php
//////////////////////////////////////////////////////////////////////////////////////////////////                                                                             //
//VERSION 01_03                                                                                 //
//LAST REVISED 20190222                                                                         //
//Page enters data into the database which has been confirmed by a physician user about a       //
//patient's follow-up day 4.                                                                    //
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
    $_SESSION['comments4'] = trim(str_replace("Comments:","",$_SESSION['comments4']));
    $q = "UPDATE patients ".
         "SET painscore4 = ".$_SESSION['painscore4'].", ".
            "sensoryblock4 = ".$_SESSION['sensoryblock4'].", ".
            "motorblock4 = ".$_SESSION['motorblock4'].", ".
            "nsaids4 = ".$_SESSION['nsaids4'].", ".
            "acetaminophen4 = ".$_SESSION['acetaminophen4'].", ".
            "narcotics4 = ".$_SESSION['narcotics4'].", ".
            "drainage4 = ".$_SESSION['drainage4'].", ".
            "comments4 = '".$_SESSION['comments4']."' ".
         "WHERE id = ".$_SESSION['currentptnum'];
    $r = mysqli_query($dbc, $q);
    echo'
    <script>
        window.location="patientinfo.php";
    </script>
    ';
}


<?php
//////////////////////////////////////////////////////////////////////////////////////////////////                                                                             //
//VERSION 01_03                                                                                 //
//LAST REVISED 20190222                                                                         //
//Page enters data into the database which has been confirmed by a physician user about a       //
//patient's follow-up day 3.                                                                    //
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
    $_SESSION['comments3'] = trim(str_replace("Comments:","",$_SESSION['comments3']));
    $q = "UPDATE patients ".
         "SET painscore3 = ".$_SESSION['painscore3'].", ".
            "sensoryblock3 = ".$_SESSION['sensoryblock3'].", ".
            "motorblock3 = ".$_SESSION['motorblock3'].", ".
            "nsaids3 = ".$_SESSION['nsaids3'].", ".
            "acetaminophen3 = ".$_SESSION['acetaminophen3'].", ".
            "narcotics3 = ".$_SESSION['narcotics3'].", ".
            "drainage3 = ".$_SESSION['drainage3'].", ".
            "comments3 = '".$_SESSION['comments3']."' ".
         "WHERE id = ".$_SESSION['currentptnum'];
    $r = mysqli_query($dbc, $q);
    echo'
    <script>
        window.location="patientinfo.php";
    </script>
    ';
}


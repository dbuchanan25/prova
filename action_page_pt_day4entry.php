<?php
//////////////////////////////////////////////////////////////////////////////////////////////////
//VERSION 01_03                                                                                 //
//LAST REVISED 20190222                                                                         //
//Enters into the database results from patient entry of pain score, etc. for day 4             //
//It forwards information to the page "blockinformation.php"                                    //
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
    if ($_SESSION['cath'])
    {
        $q = "UPDATE patients ".
         "SET painscore4 = ".$_POST['pscore'].", ".
            "sensoryblock4 = ".$_POST['sensory'].", ".
            "motorblock4 = ".$_POST['motor'].", ".
            "nsaids4 = ".$_POST['nsaids'].", ".
            "acetaminophen4 = ".$_POST['tylenol'].", ".
            "narcotics4 = ".$_POST['narcs'].", ".
            "drainage4 = ".$_POST['dra']." ".
         "WHERE id = ".$_SESSION['id'];
    }
    else
    {
        $q = "UPDATE patients ".
             "SET painscore4 = ".$_POST['pscore'].", ".
                "sensoryblock4 = ".$_POST['sensory'].", ".
                "motorblock4 = ".$_POST['motor'].", ".
                "nsaids4 = ".$_POST['nsaids'].", ".
                "acetaminophen4 = ".$_POST['tylenol'].", ".
                "narcotics4 = ".$_POST['narcs']." ".
             "WHERE id = ".$_SESSION['id'];
    }
    $r = mysqli_query($dbc, $q);
    
    if ($_POST['sensory']==0)
    {
        $s = "UPDATE patients ".
             "SET hournumberdone = ".$_POST['hour'].", ".
                 "monthnumberdone = ".$_POST['month'].", ".
                 "daynumberdone = ".$_POST['day']." ".
             "WHERE id = ".$_SESSION['id'];
        $t = mysqli_query($dbc, $s);
    }
    unset($_SESSION['id']);
    unset($_SESSION['cath']);
    echo'
    <script>
        window.location="blockinformation.php";
    </script>
    ';
}
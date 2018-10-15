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
    $q = "UPDATE patients ".
         "SET painscore1 = ".$_POST['pscore'].", ".
            "sensoryblock1 = ".$_POST['sensory'].", ".
            "motorblock1 = ".$_POST['motor'].", ".
            "nsaids1 = ".$_POST['nsaids'].", ".
            "acetaminophen1 = ".$_POST['tylenol'].", ".
            "narcotics1 = ".$_POST['narcs']." ".
         "WHERE id = ".$_SESSION['id'];
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
    echo'
    <script>
        window.location="blockinformation.php";
    </script>
    ';
}
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
    $_SESSION['comments1'] = trim(str_replace("Comments:","",$_SESSION['comments1']));
    $q = "UPDATE patients ".
         "SET painscore1 = ".$_SESSION['painscore1'].", ".
            "sensoryblock1 = ".$_SESSION['sensoryblock1'].", ".
            "motorblock1 = ".$_SESSION['motorblock1'].", ".
            "nsaids1 = ".$_SESSION['nsaids1'].", ".
            "acetaminophen1 = ".$_SESSION['acetaminophen1'].", ".
            "narcotics1 = ".$_SESSION['narcotics1'].", ".
            "drainage1 = ".$_SESSION['drainage1'].", ".
            "comments1 = '".$_SESSION['comments1']."' ".
         "WHERE id = ".$_SESSION['currentptnum'];
    $r = mysqli_query($dbc, $q);
    echo'
    <script>
        window.location="patientinfo.php";
    </script>
    ';
}


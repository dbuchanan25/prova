
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
    $datetime = new DateTime("now", new DateTimeZone('US/Eastern'));
    $dt = date_format($datetime, 'Y_m_d_H');
    $filename = $_SESSION['ptid']; 
    $filetype = "png"; 

    $img = $_POST['save_remote_data'];
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    
    $wfile = "signatures/".$_SESSION['ptid']."_".$dt.".png" or die("Unable to open file!");

    $myfile = fopen($wfile, "w");
    fwrite($myfile, $data);
    fclose($myfile);
    
    if (filter_var($_POST['textpush'], FILTER_VALIDATE_INT) === 0 || filter_var($_POST['textpush'], FILTER_VALIDATE_INT))
    {
        $decis = $_POST['textpush'];
        $a = "UPDATE patients SET textpush = ".$decis." WHERE id = ".$_SESSION['ptid'];
        $b = mysqli_query($dbc, $a); 
    }
    
?>
<script>
window.location.assign("patientinfo.php");
</script>
<?php
}
?>
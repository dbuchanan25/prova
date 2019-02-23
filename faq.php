<?php
session_start();
$datetime = new DateTime("now", new DateTimeZone('US/Eastern'));
$datetime2 = new DateTime("now", new DateTimeZone('US/Eastern'));


if (!isset($_SESSION['username']))
{
    require_once ('includes/login_functions.inc.php');
    $url = absolute_url();
    header("Location: $url");
    exit();
}
else
{
    $_SESSION['ptblock1'] = false;  $_SESSION['ptblock2'] = false;
    $_SESSION['ptblock3'] = false;  $_SESSION['ptblock4'] = false;
    $_SESSION['loginstring']='includes/connect.php';
    require_once ($_SESSION['loginstring']);
    
    $phcomplete = $_SESSION['ptphone'];
    
    $_SESSION['loginstring']='includes/connect.php';
    require_once ($_SESSION['loginstring']);
   
    
     $q = "SELECT painscore1, painscore2, painscore3, painscore4 ".
         "FROM patients ".
         "WHERE phone LIKE '".$phcomplete."' ".
         "AND active = 1";
    $r = mysqli_query($dbc, $q);
    
    if ($r !== false)
    {
        $s = mysqli_fetch_array($r);
        if ($s[0] > -1)
        {
            $_SESSION['ptblock1'] = true;
        }
        if ($s[1] > -1)
        {
            $_SESSION['ptblock2'] = true;
        }
        if ($s[2] > -1)
        {
            $_SESSION['ptblock3'] = true;
        }
        if ($s[3] > -1)
        {
            $_SESSION['ptblock4'] = true;
        }
    }    
?>
<head>
<title>Providence Anesthesiology</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="styles/style2.css" type="text/css">
</head>
<body>
    
<script type="text/javascript">    

var resizeTimer; 
var cachedWidth = window.innerWidth;

window.addEventListener("resize", doOnResize); 

function doOnResize()
{
    clearTimeout(resizeTimer);
    var new_width = window.innerWidth;
    if(new_width !== cachedWidth)
    {
        resizeTimer = setTimeout(function() 
        {
            var new_width = window.innerWidth;
            var new_height = window.innerHeight;
            window.location = "resetWidth3.php?w=" + new_width + "&h=" + new_height;            
        }, 500);
    }
}
</script>


<?php
echo'
<html>
<title>FAQs</title>
<body>

<div class="row2" style="background-color:#7db4dc; width:'.$_SESSION['w'].'">
  <center><img src="includes/ProvidenceSmall.png" alt="PAA" height='.($_SESSION['w']*0.2369*.5*.7).'; width='.($_SESSION['w']*.5*.7).';" /></center>
</div>';

echo'
<div class="topnav" style="width:'.$_SESSION['w'].'">
  <a href="eos.php">Evening of Surgery</a>'; 
if ($_SESSION['ptblock1'])
{
echo '
  <a href="ptblock1.php">Postoperative Day #1</a>';
}
if ($_SESSION['ptblock2'])
{
echo '
  <a href="ptblock2.php">Postoperative Day #2</a>';
}
if ($_SESSION['ptblock3'])
{
echo '
  <a href="ptblock3.php">Postoperative Day #3</a>';
}
if ($_SESSION['ptblock4'])
{
echo '
  <a href="ptblock4.php">Postoperative Day #4</a>';
}
echo'
  <a href="blockInformation.php">Block Information</a>
  <a href="faq.php">FAQs</a>
  <a href="logout.php">Logout</a>
</div>';


?>
    <br><br>
    <center>
        <h1>Frequently Asked Questions
            <br>
            (Also please see the <a href="blockInformation.php">Block Information Tab</a>)
        </h1>
    </center>
    <br><br>
    <h2>1.  Why am I having pain when I have a nerve block?</h2>
    <h3>There are a number of reasons you could be having pain after your operation.<br><br>
    First of all, at the time of nerve block catheter placement, a high concentration of local
    anesthetic is used to anesthetize or “numb” the operative site extremity. This can last from
    8-16 hours. After that, the local anesthetic infusion, which is a lower concentration, will
    provide analgesia or pain relief to the extremity. It is normal for the extremity to feel like it
    is waking up, including being able to move the extremity and experiencing increased
    sensation to the extremity. This does not necessarily mean that the catheter is not working.<br><br>
    Secondly, sometimes the sensation of pain can extend beyond the nerve block coverage.<br><br>
    Thirdly, a mechanical issue, like a clamped or kinked tube, of the nerve block infusion may be 
    keeping the local anesthetic medicine from infusing properly.<br><br>
    Check to make sure the block tubing is not clamped or kinked.  Make sure the extremity is not out of
    a sling or in a bad position.  Also, if you have a fever or signs the extremity is not getting enough
    blood flow (absent pulse or delayed capillary refill (Press a nail of a finger or toe of the arm or leg where the block is, then let go.  
    Blood should return under the nail within 2 seconds)), then get in touch with your surgeon.</h3>
    <br><br>
    <h2>2.  Is it normal to have leaking from around the nerve block tube (catheter)?</h2>
    <h3>Leaking around the nerve block catheter is common and related to infusing medication liquid 
    into a place where there is normally not any liquid.  If the liquid is clear or slightly
    blood tinged, then that is OK.  If where the catheter goes through the skin has blood coming
    from around it, then hold pressure for 5-10 minutes and it should stop.  If it does not, please call us.  
    If the catheter has become disconnected or dislodged, please call us.</h3>
    <br><br>
    <h2>3.  Is it normal to have hoarseness, a drooping eyelid, or minor difficulty breathing?</h2>
    <h3>These symptoms are very common with interscalene (neck) nerve block catheters and are caused by 
    other nerves in and around the shoulder nerves also being blocked. These symptoms almost always resolve when 
    the infusion is complete.<br><br>
    If symptoms are overly disconcerting, you can clamp the catheter. The symptoms should resolve after 1-2 hours. 
    If this is done, your pain may intensify.  You may restart the 
    infusion after the symptoms get better.<br><br>
    If the side effect symptoms (feeling of difficulty breathing, hoarse voice, drooping eye) are worse than the
    pain, you may remove the catheter and take medicine for pain as prescribed by surgeon.<br><br>
    If it is very difficult to breath, you should call 911.
    </h3>
    <br><br>
    </body>
<?php
}
?>
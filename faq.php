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
    $_SESSION['loginstring']='includes/connect.php';
    require_once ($_SESSION['loginstring']);
    
    $ph = $_SESSION['ptphone'];
    $phcomplete = "(".substr($ph,0,3).") ".substr($ph,3,3)."-".substr($ph,6);
    
    $_SESSION['loginstring']='includes/connect.php';
    require_once ($_SESSION['loginstring']);
   
    
    $q = "SELECT painscore1 ".
         "FROM patients ".
         "WHERE phone LIKE '".$phcomplete."' ".
         "AND active = 1";
    $r = mysqli_query($dbc, $q);
    
    $t = "SELECT painscore2 ".
         "FROM patients ".
         "WHERE phone LIKE '".$phcomplete."' ".
         "AND active = 1";
    $u = mysqli_query($dbc, $t);
    
    if ($r !== false)
    {
        $s = mysqli_fetch_array($r);
        if ($s[0] > -1)
        {
            $_SESSION['ptblock1'] = true;
        }
    }
    
    if ($u !== false)
    {
        $v = mysqli_fetch_array($u);
        if ($v[0] > -1)
        {
            $_SESSION['ptblock2'] = true;
        }
    }
    
?>
<head>
<title>Providence Anesthesiology</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
    box-sizing: border-box;
}

body {
  margin: 0;
  font-family:"Segoe UI",Arial,sans-serif;
}

/* Style the header */
.header {
    background-color: #7db4dc;
    padding: 20px;
    text-align: center;
    font-family:"Segoe UI",Arial,sans-serif;
    font-size:36px;
    margin:10px;
}

/* Style the top navigation bar */
.topnav {
    overflow: hidden;
    background-color: #DDDDDD;
    font-family:"Segoe UI",Arial,sans-serif;
    font-size:20px;
    margin:10px;
}

/* Style the topnav links */
.topnav a {
    float: left;
    display: block;
    color: #000000;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}

/* Change color on hover */
.topnav a:hover {
    background-color: #7db4dc;
    color: black;
}

.column {
    float: left;
    width: 100%;
    padding: 14px 16px;
    font-family:"Segoe UI",Arial,sans-serif;
}

.columnt {
    float: left;
    width: 50%;
    padding: 14px 16px;
}
.columntr {
    text-align: center;
    padding: 3% 0;
}

/* Clear floats after the columns */
.row:after {
    content: "";
    display: table;
    clear: both;
}

/* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
/*@media screen and (max-width:600px) {
    .column {
        width: 95%;
    }*/


.control {
    font-family: arial;
    display: block;
    position: relative;
    padding-left: 40px;
    margin-bottom: 6px;
    padding-top: 6px;
    cursor: pointer;
    font-size: 20px;
}
    .control input {
        position: absolute;
        z-index: -1;
        opacity: 0;
    }
.control_indicator {
    position: absolute;
    top: 1px;
    left: 0;
    height: 30px;
    width: 30px;
    background: #e6e6e6;
    border: 2px solid #000000;
}
.control-radio .control_indicator {
    border-radius: undefined;
}

.control:hover input ~ .control_indicator,
.control input:focus ~ .control_indicator {
    background: #cccccc;
}

.control input:checked ~ .control_indicator {
    background: #2aa1c0;
}
.control:hover input:not([disabled]):checked ~ .control_indicator,
.control input:checked:focus ~ .control_indicator {
    background: #0e6647d;
}
.control input:disabled ~ .control_indicator {
    background: #e6e6e6;
    opacity: 0.6;
    pointer-events: none;
}
.control_indicator:after {
    box-sizing: unset;
    content: '';
    position: absolute;
    display: none;
}
.control input:checked ~ .control_indicator:after {
    display: block;
}
.control-checkbox .control_indicator:after {
    left: 8px;
    top: 4px;
    width: 3px;
    height: 9px;
    border: solid #ffffff;
    border-width: 0 4px 4px 0;
    transform: rotate(45deg);
}
.control-checkbox input:disabled ~ .control_indicator:after {
    border-color: #7b7b7b;
}

input.btn {color:#000000; font: 100%"arial",helvetica,sans-serif; border-width: 3px; border-style: outset; background-color: #fafafa; padding:10px; align:center; font-size:100%;  width:30%;}
input.btn2 {color:#000000; font: 100%"arial",helvetica,sans-serif; border-width: 3px; border-style: outset; background-color: #fafafa; padding:10px; align:center; font-size:100%;  width:50%;}
input.btn:hover{ background-color: #7db4dc; -webkit-transition-duration: 1.0s;  transition-duration: 1.0s;}
input.btn2:hover{ background-color: #7db4dc; -webkit-transition-duration: 1.0s;  transition-duration: 1.0s;}
button.btn {color:#000000; font: 100%"arial",helvetica,sans-serif; border-width: 3px; border-style: outset; background-color: #fafafa; padding:10px; align:center; font-size:100%;  width:50%;}
button.btn:hover{ background-color: #7db4dc; -webkit-transition-duration: 1.0s;  transition-duration: 1.0s;}

h3 {color:#000000; font: 150%"arial",helvetica,sans-serif; text-align: justify; margin-left: 30px; margin-right: 30px}
h2 {color:blue; text-align: center; font-family:"Segoe UI",Arial,sans-serif; font-size:32px;}

</style>
</head>
<body>



<div class="header">
    <div class = "row">
        <div class = "columnt">
            <center><img src="includes/ProvidenceSmall.png" alt="PAA" /></center>
        </div>
        <div class = "columntr">
            <center>Patient Block Page</center>
        </div>
    </div>
</div>
    
    
    
<?php
if ($_SESSION['ptblock1'] && !$_SESSION['ptblock2'])
{
?>

<div class="topnav">
  <a href="eos.php">Evening of Surgery</a>
  <a href="ptblock1.php">Postoperative Day #1</a>
  <a href="blockInformation.php">Block Information</a>
  <a href="faq.php">FAQs</a>
  <a href="logout.php">Logout</a>
</div>
    
<?php
}
else if ($_SESSION['ptblock1'] && $_SESSION['ptblock2'])
{
?>
<div class="topnav">
  <a href="eos.php">Evening of Surgery</a>
  <a href="ptblock1.php">Postoperative Day #1</a>
  <a href="ptblock2.php">Postoperative Day #2</a>
  <a href="blockInformation.php">Block Information</a>
  <a href="faq.php">FAQs</a>
  <a href="logout.php">Logout</a>
</div>
<?php
}
else if (!($_SESSION['ptblock1'] && !$_SESSION['ptblock2']))
{
?>
<div class="topnav">
  <a href="eos.php">Evening of Surgery</a>
  <a href="blockInformation.php">Block Information</a>
  <a href="faq.php">FAQs</a>
  <a href="logout.php">Logout</a>
</div>
<?php
}

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
    blood flow (absent pulse or delayed capillary refill (Press the nail bed of that extremity, then let go.  
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
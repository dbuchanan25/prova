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
    ?>
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
    $_SESSION['ptblock1'] = false;  $_SESSION['ptblock2'] = false;
    
    $_SESSION['loginstring']='includes/connect.php';
    require_once ($_SESSION['loginstring']);
    
    $ph = $_SESSION['ptphone'];
    $phcomplete = "(".substr($ph,0,3).") ".substr($ph,3,3)."-".substr($ph,6);
    
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
    border-radius: undefined%;
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
h4{color:red; text-align: center; font-family:"Segoe UI",Arial,sans-serif; font-size:36px;}
h5{color:blue; text-align: center; font-family:"Segoe UI",Arial,sans-serif; font-size:32px;}
ul{font-family:"Segoe UI",Arial,sans-serif; font-size:28px; margin-left: 30px;}

.bodytext{text-align: justify; margin-left: 30px; margin-right: 30px; font-family:"Segoe UI",Arial,sans-serif; font-size:28px;}
.bodytext2{text-align: justify; margin-left: 30px; margin-right: 30px; font-family:"Segoe UI",Arial,sans-serif; font-size:28px; color:#0000DD;}

</style>
</head>
<body>

<script type="text/javascript">    
function doOnOrientationChange()
{
    window.location("resetwidth.php");
}
window.addEventListener('orientationchange', doOnOrientationChange);

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



<div class="columntr" style="background-color:#7db4dc; padding:20px;">
  <img src="includes/ProvidenceSmall.png" alt="PAA" style="height='.($winwidth*0.2369*.5*.7).'; width='.($winwidth*.5*.7).';" />
</div>';

    
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
    <h4>
    Continuous Perineural Nerve Block Catheters (CPNB, “pain pump”)
    </h4>
    <h5>
    What is a continuous perineural nerve block (CPNB) catheter?
    </h5>
    <div class="bodytext">
The CPNB is a pain control system where a small catheter (plastic tube) connected to a reservoir of local anesthetic (“pain pump” or “On-Q Ball”) 
continuously bathes local anesthetic around a nerve or bundle of nerves to reduce post-surgical pain. The local anesthetic reduces transmission of nerve signals so that the surgical site feels numb, “asleep”, and/or weak. The infusion reduces or eliminates surgical pain (most commonly in extremities – arm, leg, foot, etc.). It is important to note that the infusion might not completely eliminate pain. The nerve block is temporary, and it may cause feelings such as:
    </div>
<ul>
    <li>Numbness</li>
    <li>Tingling</li>
    <li>Heaviness</li>
    <li>Weakness</li>
    <li>Your arm or leg having fallen asleep</li>
</ul>
<br>
<div class="bodytext">
Catheters placed for shoulder or arm surgery frequently cause the following temporary side-effects:
</div>
<ul>
    <li>Mild shortness of breath</li>
    <li>Hoarse voice</li>
    <li>Blurry vision</li>
    <li>Unequal pupil size</li>
    <li>Drooping of your eye-lid or face on the same side as the nerve block</li>
</ul>
<div class="bodytext">
Once the catheter is removed it may take up to 4 to 24-hours for these effects to resolve.
</div>
<h5>
What do I need to do?
</h5>
<ul>
    <li>The CPNB system runs itself and requires little, if any, intervention.</li>
    <li>Upon arrival to your home, insure the catheter clamp is open. This is a small white clamp on the tubing, typically near the infusion ball.</li>
</ul>
<div class="bodytext">
    <b>Injury and falls</b> can occur when numbing medicine is used because of the inability to sense your extremity. Please follow these safety reminders:
</div>
<ul>
    <li>If you have an arm catheter pain pump, keep your arm in a sling or protected unless doing therapy.</li>
    <li>If you have a leg catheter pain pump, do not walk without your walker/crutches or with assistance from someone else.</li>
        <ul>
            <li>DO NOT STAND or PUT WEIGHT on the surgical leg.</li>
            <li>Keep your knee immobilizer or splint on unless doing therapy.</li>
            <li>Use the knee immobilizer/splint for 24 hours after the CPNB has been removed.</li>
        </ul>
</ul>
<div class="bodytext">
    You may be prescribed oral pain medication by your doctor. Take the medication as directed when needed even while the pain pump is in place. 
    As a reminder, eat something before taking any pain medicine to prevent getting nausea. If pain medication is/was not needed while the CPNB was in place, 
    we suggest beginning pain medication just prior to removal of the CPNB, or when sensation begins to return after discontinuing the CPNB.<br><br>
    <u>Do not drive while the catheter is in or for 24 hours after the CPNB is removed.</u> 
    After this, follow your surgeon’s directions on when to resume driving. Driving is discouraged if you are taking narcotic pain medications.
    If blood or fluid is noted around the catheter you may add a tape and gauze dressing over it.
    If the catheter falls out or is accidently pulled out call your doctor. Be sure to continue to take your pain medicine as directed.
    <br><br>
</div>
<div class="bodytext2">
    Immediately call the number listed for any of the following symptoms:<br>
    Novant Health Center City Outpatient Surgery Center: 704-513-1755
</div>
    <br><br>
    <div class="bodytext">
        <b>
        If you have any of these symptoms stop the infusion by clamping the tubing.
        </b>
    </div>
    <ul>
        <li>Redness, swelling, pain, or discharge at the injection site.</li>
        <li>Dizziness or lightheadedness.</li>
        <li>Blurred vision.</li>
        <li>Ringing or buzzing in your ears.</li>
        <li>Metallic taste in your mouth.</li>
        <li>Numbness or tingling around your mouth.</li>
        <li>Drowsiness.</li>
        <li>Confusion.</li>
        <li>Uncontrolled pain or vomiting.</li>
    </ul>
    <br>
    <div class="bodytext">
    The pain pump with numbing medicine may last 2 to 5-days. Remove the catheter when the collapsible pain pump is empty.
    </div>
    <ul>
        <li>Wash your hands with soap and water.</li>
        <li>Remove the tape over the catheter site.</li>
        <li>Remove any adhesive strips that may be present.</li>
        <li>Grasp the catheter close to the skin and gently pull it out. It should come easily and without pain. Once out, look for the black colored tip. Cover the site with a Band-Aid.</li>
        <ul>
            <li>Do not pull if there is resistance. Call your doctor.</li>
            <li>If you do not see the black tip call your doctor.</li>
            <li>Do not cut or pull hard to remove the catheter.</li>
        </ul>
        <li>Dispose of the pump, tubing and catheter safely. Keep out of reach of children and pets.</li>
    </ul>
    <h5>
    Why is this important to me?
    </h5>
    <ul>
        <li>Your comfort is our goal.</li>
        <li>You are at risk for injury. Following these instructions can keep you safe.</li>
        <li>A 24-hour contact number for questions or problems around the pump is in your patient guide that comes with the pain pump.</li>
    </ul>
    </body> 
<?php
}


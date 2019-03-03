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
    function doOnOrientationChange()
    {
        window.location("resetwidth.php");
    }
    window.addEventListener('orientationchange', doOnOrientationChange);
    </script>
    
    
    <?php
    $_SESSION['ptblock1'] = false;  $_SESSION['ptblock2'] = false;
    $_SESSION['ptblock3'] = false;  $_SESSION['ptblock4'] = false;
    
    $_SESSION['loginstring']='includes/connect.php';
    require_once ($_SESSION['loginstring']);

    $phcomplete = "";
    if (!isset($_SESSION['ptphone']))
    {
        $pp = "SELECT phone FROM patients AS a INNER JOIN patientusers AS b on a.id=b.patientsid WHERE a.id = '".$_SESSION["currentptnum"]."'";
        $rr = mysqli_query($dbc, $pp);
        if ($rr)
        {
            $ss = mysqli_fetch_array($rr);
            $phcomplete = $ss['phone'];
            $_SESSION['ptphone']=$phcomplete;
        }
    }
    
    $q = "SELECT painscore1, painscore2, painscore3, painscore4 ".
         "FROM patients ".
         "WHERE phone LIKE '".$_SESSION['ptphone']."' ".
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
<title>Block Information</title>
<meta charset="utf-8">
<link rel="stylesheet" href="styles/style2.css" type="text/css">
</head>
<body>
    
<?php
echo'
<div class="row2" style="background-color:#7db4dc; width:95%;  margin-left:auto;  margin-right:auto;">
  <center><img src="includes/ProvidenceSmall.png" alt="PAA" width: 70%;  margin-left: auto;  margin-right: auto;" /></center>  
</div>';

echo'
<div class="topnav" style="width:95%; margin-left:auto; margin-right:auto;">
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


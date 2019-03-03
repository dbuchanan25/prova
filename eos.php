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
    
    $phcomplete = $_SESSION['ptphone'];
    
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
<title>Evening of Surgery</title>
<meta charset="utf-8">
<link rel="stylesheet" href="styles/style2.css" type="text/css">
</head>
<body>

<?php
echo'
<div class="row2" style="background-color:#7db4dc; width:95%;  margin-left:auto;  margin-right:auto;">
  <center><img src="includes/ProvidenceSmall.png" alt="PAA" width: 70%;  margin-left:auto;  margin-right:auto;" /></center>  
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
    <br><br>
    <center><h1>Evening of Surgery Information</h1></center>
    <br><br>
    <br><br>
    </body>';
<?php
}

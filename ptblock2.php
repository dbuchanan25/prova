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
    $_SESSION['loginstring']='includes/connect.php';
    require_once ($_SESSION['loginstring']);
    
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
<head>
<title>Providence Anesthesiology</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="styles/style2.css" type="text/css">
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


<?php
echo'
<html>
<title>Block Day 2</title>
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

    $q1 = "SELECT * ".
          "FROM patients ".
          "WHERE phone LIKE '".$phcomplete."' ".
          "AND active = 1";
    $r1 = mysqli_query($dbc, $q1);
    $s1 = mysqli_fetch_array($r1);

echo
    '<center><h1>POSTOPERATIVE DAY #2</h1></center>'.
    '<br>'.
    '<svg height="10" width="'.$_SESSION['w'].'">'.
    '<line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />'.
    '</svg>'.
    '<center><h2>Pain Score</h2></center>'.
    '<center><h1>'.$s1['painscore2'].'</h1></center>'.
    '<center><h2>(from 1-10, with 1 being no pain and 10 being the worst pain imaginable)</h2></center><br>';


    if ($s1['motorblock2']==0)
    {
        $mb = "No";
    }
    else
    {
        $mb = "Yes";
    }

    echo
    '<svg height="10" width="'.$_SESSION['w'].'">'.
    '<line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />'.
    '</svg>'.
    '<br><br>'.
    '<h2><center>Did you have weakness in the area of the nerve block?</center></h2>'.
    '<center><h1>'.$mb.'</h1></center>'.
    '<br>';
            
    if ($s1['sensoryblock2']==0)
    {
        $sb = "No";
    }
    else
    {
        $sb = "Yes";
    }

    
    echo
    '<svg height="10" width="'.$_SESSION['w'].'">'.
    '<line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />'.
    '</svg>'.
    '<br><br>'.
    '<h2><center>Did you have numbness in the area of the nerve block?</center></h2>'.
    '<center><h1>'.$sb.'</h1></center>'.
    '<br>';
    
    
    
    if ($s1['acetaminophen2']==0)
    {
        $ace = "No";
    }
    else
    {
        $ace = "Yes";
    }

    echo
    '<svg height="10" width="'.$_SESSION['w'].'">'.
    '<line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />'.
    '</svg>'.
    '<br><br>'.
    '<h2><center>Did you take acetaminophen the second postoperative day?</center></h2>'.
    '<center><h1>'.$ace.'</h1></center>'.
    '<br>';


    if ($s1['nsaids2']==0)
    {
        $ns = "No";
    }
    else
    {
        $ns = "Yes";
    }

    echo
    '<svg height="10" width="'.$_SESSION['w'].'">'.
    '<line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />'.
    '</svg>'.
    '<br><br>'.
    '<h2><center>Did you take NSAIDS the second postoperative day?</center></h2>'.
    '<h2><center>(such as Motrin, Advil, ibuprofen, diclofenac, naproxen, Naprosyn, etodolac, ketorolac, Toradol)</center></h2>'.
    '<center><h1>'.$ns.'</h1></center>'.
    '<br>';

    if ($s1['narcotics2']==0)
    {
        $na = "No";
    }
    else
    {
        $na = "Yes";
    }

    echo
    '<svg height="10" width="'.$_SESSION['w'].'">'.
    '<line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />'.
    '</svg>'.
    '<br><br>'.
    '<h2><center>Did you take any narcotics the second postoperative day?</center></h2>'.
    '<h2><center>(such as oxycodone, hydrocodone, codeine, Lortab, Lorcet, Oxycontin, Vicodin, Percocet)</center></h2>'.
    '<center><h1>'.$na.'</h1></center>'.
    '<br>';
    
    if ($s1['method1'] == 'catheter')
    {
        if ($s1['drainage4']==0)
        {
            $drn = "No";
        }
        else
        {
            $drn = "Yes";
        }

        echo
        '<svg height="10" width="'.$_SESSION['w'].'">'.
        '<line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />'.
        '</svg>'.
        '<br><br>'.
        '<h2><center>Did you have any drainage from the catheter site on the second postoperative day?</center></h2>'.
        '<center><h1>'.$drn.'</h1></center>'.
        '<br>';
    }
    
    echo
    '</body>';
}
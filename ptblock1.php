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
    
    $_SESSION['loginstring']='includes/connect.php';
    require_once ($_SESSION['loginstring']);
    
    $ph = $_SESSION['ptphone'];
    $phcomplete = "(".substr($ph,0,3).") ".substr($ph,3,3)."-".substr($ph,6);
    
    $q = "SELECT painscore1 ".
         "FROM patients ".
         "WHERE phone LIKE '".$phcomplete."' ".
         "AND active = 1";
    $r = mysqli_query($dbc, $q);
    $score1 = -1;
    
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
<title>Block Day 1</title>
<body>

<div class="row2" style="background-color:#7db4dc; width:'.$_SESSION['w'].'">
  <center><img src="includes/ProvidenceSmall.png" alt="PAA" height='.($_SESSION['w']*0.2369*.5*.7).'; width='.($_SESSION['w']*.5*.7).';" /></center>
</div>';

if ($_SESSION['ptblock1'] && !$_SESSION['ptblock2'])
{
echo'
<div class="topnav" style="width:'.$_SESSION['w'].'">
  <a href="eos.php">Evening of Surgery</a>
  <a href="ptblock1.php">Postoperative Day #1</a>
  <a href="blockInformation.php">Block Information</a>
  <a href="faq.php">FAQs</a>
  <a href="logout.php">Logout</a>
</div>';
}
else if ($_SESSION['ptblock1'] && $_SESSION['ptblock2'])
{
echo'
<div class="topnav" style="width:'.$_SESSION['w'].'">
  <a href="eos.php">Evening of Surgery</a>
  <a href="ptblock1.php">Postoperative Day #1</a>
  <a href="ptblock2.php">Postoperative Day #2</a>
  <a href="blockInformation.php">Block Information</a>
  <a href="faq.php">FAQs</a>
  <a href="logout.php">Logout</a>
</div>';
}
else if (!($_SESSION['ptblock1'] && !$_SESSION['ptblock2']))
{
echo'
<div class="topnav" style="width:'.$_SESSION['w'].'">
  <a href="eos.php">Evening of Surgery</a>
  <a href="blockInformation.php">Block Information</a>
  <a href="faq.php">FAQs</a>
  <a href="logout.php">Logout</a>
</div>';
}

    $q1 = "SELECT * ".
          "FROM patients ".
          "WHERE phone LIKE '".$phcomplete."' ".
          "AND active = 1";
    $r1 = mysqli_query($dbc, $q1);
    $s1 = mysqli_fetch_array($r1);
    

echo
    '<center><h1>POSTOPERATIVE DAY #1</h1></center>'.
    '<br>'.
    '<svg height="10" width="'.$_SESSION['w'].'">'.
    '<line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />'.
    '</svg>'.
    '<center><h2>Pain Score</h2></center>'.
    '<center><h1>'.$s1['painscore1'].'</h1></center>'.
    '<center><h2>(from 1-10, with 1 being no pain and 10 being the worst pain imaginable)</h2></center><br>';


    if ($s1['motorblock1']==0)
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
    '<br><br>'.
    '<h2><center>Did you have weakness in the area of the nerve block?</center></h2>'.
    '<center><h1>'.$mb.'</h1></center>'.
    '<br>';
            
    if ($s1['sensoryblock1']==0)
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
    
    
    
    if ($s1['acetaminophen1']==0)
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
    '<h2><center>Did you take acetaminophen the first postoperative day?</center></h2>'.
    '<center><h1>'.$ace.'</h1></center>'.
    '<br>';


    if ($s1['nsaids1']==0)
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
    '<h2><center>Did you take NSAIDS the first postoperative day?</center></h2>'.
    '<h2><center>(such as Motrin, Advil, ibuprofen, diclofenac, naproxen, Naprosyn, etodolac, ketorolac, Toradol)</center></h2>'.
    '<center><h1>'.$ns.'</h1></center>'.
    '<br>';

    if ($s1['narcotics1']==0)
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
    '<h2><center>Did you take any narcotics the first postoperative day?</center></h2>'.
    '<h2><center>(such as oxycodone, hydrocodone, codeine, Lortab, Lorcet, Oxycontin, Vicodin, Percocet)</center></h2>'.
    '<center><h1>'.$na.'</h1></center>'.
    '<br>'.
    '</body>';
}
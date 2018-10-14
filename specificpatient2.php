<?php
//////////////////////////////////////////////////////////////////////////////////////////////////
//PATIENT INTERFACE                                                                             //
//VERSION 01_01                                                                                 //
//LAST REVISED 20180811                                                                         //
//////////////////////////////////////////////////////////////////////////////////////////////////

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
   $_SESSION['loginstring']='includes/connect.php';
   require_once ($_SESSION['loginstring']);
   
   $winwidth = $_SESSION['w']; 
   $ptnum = $_GET['p'];
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

$sp = "SELECT a.id, a.fname, a.lname, a.phone, a.email, b.location, c.surgeonFirst, c.surgeonLast, d.first, d.last, ".
      "       e.cptDescriptor, e.asaCode, f.block as block1, g.med as med1, h.block as block2, i.med as med2, a.monthnumber, a.daynumber, ".
      "       a.painscore1, a.painscore2 ".
      "FROM patients AS a ".
      "INNER JOIN locations AS b ON a.orlocID=b.id ".
      "INNER JOIN surgeons AS c ON a.surgeonID=c.surgeonID ".
      "INNER JOIN users AS d ON a.anesthesiologistID=d.id ".
      "INNER JOIN asa AS e ON a.cptID=e.id ".
      "INNER JOIN blocks AS f ON a.block1ID=f.id ".
      "INNER JOIN drug AS g ON g.id=a.drug1ID ".
      "INNER JOIN blocks AS h ON a.block2ID=h.id ".
      "INNER JOIN drug AS i ON i.id=a.drug2ID ".  
      "WHERE a.id=".$ptnum;
            
$spa = mysqli_query($dbc, $sp);
$spb = mysqli_fetch_array($spa);

echo'
<html>
<title>Block</title>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>  
    .row:after 
    {
        content: "";
        display: table;
        clear: both;
    } 
    </style>
<link rel="stylesheet" href="styles/stylew3.css" type="text/css">
</head>


<body>

<div class="row" style="background-color:#7db4dc;">
  <center><img src="includes/ProvidenceSmall.png" alt="PAA" height='.($winwidth*0.2369*.5*.7).'; width='.($winwidth*.5*.7).';" /></center>
  <div class="w3-padding w3-center"><h1>Patient Information</h1></div>
</div>

<div class="w3-sidebar w3-bar-block w3-light-grey w3-card" style="width:130px">
  <h5 class="w3-bar-item"><b>Menu</b></h5>
  <button class="w3-bar-item w3-button tablink" onclick="window.location.href=\'registration.php\'">Patient Registration</button>
  <button class="w3-bar-item w3-button tablink" onclick="window.location.href=\'patientinfo.php\'">Active Patient List</button>
  <button class="w3-bar-item w3-button tablink" onclick="window.location.href=\'comPtList.php\'">Complete Patient List</button>
  <button class="w3-bar-item w3-button tablink" onclick="window.location.href=\'statistics.php\'">Statistics</button>
</div>

<div style="margin-left:130px"> 
<br><br>
<div id="PtList" class="w3-container reg">';

if ($_SESSION['w'] > 925)
{
    echo'
        <br>
        <table style="border-style:solid; width:60%; margin-left:auto; margin-right:auto;">';
}
else
{
    echo'
        <br>
        <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">';
}
echo'
    <tr>                                      
        <td style="width:40%; border:none; text-align:right; padding:10px;">
        <b>Patient Name:</b>
        <td style="width:60%; padding:10px;">'.
            $spb['fname'].' '.$spb['lname'].'
        </td>
    </tr>
    <tr>
        <td style="width:40%; border:none; text-align:right; padding:10px;">
        <b>Phone:</b>
        </td>
        <td style="width:60%; padding:10px;">'.
            $spb['phone'].'
        </td>
    </tr>
    <tr>
        <td style="width:40%; border:none; text-align:right; padding:10px;">
            <b>Email Address:</b>
        </td>
        <td style="width:60%; padding:10px;">'
            .$spb['email'].'
        </td>
    </tr>
    <tr>
        <td style="width:40%; text-align:right; padding:10px">
        <b>OR Location:</b>
        </td>
        <td style="width:60%; border:none; align:center; padding:10px">'.                    
            $spb['location'].'
        </td>
     </tr>
     <tr>
        <td style="width:40%; border:none; text-align:right; padding:10px;">
            <b>Block Anesthesiologist:</b>
        </td>

        <td style="border:none; width:60%; padding:10px">'.
            $spb['first'].' '.$spb['last'].'
        </td>
    </tr>
    </tr>
        <td style="width:40%; border:none; text-align:right">
            <b>Surgeon:</b>
        </td>

        <td style="border:none; width:60%; padding:10px">'.
            $spb['surgeonFirst'].' '.$spb['surgeonLast'].'
        </td>
     </tr>
     <tr>            
        <td style="width:40%; border:none; text-align:right">
            <b>CPT:</b>
        </td>

        <td style="border:none; width:60%; padding:10px">'.
            $spb['asaCode'].' - '.$spb['cptDescriptor'].
        '</td>
    </tr>
</table>
<br>

<center>
<h1 class="h1log" style="text-align:left color:#000000">Primary Block</h1>';

if ($_SESSION['w'] > 925)
{
    echo'
    <table style="border-style:solid; width:60%; margin-left:auto; margin-right:auto;">';
}
else
{
    echo'
    <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">';
}

echo'
    <tr>
        <td style="width:40%; border:none; text-align:right; padding:10px">
            <b>Type of Block:</b>
        </td>

        <td style="border:none; width:60%; padding:10px">'.
            $spb['block1'].'
        </td>
    </tr>
    <tr>            
        <td style="width:40%; border:none; text-align:right; padding:10px;">
            <b>Local:</b>
        </td>

        <td style="border:none; width:60%; padding:10px">'.
            $spb['med1'].'                
        </td>
    </tr>
    <tr>            
        <td style="width:40%; border:none; text-align:right; padding:10px">
            <b>Volume (ml):</b>
        </td>

        <td style="width:60%; padding:10px">'.
            $_SESSION['volume1'].'
        </td>
    </tr>
    <tr>
        <td style="width:40%; border:none; text-align:right; padding:10px;">
                <b>Additives:</b>
        </td>';

    if (isset($_SESSION['addi1']))
    {
       foreach($_SESSION['addi1'] as $a1)
       {
           switch($a1)
           {
                case "epi100":
                    $a11 = "Epinephrine 1:100,000";
                    break;
                case "epi200":
                    $a11 = "Epinephrine 1:200,000";
                    break;
                case "clonidine":
                    $a11 = "Clonidine";
                    break;
                case "dex":
                    $a11 = "Dexmedetomidine";
                    break;
                case "decadron":
                    $a11 = "Decadron";
                    break;
           }
           echo '<td style="width:60%; padding:10px">'.$a11.'</td></tr><tr><td style="width:40%; padding:10px"></td>';
       }
    }
    else
    {
        echo '<td style="width:60%; padding:10px">None</td>';
    }
echo'
        </tr>            
    </table>
    <br>
    <br>';

if (isset($spb['block2']))
{            
echo'
<center>
    <h1 class="h1log" style="text-align:left color:#000000">Secondary Block</h1>';

    if ($_SESSION['w'] > 925)
    {
        echo'
        <table style="border-style:solid; width:60%; margin-left:auto; margin-right:auto;">';
    }
    else
    {
        echo'
        <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">';
    }

    echo'
        <tr>
            <td style="width:40%; border:none; text-align:right; padding:10px">
                <b>Type of Block:</b>
            </td>

            <td style="border:none; width:60%; padding:10px">'.
                $spb['block2'].'
            </td>
        </tr>
        <tr>            
            <td style="width:40%; border:none; text-align:right; padding:10px;">
                <b>Local:</b>
            </td>

            <td style="border:none; width:60%; padding:10px">'.
                $spb['med2'].'                
            </td>
        </tr>
        <tr>            
            <td style="width:40%; border:none; text-align:right; padding:10px">
                <b>Volume (ml):</b>
            </td>

            <td style="width:60%; padding:10px">'.
                $_SESSION['volume2'].'
            </td>
        </tr>
        <tr>
            <td style="width:40%; border:none; text-align:right; padding:10px;">
                    <b>Additives:</b>
            </td>';

        if (isset($_SESSION['addi2']))
        {
           foreach($_SESSION['addi2'] as $a2)
           {
               switch($a2)
               {
                    case "epi100":
                        $a22 = "Epinephrine 1:100,000";
                        break;
                    case "epi200":
                        $a22 = "Epinephrine 1:200,000";
                        break;
                    case "clonidine":
                        $a22 = "Clonidine";
                        break;
                    case "dex":
                        $a22 = "Dexmedetomidine";
                        break;
                    case "decadron":
                        $a22 = "Decadron";
                        break;
               }
               echo '<td style="width:60%; padding:10px">'.$a22.'</td></tr><tr><td style="width:40%; padding:10px"></td>';
           }
        }
        else
        {
            echo '<td style="width:60%; padding:10px">None</td>';
        }
}
echo'
        </tr>            
    </table>
    <br><br>
    <center>';

if ($spb['painscore1'] > -1 && $spb['painscore2'] > -1)
{
    
}  
else if ($spb['painscore1'] > -1 && $spb['painscore2'] == -1)
{
    echo'
    <h1 class="h1log" style="text-align:left color:#000000">Followup: Day 2</h1>
    <form action="action_page_day2.php" method="post">';

    if ($_SESSION['w'] > 925)
    {
        echo'
        <table style="border-style:solid; width:60%; margin-left:auto; margin-right:auto;">';
    }
    else
    {
        echo'
        <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">';
    }

    echo'
    <tr>
    <td>
    <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Pain Score: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="pain2">';
            for ($x=0; $x<11; $x++)
            {
               echo '<option value='.$x.'>'.$x.'</option>';
            }
    echo'
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Sensory Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="sensoryblock2">
               <option value="no">No</option><option value="yes">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Motor Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="motorblock2">
               <option value="no">No</option><option value="yes">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>NSAID Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="nsaids2">
               <option value="no">No</option><option value="yes">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Acetaminophen Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="acetaminophen2">
               <option value="no">No</option><option value="yes">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Narcotic Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="narcotic2">
               <option value="no">No</option><option value="yes">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Drainage: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="drainage2">
               <option value="no">No</option><option value="yes">Yes</option>
            </select>
            </td>
        </tr>
    </table>
    </td>
    </tr>
    <tr>
    <td>
    <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">
        <tr>
            <td style="width:100%; padding:10px; margin-left:auto; margin-right:auto;">
                <textarea style="width: 90%; height: 10%; margin: 0 auto; display: block;" name="comments2">'.
                'Comments: '.
                '</textarea>
            </td>
        </tr>
    </table>
    </td>
    </tr>
    </table>
    <br><br>
    <table style="width:100%">
        <tr>
            <td align="center">
            <input type="submit" name="day1" value="SUBMIT" class="btn">
            </td>
        </tr>
    </table>

    </form>

    </div>';
}
else
{
    echo'
    <h1 class="h1log" style="text-align:left color:#000000">Followup: Day 1</h1>
    <form action="action_page_day1.php" method="post">';

    if ($_SESSION['w'] > 925)
    {
        echo'
        <table style="border-style:solid; width:60%; margin-left:auto; margin-right:auto;">';
    }
    else
    {
        echo'
        <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">';
    }

    echo'
    <tr>
    <td>
    <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Pain Score: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="pain1">';
            for ($x=0; $x<11; $x++)
            {
               echo '<option value='.$x.'>'.$x.'</option>';
            }
    echo'
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Sensory Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="sensoryblock1">
               <option value="no">No</option><option value="yes">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Motor Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="motorblock1">
               <option value="no">No</option><option value="yes">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>NSAID Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="nsaids1">
               <option value="no">No</option><option value="yes">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Acetaminophen Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="acetaminophen1">
               <option value="no">No</option><option value="yes">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Narcotic Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="narcotic1">
               <option value="no">No</option><option value="yes">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Drainage: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="drainage1">
               <option value="no">No</option><option value="yes">Yes</option>
            </select>
            </td>
        </tr>
    </table>
    </td>
    </tr>
    <tr>
    <td>
    <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">
        <tr>
            <td style="width:100%; padding:10px; margin-left:auto; margin-right:auto;">
                <textarea style="width: 90%; height: 10%; margin: 0 auto; display: block;" name="comments1">'.
                'Comments: '.
                '</textarea>
            </td>
        </tr>
    </table>
    </td>
    </tr>
    </table>
    <br><br>
    <table style="width:100%">
        <tr>
            <td align="center">
            <input type="submit" name="day1" value="SUBMIT" class="btn">
            </td>
        </tr>
    </table>

    </form>

    </div>';
}
?>

   
<script>
    
function openInfo(evt, tabName) 
{
  var i, x, tablinks;
  x = document.getElementsByClassName("reg");
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" w3-pacolor", ""); 
  }
  document.getElementById(tabName).style.display = "block";
  evt.currentTarget.className += " w3-pacolor";
}

document.getElementById("defaultOpen").click();
</script>

<?php
echo'
</body>
</html>'; 
}
?>


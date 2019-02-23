<?php
//////////////////////////////////////////////////////////////////////////////////////////////////                                                                             //
//VERSION 01_03                                                                                 //
//LAST REVISED 20190222                                                                         //
//Page presents entered information which has been entered by a physician user about a patient's//
//follow-up day 4 for confirmation before entering it into the database.                        //
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
    if (isset($_SESSION['pain4']))
       unset($_SESSION['painscore4']);
    if (isset($_SESSION['sensoryblock4']))
       unset($_SESSION['sensoryblock4']);
    if (isset($_SESSION['motorblock4']))
       unset($_SESSION['motorblock4']);
    if (isset($_SESSION['nsaids4']))
       unset($_SESSION['nsaids4']);
    if (isset($_SESSION['acetaminophen4']))
       unset($_SESSION['acetaminophen4']);
    if (isset($_SESSION['narcotics4']))
       unset($_SESSION['narcotics4']);
    if (isset($_SESSION['drainage4']))
       unset($_SESSION['drainage4']);
    if (isset($_SESSION['comments4']))
       unset($_SESSION['comments4']);
    
    $_SESSION['painscore4'] = $_POST['pain4'];
    $_SESSION['sensoryblock4'] = $_POST['sensoryblock4'];
    $_SESSION['motorblock4'] = $_POST['motorblock4'];
    $_SESSION['nsaids4'] = $_POST['nsaids4'];
    $_SESSION['acetaminophen4'] = $_POST['acetaminophen4'];
    $_SESSION['narcotics4'] = $_POST['narcotics4'];
    $_SESSION['drainage4'] = $_POST['drainage4'];
    $_SESSION['comments4'] = $_POST['comments4'];
    
    $_SESSION['loginstring']='includes/connect.php';
    require_once ($_SESSION['loginstring']);
    
    
    $sp = "SELECT a.id, a.fname, a.lname, a.phone, a.email, b.location, c.surgeonFirst, c.surgeonLast, d.first, d.last, ".
             "e.cptDescriptor, e.asaCode, f.block as block1, g.med as med1, a.vol1, h.block as block2, i.med as med2, a.vol2, a.monthnumber, a.daynumber, ".
             "a.painscore1, motorblock1, a.sensoryblock1, a.nsaids1, a.acetaminophen1, a.narcotics1, a.drainage1, a.comments1, ".
             "a.painscore2, motorblock2, a.sensoryblock2, a.nsaids2, a.acetaminophen2, a.narcotics2, a.drainage2, a.comments2, ".
             "a.painscore3, motorblock3, a.sensoryblock3, a.nsaids3, a.acetaminophen3, a.narcotics3, a.drainage3, a.comments3, ".
             "a.painscore4, motorblock4, a.sensoryblock4, a.nsaids4, a.acetaminophen4, a.narcotics4, a.drainage4, a.comments4 ".
        "FROM patients AS a ".
        "INNER JOIN locations AS b ON a.orlocID=b.id ".
        "INNER JOIN surgeons AS c ON a.surgeonID=c.surgeonID ".
        "INNER JOIN users AS d ON a.anesthesiologistID=d.id ".
        "INNER JOIN asa AS e ON a.cptID=e.id ".
        "INNER JOIN blocks AS f ON a.block1ID=f.id ".
        "INNER JOIN drug AS g ON g.id=a.drug1ID ".
        "INNER JOIN blocks AS h ON a.block2ID=h.id ".
        "INNER JOIN drug AS i ON i.id=a.drug2ID ".  
        "WHERE a.id=".$_SESSION['currentptnum'];
            
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
  <center><img src="includes/ProvidenceSmall.png" alt="PAA" height='.($_SESSION['w']*0.2369*.5*.7).'; width='.($_SESSION['w']*.5*.7).';" /></center>
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
            $spb['vol1'].'
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
if ($spb['block2'] != 'None')
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
                $spb['vol2'].'
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


//DAY 1
echo'
    <h1 class="h1log" style="color:#000000">Followup: Day 1</h1>';
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
    <tr><td>
    <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Pain Score: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $spb['painscore1'].'
            </td>
        </tr>';
    if ($spb['sensoryblock1']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Sensory Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($spb['motorblock1']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Motor Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($spb['nsaids1']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>NSAID Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($spb['acetaminophen1']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Acetaminophen Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($spb['narcotics1']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Narcotic Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($spb['drainage1']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Drainage: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>
    </table>
    </td></tr>
    <tr><td>
    <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">
        <tr>
            <td style="width:100%; border:none; text-align:left; padding:10px">'.
                $spb['comments1'].'
            </td>
        </tr>
    </table>
    </td></tr>
    </table><br>';
    $_SESSION['revise1'] = 1;
    echo'
    <table style="width:60%">
        <tr>
            <td align="center">
            <button class="btn" id="ce" onclick=window.location="specificpatient.php">REVISE DAY 1</button>
            </td>
        </tr>
    </table>
    ';


//DAY 2
echo'
    <h1 class="h1log" style="color:#000000">Followup: Day 2</h1>';
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
    <tr><td>
    <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Pain Score: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $spb['painscore2'].'
            </td>
        </tr>';
    if ($spb['sensoryblock2']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Sensory Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($spb['motorblock2']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Motor Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($spb['nsaids2']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>NSAID Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($spb['acetaminophen2']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Acetaminophen Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($spb['narcotics2']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Narcotic Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($spb['drainage2']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Drainage: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>
    </table>
    </td></tr>
    <tr><td>
    <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">
        <tr>
            <td style="width:100%; border:none; text-align:left; padding:10px">'.
                $spb['comments2'].'
            </td>
        </tr>
    </table>
    </td></tr>
    </table><br>';
    $_SESSION['revise2'] = 1;
    echo'
    <table style="width:60%">
        <tr>
            <td align="center">
            <button class="btn" id="ce" onclick=window.location="specificpatient.php">REVISE DAY 2</button>
            </td>
        </tr>
    </table>
    ';
    
//DAY 3
echo'
    <h1 class="h1log" style="color:#000000">Followup: Day 3</h1>';
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
    <tr><td>
    <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Pain Score: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $spb['painscore3'].'
            </td>
        </tr>';
    if ($spb['sensoryblock3']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Sensory Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($spb['motorblock3']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Motor Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($spb['nsaids3']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>NSAID Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($spb['acetaminophen3']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Acetaminophen Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($spb['narcotics3']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Narcotic Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($spb['drainage3']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Drainage: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>
    </table>
    </td></tr>
    <tr><td>
    <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">
        <tr>
            <td style="width:100%; border:none; text-align:left; padding:10px">'.
                $spb['comments3'].'
            </td>
        </tr>
    </table>
    </td></tr>
    </table><br>';
    $_SESSION['revise3'] = 1;
    echo'
    <table style="width:60%">
        <tr>
            <td align="center">
            <button class="btn" id="ce" onclick=window.location="specificpatient.php">REVISE DAY 3</button>
            </td>
        </tr>
    </table>
    ';    
    
//DAY 4    
echo'
    <h1 class="h1log" style="color:#000000">Followup: Day 4</h1>';
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
    <tr><td>
    <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Pain Score: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $_SESSION['painscore4'].'
            </td>
        </tr>';
    if ($_SESSION['sensoryblock4']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Sensory Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($_SESSION['motorblock4']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Motor Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($_SESSION['nsaids4']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>NSAID Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($_SESSION['acetaminophen4']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Acetaminophen Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($_SESSION['narcotics4']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Narcotic Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($_SESSION['drainage4']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Drainage: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>
    </table>
    </td></tr>
    <tr><td>
    <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">
        <tr>
            <td style="width:100%; border:none; text-align:left; padding:10px">'.
                $_SESSION['comments4'].'
            </td>
        </tr>
    </table>
    </td></tr>
    </table>
    
    
    <br>
            <table style="width:60%">
                <tr>
                    <td align="center">
                    <button class="btn" id="ce" onclick="ce()">CONFIRM ENTRY</button>
                    </td>
                    <td align="center">
                    <button class="btn" id="dso" onclick="godso()">DISCARD/START OVER</button>
                    </td>
                </tr>
            </table><br><br>';
    ?>
    
    <script>
    function godso() 
    {
        window.location="specificpatient.php";
    }
    function ce()
    {
        window.location="action_page_day4_2.php";
    }
    </script>
<?php
}
?>
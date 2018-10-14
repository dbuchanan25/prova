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
    if (isset($_SESSION['pain2']))
       unset($_SESSION['painscore2']);
    if (isset($_SESSION['sensoryblock2']))
       unset($_SESSION['sensoryblock2']);
    if (isset($_SESSION['motorblock2']))
       unset($_SESSION['motorblock2']);
    if (isset($_SESSION['nsaids2']))
       unset($_SESSION['nsaids2']);
    if (isset($_SESSION['acetaminophen2']))
       unset($_SESSION['acetaminophen2']);
    if (isset($_SESSION['narcotics2']))
       unset($_SESSION['narcotics2']);
    if (isset($_SESSION['drainage2']))
       unset($_SESSION['drainage2']);
    if (isset($_SESSION['comments2']))
       unset($_SESSION['comments2']);
    
    $_SESSION['painscore2'] = $_POST['pain2'];
    $_SESSION['sensoryblock2'] = $_POST['sensoryblock2'];
    $_SESSION['motorblock2'] = $_POST['motorblock2'];
    $_SESSION['nsaids2'] = $_POST['nsaids2'];
    $_SESSION['acetaminophen2'] = $_POST['acetaminophen2'];
    $_SESSION['narcotics2'] = $_POST['narcotics2'];
    $_SESSION['drainage2'] = $_POST['drainage2'];
    $_SESSION['comments2'] = $_POST['comments2'];
    
    $_SESSION['loginstring']='includes/connect.php';
    require_once ($_SESSION['loginstring']);
    
    
    $sp = "SELECT a.id, a.fname, a.lname, a.phone, a.email, b.location, c.surgeonFirst, c.surgeonLast, d.first, d.last, ".
             "e.cptDescriptor, e.asaCode, f.block as block1, g.med as med1, a.vol1, h.block as block2, i.med as med2, a.vol2, a.monthnumber, a.daynumber, ".
             "a.painscore1, motorblock1, a.sensoryblock1, a.nsaids1, a.acetaminophen1, a.narcotics1, a.drainage1, a.comments1, ".
             "a.painscore2, motorblock2, a.sensoryblock2, a.nsaids2, a.acetaminophen2, a.narcotics2, a.drainage2, a.comments2 ".
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
            $_SESSION['painscore2'].'
            </td>
        </tr>';
    if ($_SESSION['sensoryblock2']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Sensory Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($_SESSION['motorblock2']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Motor Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($_SESSION['nsaids2']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>NSAID Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($_SESSION['acetaminophen2']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Acetaminophen Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($_SESSION['narcotics2']  == 1){$z = 'Yes';} else {$z = 'No';}
    echo'
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Narcotic Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">'.
            $z.'
            </td>
        </tr>';
    if ($_SESSION['drainage2']  == 1){$z = 'Yes';} else {$z = 'No';}
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
                $_SESSION['comments2'].'
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
        window.location="action_page_day2_2.php";
    }
    </script>
<?php
}
?>
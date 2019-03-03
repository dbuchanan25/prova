<?php
//////////////////////////////////////////////////////////////////////////////////////////////////
//PATIENT INTERFACE                                                                             //
//VERSION 01_01                                                                                 //
//LAST REVISED 20180811                                                                         //
//Brings up page of a patient's information (specificpatient.php?p=1) to a physician user       //
//showing blocks, follow-up days, ability to revise a day's information, and to make the        //
//patient inactive                                                                              //
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
   if (!isset($_SESSION['revise1']))
       $_SESSION['revise1'] = false;
   if (!isset($_SESSION['revise2']))
       $_SESSION['revise2'] = false;
   if (!isset($_SESSION['revise3']))
       $_SESSION['revise3'] = false;
   if (!isset($_SESSION['revise4']))
       $_SESSION['revise4'] = false;
   
   $_SESSION['loginstring']='includes/connect.php';
   require_once ($_SESSION['loginstring']);
   
   $winwidth = $_SESSION['w']; 
   if (isset ($_GET['p']))
       $ptnum = $_GET['p'];
   else if (isset($_SESSION['currentptnum']))
       $ptnum = $_SESSION['currentptnum'];
   else
       godso();
?>
<script type="text/javascript">
    function godso() 
    {
        window.location="patientinfo.php";
    }

    function doOnOrientationChange()
    {
        window.location("resetwidth.php");
    }
    window.addEventListener('orientationchange', doOnOrientationChange); 

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

    function rev1()
    {
        window.location.assign("specificpatientr1.php");
    }
    function rev2()
    {
        window.location.assign("specificpatientr2.php");
    }
    function rev3()
    {
        window.location.assign("specificpatientr3.php");
    }
    function rev4()
    {
        window.location.assign("specificpatientr4.php");
    }
</script>
       
<?php 

//---------------------------------------------------------------------------------------------------------------------------------------------------
//GET INFORMATION

$sp = "SELECT a.id, a.fname, a.lname, a.phone, b.location, c.surgeonFirst, c.surgeonLast, d.first, d.last, a.active, ".
             "e.cptDescriptor, e.asaCode, f.block as block1, a.vol1, a.addi1, a.method1, g.med as med1, h.block as block2, i.med as med2, ".
             "a.vol2, a.addi2, a.method2, a.monthnumber, a.daynumber, ".
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
      "WHERE a.id=".$ptnum;

            
$spa = mysqli_query($dbc, $sp);
$spb = mysqli_fetch_array($spa);

$_SESSION['currentptnum'] = $ptnum;



//---------------------------------------------------------------------------------------------------------------------------------------------------
//SET UP TABS
 
echo'
<title>Patient Information</title>
<link rel="stylesheet" href="styles/style2.css" type="text/css">
</head>
<body>

<div class="row" style="background-color:#7db4dc; width:95%; padding:10px; margin-right:auto; margin-left:auto;">';

if ($winwidth > 925)
{
  echo
  '<center><img src="includes/ProvidenceSmall.png" alt="PAA" height='.($winwidth*0.2369*.5*.7).'; width='.($winwidth*.5*.7).';" /></center>'.
  '<h1 style="text-align:center;">Patient Information</h1>';
}
else
{
  echo
  '<center><img src="includes/ProvidenceSmall.png" alt="PAA" width=50%;" /></center>'.
  '<h3 style="text-align:center;">Patient Information</h3>';
}

echo'
  
</div>
<br>';

echo'
<div class="topnav" style="width:95%; margin-right:auto; margin-left:auto">
  <a href="registration.php">Patient Registration</a>';

if ($_SESSION['access'] == 1)
{
    echo'
    <a href="patientinfo.php">Active Patient List</a>
    <a href="comPtList.php">Complete Patient List</a>
    <a href="statistics.php">Statistics</a>';
}
    echo'
    <a href="logout.php">Logout</a>
</div>';

echo'
<br><br>'; 




//---------------------------------------------------------------------------------------------------------------------------------------------------
//DISPLAY DEMOGRAPHIC DATA



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
<br>';




//---------------------------------------------------------------------------------------------------------------------------------------------------
//DISPLAY PRIMARY BLOCK DATA



echo'
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

if ($spb['method1'] == 'singleshot')
{
    $m1 = 'Single Shot';
}
else
{
    $m1 = 'Catheter';
}
if ($spb['method2'] == 'singleshot')
{
    $m2 = 'Single Shot';
}
else
{
    $m2 = 'Catheter';
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
        <td style="width:40%; border:none; text-align:right; padding:10px">
            <b>Method: </b>
        </td>
        <td style="width:60%; padding:10px">'.
            $m1.'
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

    if ($spb['addi1'] != "")
    {
       $pieces1 = explode(" ", $spb['addi1']);

       foreach($pieces1 as $a1)
       {
           switch($a1)
           {
                case "epi100":
                    $a12 = "Epinephrine 1:100,000";
                    break;
                case "epi200":
                    $a12 = "Epinephrine 1:200,000";
                    break;
                case "clonidine":
                    $a12 = "Clonidine";
                    break;
                case "dex":
                    $a12 = "Dexmedetomidine";
                    break;
                case "decadron":
                    $a12 = "Decadron";
                    break;
                case "":
                    $a12 = "";
                    break;
                default:
                    $a12 = "";
                    break;
           }
           if ($a12 != "")
           {
                echo '<td style="width:60%; padding:10px">'.$a12.'</td></tr><tr><td style="width:40%; padding:10px"></td>';
           }
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



//---------------------------------------------------------------------------------------------------------------------------------------------------
//IF AVAILABLE, DISPLAY SECONDARY BLOCK DATA

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
        <td style="width:40%; border:none; text-align:right; padding:10px">
            <b>Method: </b>
        </td>
        <td style="width:60%; padding:10px">'.
            $m2.'
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

        if ($spb['addi2'] != "")
        {
           $pieces2 = explode(" ", $spb['addi2']);
           
           foreach($pieces2 as $a2)
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
                    case "":
                        $a22 = "";
                        break;
                    default:
                        $a22 = "";
                        break;
               }
               if ($a22 != "")
               {
                    echo '<td style="width:60%; padding:10px">'.$a22.'</td></tr><tr><td style="width:40%; padding:10px"></td>';
               }
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
    <br>
    <center>
    <table style="width:60%">
        <tr>
            <td align="center">
            <button class="btn" id="c2" onClick="window.location = \'registrationR.php\'" />REVISE PATIENT INFORMATION</button>
            </td>
        </tr>
    </table><br><br>'
    ;



//---------------------------------------------------------------------------------------------------------------------------------------------------
//CASES


















//---------------------------------------------------------------------------------------------------------------------------------------------------
//CASE:  IF DAY1 AND DAY2 FOLLOWUP HAVE BEEN COMPLETED 
//DISPLAYS THE CASE AND THE FOLLOW-UP DATA

if (
       $spb['active'] == 0 ||
       (
         ($spb['painscore1'] > -1 && $_SESSION['revise1'] == 0) && 
         ($spb['painscore2'] > -1 && $_SESSION['revise2'] == 0) &&
         ($spb['painscore3'] > -1 && $_SESSION['revise3'] == 0) && 
         ($spb['painscore4'] > -1 && $_SESSION['revise4'] == 0)
       )
   )
{
    if ($spb['painscore1'] > -1)
    {
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
        </table>';
        echo'
        <br>
        <table style="width:60%">
            <tr>
                <td align="center">
                <button class="btn" id="ce" onclick="rev1()">REVISE DAY 1</button>
                </td>
            </tr>
        </table>
        ';
    }
    
    if ($spb['painscore2'] > -1)
    {
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
        </table>
        <br>';
    
    
    
    
        $_SESSION['revise2'] = 1;

        echo'
        <table style="width:60%">
            <tr>
                <td align="center">
                <button class="btn" onclick="rev2()">REVISE DAY 2</button>
                </td>
            </tr>
        </table>
        <br>';
    }
    
    if ($spb['painscore3'] > -1)
    {
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
        </table>
        <br>';
       
        $_SESSION['revise3'] = 1;

        echo'
        <table style="width:60%">
            <tr>
                <td align="center">
                <button class="btn" onclick="rev3()">REVISE DAY 3</button>
                </td>
            </tr>
        </table>
        <br>';
    }

        
    
    if ($spb['painscore4'] > -1)
    {
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
                $spb['painscore4'].'
                </td>
            </tr>';
        if ($spb['sensoryblock4']  == 1){$z = 'Yes';} else {$z = 'No';}
        echo'
            <tr>
                <td style="width:50%; border:none; text-align:right; padding:10px">
                    <b>Sensory Block: </b>
                </td>
                <td style="width:50%; border:none; padding:10px">'.
                $z.'
                </td>
            </tr>';
        if ($spb['motorblock4']  == 1){$z = 'Yes';} else {$z = 'No';}
        echo'
            <tr>
                <td style="width:50%; border:none; text-align:right; padding:10px">
                    <b>Motor Block: </b>
                </td>
                <td style="width:50%; border:none; padding:10px">'.
                $z.'
                </td>
            </tr>';
        if ($spb['nsaids4']  == 1){$z = 'Yes';} else {$z = 'No';}
        echo'
            <tr>
                <td style="width:50%; border:none; text-align:right; padding:10px">
                    <b>NSAID Use: </b>
                </td>
                <td style="width:50%; border:none; padding:10px">'.
                $z.'
                </td>
            </tr>';
        if ($spb['acetaminophen4']  == 1){$z = 'Yes';} else {$z = 'No';}
        echo'
            <tr>
                <td style="width:50%; border:none; text-align:right; padding:10px">
                    <b>Acetaminophen Use: </b>
                </td>
                <td style="width:50%; border:none; padding:10px">'.
                $z.'
                </td>
            </tr>';
        if ($spb['narcotics4']  == 1){$z = 'Yes';} else {$z = 'No';}
        echo'
            <tr>
                <td style="width:50%; border:none; text-align:right; padding:10px">
                    <b>Narcotic Use: </b>
                </td>
                <td style="width:50%; border:none; padding:10px">'.
                $z.'
                </td>
            </tr>';
        if ($spb['drainage4']  == 1){$z = 'Yes';} else {$z = 'No';}
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
                    $spb['comments4'].'
                </td>
            </tr>
        </table>
        </td></tr>
        </table>';
        echo'
        <br>
        <table style="width:60%">
            <tr>
                <td align="center">
                <button class="btn" id="ce" onclick="rev4()">REVISE DAY 4</button>
                </td>
            </tr>
        </table>
        ';
    }
    echo'
    <table style="width:100%">
        <tr>
            <td align="center">
            <input type="button" onclick="window.location=\'patientinfo.php\'" value="CONTINUE" class="btn">
            </td>
        </tr>
    </table>
    <br>';
    if ($spb['active'] != 0)
    {
    echo'
    <table style="width:100%">
        <tr>
            <td align="center">
            <input type="button" onclick="window.location=\'patientdeactive.php\'" value="MARK FOLLOW-UP AS COMPLETE, REMOVE PATIENT FROM ACTIVE LIST" class="btn2">
            </td>
        </tr>
    </table>';
    }
    
    if ($spb['active'] == 0)
    {
    echo'
    <table style="width:100%">
        <tr>
            <td align="center">
            <input type="button" onclick="window.location=\'patientreactivate.php\'" value="REACTIVATE PATIENT, PLACE PATIENT BACK INTO ACTIVE LIST" class="btn2">
            </td>
        </tr>
    </table>';
    }
}



//---------------------------------------------------------------------------------------------------------------------------------------------------
//CASE:  IF DAY1, DAY2, AND DAY3 FOLLOW-UP HAS BEEN COMPLETED BUT NOT DAY 4 OR IF DAY 4 REVISION IS NECESSARY 

else if (($spb['painscore1'] > -1 && $_SESSION['revise1'] == 0) && 
         ($spb['painscore2'] > -1 && $_SESSION['revise2'] == 0) &&
         ($spb['painscore3'] > -1 && $_SESSION['revise3'] == 0) &&    
        (($spb['painscore4'] == -1) || ($_SESSION['revise4'] == 1))
   )
{
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
    echo'
    <table style="width:60%">
        <tr>
            <td align="center">
            <button class="btn" id="ce" onclick="rev1()">REVISE DAY 1</button>
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
    echo'
    <table style="width:60%">
        <tr>
            <td align="center">
            <button class="btn" id="ce" onclick="rev2()">REVISE DAY 2</button>
            </td>
        </tr>
    </table>
    <br>
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
    echo'
    <table style="width:60%">
        <tr>
            <td align="center">
            <button class="btn" id="ce" onclick="rev3()">REVISE DAY 3</button>
            </td>
        </tr>
    </table>
    <br>
    ';



    //DAY 4
    echo'
    <h1 class="h1log" style="color:#000000">Followup: Day 4</h1>
    <form action="action_page_day4.php" method="post">';

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
            <select name="pain4">';
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
            <select name="sensoryblock4">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Motor Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="motorblock4">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>NSAID Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="nsaids4">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Acetaminophen Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="acetaminophen4">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Narcotic Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="narcotics4">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Drainage: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="drainage4">
               <option value="0">No</option><option value="1">Yes</option>
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
                <textarea style="width: 90%; height: 10%; margin: 0 auto; display: block;" name="comments4">'.
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
            <input type="submit" name="day4" value="SUBMIT" class="btn">
            </td>
        </tr>
    </table>   
    <br>
    <br>
    <table style="width:100%">
        <tr>
            <td align="center">
            <input type="button" onclick="window.location=\'patientinfo.php\'" value="CONTINUE" class="btn">
            </td>
        </tr>
    </table>
    <br>
    <table style="width:100%">
        <tr>
            <td align="center">
            <input type="button" onclick="window.location=\'patientdeactive.php\'" value="MARK FOLLOW-UP AS COMPLETE, REMOVE PATIENT FROM ACTIVE LIST" class="btn2">
            </td>
        </tr>
    </table>

    </form>

    </div>';
}



//---------------------------------------------------------------------------------------------------------------------------------------------------
//CASE:  IF DAY1 AND DAY2 FOLLOW-UP HAS BEEN COMPLETED BUT NOT DAY 3 OR IF DAY 3 REVISION IS NECESSARY 

else if (($spb['painscore1'] > -1 && $_SESSION['revise1'] == 0) && 
         ($spb['painscore2'] > -1 && $_SESSION['revise2'] == 0) && 
         (($spb['painscore3'] == -1) || ($_SESSION['revise3'] == 1))
        )
{
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
    echo'
    <table style="width:60%">
        <tr>
            <td align="center">
            <button class="btn" id="ce" onclick="rev1()">REVISE DAY 1</button>
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
    echo'
    <table style="width:60%">
        <tr>
            <td align="center">
            <button class="btn" id="ce" onclick="rev2()">REVISE DAY 2</button>
            </td>
        </tr>
    </table>
    ';



    //DAY 3
    echo'
    <h1 class="h1log" style="color:#000000">Followup: Day 3</h1>
    <form action="action_page_day3.php" method="post">';

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
            <select name="pain3">';
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
            <select name="sensoryblock3">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Motor Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="motorblock3">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>NSAID Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="nsaids3">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Acetaminophen Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="acetaminophen3">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Narcotic Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="narcotics3">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Drainage: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="drainage3">
               <option value="0">No</option><option value="1">Yes</option>
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
                <textarea style="width: 90%; height: 10%; margin: 0 auto; display: block;" name="comments3">'.
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
            <input type="submit" name="day3" value="SUBMIT" class="btn">
            </td>
        </tr>
    </table>
    <br>
    <table style="width:100%">
        <tr>
            <td align="center">
            <input type="button" onclick="window.location=\'patientinfo.php\'" value="CONTINUE" class="btn">
            </td>
        </tr>
    </table>
    <br>   
    <br>
    <table style="width:100%">
        <tr>
            <td align="center">
            <input type="button" onclick="window.location=\'patientdeactive.php\'" value="MARK FOLLOW-UP AS COMPLETE, REMOVE PATIENT FROM ACTIVE LIST" class="btn2">
            </td>
        </tr>
    </table>

    </form>

    </div>';
}

////////////////////////////////////////////////////////////////////////////////////
//CASE:  IF DAY1 FOLLOW-UP HAS BEEN COMPLETED BUT NOT DAY 2 OR IF DAY 2 REVISION IS NECESSARY 
else if (
            ($spb['painscore1'] > -1 && $_SESSION['revise1'] == 0) && 
            ($spb['painscore2'] == -1 || $_SESSION['revise2'] == 1)
        )
{
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
    echo'
    <table style="width:60%">
        <tr>
            <td align="center">
            <button class="btn" id="ce" onclick="rev1()">REVISE DAY 1</button>
            </td>
        </tr>
    </table>
    ';
            




    //DAY 2
    echo'
    <h1 class="h1log" style="color:#000000">Followup: Day 2</h1>
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
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Motor Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="motorblock2">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>NSAID Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="nsaids2">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Acetaminophen Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="acetaminophen2">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Narcotic Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="narcotics2">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Drainage: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="drainage2">
               <option value="0">No</option><option value="1">Yes</option>
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
            <input type="submit" name="day2" value="SUBMIT" class="btn">
            </td>
        </tr>
    </table>
    <br>
    <table style="width:100%">
        <tr>
            <td align="center">
            <input type="button" onclick="window.location=\'patientinfo.php\'" value="CONTINUE" class="btn">
            </td>
        </tr>
    </table>
    <br>
    <br>
    <table style="width:100%">
        <tr>
            <td align="center">
            <input type="button" onclick="window.location=\'patientdeactive.php\'" value="MARK FOLLOW-UP AS COMPLETE, REMOVE PATIENT FROM ACTIVE LIST" class="btn2">
            </td>
        </tr>
    </table>

    </form>

    </div>';
}


//---------------------------------------------------------------------------------------------------------------------------------------------------
//CASE:  IF DAY1 FOLLOW-UP HAS NOT BEEN COMPLETED OR IF DAY 1 REVISION IS NECESSARY 

else if ($spb['painscore1'] == -1 || $_SESSION['revise1'] == 1)
{
    //DAY 1
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
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Motor Block: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="motorblock1">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>NSAID Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="nsaids1">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Acetaminophen Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="acetaminophen1">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Narcotic Use: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="narcotics1">
               <option value="0">No</option><option value="1">Yes</option>
            </select>
            </td>
        </tr>
        <tr>
            <td style="width:50%; border:none; text-align:right; padding:10px">
                <b>Drainage: </b>
            </td>
            <td style="width:50%; border:none; padding:10px">
            <select name="drainage1">
               <option value="0">No</option><option value="1">Yes</option>
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
    <br>
    <table style="width:100%">
        <tr>
            <td align="center">
            <input type="button" onclick="window.location=\'patientinfo.php\'" value="CONTINUE" class="btn">
            </td>
        </tr>
    </table>
    <br>

    </form>

    </div>';
}
echo'
</body>
</html>';
$_SESSION['revise1'] = false;
$_SESSION['revise2'] = false;
$_SESSION['revise3'] = false;
$_SESSION['revise4'] = false;
}
?>


<?php
//////////////////////////////////////////////////////////////////////////////////////////////////
//PATIENT INTERFACE                                                                             //
//VERSION 01_01                                                                                 //
//LAST REVISED 20180811                                                                         //
//Gives list of active patients to a physician user                                             //
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
    if (isset($_POST['pord']))
    {
        $_SESSION['ptorder']=$_POST['pord'];
    }
    else
    {
        $_SESSION['ptorder'] = "a.id";
    }
   
    $_SESSION['revise1'] = false;  $_SESSION['revise2'] = false;
    $_SESSION['loginstring']='includes/connect.php';
    require_once ($_SESSION['loginstring']);
    
    $winwidth = $_SESSION['w'];   
  
echo'
<!DOCTYPE html>
<html>
<head>
<title>Active Patient List</title>
<link rel="stylesheet" href="styles/stylew3.css" type="text/css">
</head>
<body>

<div class="row" style="background-color:#7db4dc; width:95%; padding:10px; margin-right:auto; margin-left:auto;">';
if ($winwidth > 925)
{
  echo
  '<center><img src="includes/ProvidenceSmall.png" alt="PAA" height='.($winwidth*0.2369*.5*.7).'; width='.($winwidth*.5*.7).';" /></center>'.
  '<h1 style="text-align:center;">Active Patient List</h1>';
}
else
{
  echo
  '<center><img src="includes/ProvidenceSmall.png" alt="PAA" width=50%;" /></center>'.
  '<h3 style="text-align:center;">Block Patient Registration</h3>';
}

echo'
</div>
<br>
<div class="topnav" style="width:95%; margin-right:auto; margin-left:auto">
  <a href="registration.php">Patient Registration</a>
  <a href="patientinfo.php">Active Patient List</a>
  <a href="comPtList.php">Complete Patient List</a>
  <a href="statistics.php">Statistics</a>
  <a href="logout.php">Logout</a>
</div>
<br>';

$sp = "SELECT a.id, a.fname, a.lname, a.phone, b.location, c.surgeonFirst, c.surgeonLast, d.first, d.last, ".
      "       e.cptDescriptor, e.asaCode, a.monthnumber, a.daynumber ".
      "FROM patients AS a ".
      "INNER JOIN locations AS b ON a.orlocID=b.id ".
      "INNER JOIN surgeons AS c ON a.surgeonID=c.surgeonID ".
      "INNER JOIN users AS d ON a.anesthesiologistID=d.id ".
      "INNER JOIN asa AS e ON a.cptID=e.id ".
      "WHERE a.active = true ".
      "ORDER BY ".$_SESSION['ptorder'];
           
$spa = mysqli_query($dbc, $sp);

echo'
    <div id="comPtList" class="w3-container reg">
    <table id="patients" style="border: 1px solid black; width:95%; margin-left:auto; margin-right:auto;">
    <thead>
        <th style="border: 1px solid black;">ID</th><th style="border: 1px solid black;">Patient</th>
        <th style="border: 1px solid black;">Phone</th><th style="border: 1px solid black;">Location</th>
        <th style="border: 1px solid black;">Surgeon</th><th style="border: 1px solid black;">Anesthesiologist</th>
        <th style="border: 1px solid black;">ASA Code - Description</th><th style="border: 1px solid black;">Date</th>
    </thead>
    <tbody>';

while ($spb = mysqli_fetch_array($spa))
{
    echo'
    <tr onclick="window.location.href=\'specificpatient.php?p='.$spb['id'].'\'">
        <td style="text-align:center;">'.$spb['id'].'</td>
        <td style="text-align:center;">'.strtoupper($spb['fname']).' '.strtoupper($spb['lname']).'</td>
        <td style="text-align:center;">'.$spb['phone'].'</td> 
        <td style="text-align:center;">'.$spb['location'].'</td>
        <td style="text-align:center;">'.strtoupper($spb['surgeonFirst']).' '.strtoupper($spb['surgeonLast']).'</td>
        <td style="text-align:center;">'.strtoupper($spb['first']).' '.strtoupper($spb['last']).'</td>
        <td style="text-align:center;">'.$spb['asaCode'].' - '.$spb['cptDescriptor'].'</td>
        <td style="text-align:center;">'.$spb['monthnumber'].'/'.$spb['daynumber'].'</td>    
    </tr>';
}
  
echo '</tbody>
      </table>
      </div>';

echo '<br><br> '.
     '<form action="patientinfo.php" method="post">';


    if ($_SESSION['w'] > 925)
    {
        echo'
            <table style="border-style:solid; width:50%; margin-left:auto; margin-right:auto;">';
    }
    else
    {
        echo'
            <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">';
    }
    echo'
    <tr>
        <td style="width:50%; border:none; text-align:right; padding:10px;">
            <b>Order Patients By:</b>
        </td>        
        <td style="border:none; width:50%; padding:10px">
        <select name="pord">
          <option value="d.Last">Anesthestheiologist</option>
          <option value="c.surgeonLast">Surgeon</option>
          <option value="b.location">Location</option>
          <option value="a.lname">Patient Name</option>
          <option value="a.id" selected>Patient ID</option>
        </select>
        </td>
    </tr>
    </table>
    <br><br>
    <table style="width:100%">
        <tr>
            <td align="center">
            <input type="submit" name="PtDemo" value="SUBMIT" class="btn">
            </td>
        </tr>
    </table>
    </form>
    ';
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



    function doOnOrientationChange()
    {
        window.location("resetwidth.php");
    }
    window.addEventListener('orientationchange', doOnOrientationChange);

    
    function movetoNext(current, nextFieldID) 
    { 
        if (current.value.length >= current.maxLength) 
        {  
            document.getElementById(nextFieldID).focus();  
        }  
    }  
</script>

<?php
echo'
</body>
</html>'; 
}
?>


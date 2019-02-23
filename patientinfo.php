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
    $_SESSION['revise1'] = false;  $_SESSION['revise2'] = false;
    $_SESSION['loginstring']='includes/connect.php';
    require_once ($_SESSION['loginstring']);

    $winwidth = $_SESSION['w'];   
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
  <div class="w3-padding w3-center"><h1>Active Patient List</h1></div>
</div>

<div class="w3-sidebar w3-bar-block w3-light-grey w3-card" style="width:130px">
  <h5 class="w3-bar-item"><b>Menu</b></h5>
  <button class="w3-bar-item w3-button tablink" onclick="window.location.href=\'registration.php\'">Patient Registration</button>
  <button class="w3-bar-item w3-button tablink" onclick="openInfo(event, \'PtList\')" id="defaultOpen">Active Patient List</button>
  <button class="w3-bar-item w3-button tablink" onclick="window.location.href=\'comPtList.php\'">Complete Patient List</button>
  <button class="w3-bar-item w3-button tablink" onclick="window.location.href=\'statistics.php\'">Statistics</button>
  <button class="w3-bar-item w3-button tablink" onclick="window.location.href=\'logout.php\'">Logout</button>
</div>

<div style="margin-left:130px"> 
<br><br>';

$sp = "SELECT a.id, a.fname, a.lname, a.phone, b.location, c.surgeonFirst, c.surgeonLast, d.first, d.last, ".
      "       e.cptDescriptor, e.asaCode, a.monthnumber, a.daynumber ".
      "FROM patients AS a ".
      "INNER JOIN locations AS b ON a.orlocID=b.id ".
      "INNER JOIN surgeons AS c ON a.surgeonID=c.surgeonID ".
      "INNER JOIN users AS d ON a.anesthesiologistID=d.id ".
      "INNER JOIN asa AS e ON a.cptID=e.id ".
      "WHERE a.active = true";
            
$spa = mysqli_query($dbc, $sp);

echo'
<div id="PtList" class="w3-container reg" style="display:none">
<table style="border: 1px solid" id="patients">
    <thead>
        <th>ID</th><th>Patient</th><th>Phone</th><th>Location</th><th>Surgeon</th><th>Anesthesiologist</th><th>ASA Code - Description</th><th>Date</th>
    </thead>
    <tbody>';
while ($spb = mysqli_fetch_array($spa))
{
    echo'
    <tr onclick="window.location.href=\'specificpatient.php?p='.$spb['id'].'\'">
        <td>'.$spb['id'].'</td>
        <td>'.strtoupper($spb['fname']).' '.strtoupper($spb['lname']).'</td>
        <td>'.$spb['phone'].'</td> 
        <td>'.$spb['location'].'</td>
        <td>'.strtoupper($spb['surgeonFirst']).' '.strtoupper($spb['surgeonLast']).'</td>
        <td>'.strtoupper($spb['first']).' '.strtoupper($spb['last']).'</td>
        <td>'.$spb['asaCode'].' - '.$spb['cptDescriptor'].'</td>
        <td>'.$spb['monthnumber'].'/'.$spb['daynumber'].'</td>    
    </tr>';
}
  
echo '</tbody>
      </table>
      </div>';
?>
   
<script>
    window.addEventListener("resize", resetH);
    function resetH() 
    {       
        window.location.assign("resetWidth2.php");
    }                
</script>

   
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


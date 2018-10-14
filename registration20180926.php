<?php
//////////////////////////////////////////////////////////////////////////////////////////////////
//PATIENT INTERFACE                                                                             //
//VERSION 01_01                                                                                 //
//LAST REVISED 20180811                                                                         //
//////////////////////////////////////////////////////////////////////////////////////////////////

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
   
   $winwidth = $_SESSION['w'];
   
   if (isset($_SESSION['fname']))
       unset($_SESSION['fname']);
   if (isset($_SESSION['lname']))
       unset($_SESSION['lname']);
   if (isset($_SESSION['phone']))
       unset($_SESSION['phone']);
   if (isset($_SESSION['email']))
       unset($_SESSION['email']);
   if (isset($_SESSION['orloc']))
       unset($_SESSION['orloc']);
   if (isset($_SESSION['orlocID']))
       unset($_SESSION['orlocID']);
   if (isset($_SESSION['anesthesiologist']))
       unset($_SESSION['anesthesiologist']);
   if (isset($_SESSION['anesthesiologistID']))
       unset($_SESSION['anesthesiologistID']);  
   if (isset($_SESSION['surgeon']))
       unset($_SESSION['surgeon']);
   if (isset($_SESSION['surgeonID']))
       unset($_SESSION['surgeonID']);
   if (isset($_SESSION['cpt']))
       unset($_SESSION['cpt']);
   if (isset($_SESSION['cptID']))
       unset($_SESSION['cptID']);
   if (isset($_SESSION['block1']))
       unset($_SESSION['block1']);
   if (isset($_SESSION['block1ID']))
       unset($_SESSION['block1ID']);
   if (isset($_SESSION['drug1']))
       unset($_SESSION['drug1']);
   if (isset($_SESSION['drug1ID']))
       unset($_SESSION['drug1ID']);
   if (isset($_SESSION['addi1']))
       unset($_SESSION['addi1']);  
   if (isset($_SESSION['block2']))
       unset($_SESSION['block2']);
   if (isset($_SESSION['block2ID']))
       unset($_SESSION['block2ID']);
   if (isset($_SESSION['drug2']))
       unset($_SESSION['drug2']);
   if (isset($_SESSION['drug2ID']))
       unset($_SESSION['drug2ID']);
   if (isset($_SESSION['addi2']))
       unset($_SESSION['addi2']);
   
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
        * {
            box-sizing: border-box;
        }

        body {
          margin: 0;
        }

        /* Style the header */
        .header {
            background-color: #7db4dc;
            padding: 20px;
            text-align: center;
            font-family:"Segoe UI",Arial,sans-serif;
            font-size:36px;
            margin:10px;
        }

        /* Style the top navigation bar */
        .topnav {
            overflow: hidden;
            background-color: #DDDDDD;
            font-family:"Segoe UI",Arial,sans-serif;
            font-size:20px;
            margin:10px;
        }

        /* Style the topnav links */
        .topnav a {
            float: left;
            display: block;
            color: #000000;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        /* Change color on hover */
        .topnav a:hover {
            background-color: #7db4dc;
            color: black;
        }

        .column {
            float: left;
            width: 100%;
            padding: 14px 16px;
            font-family:"Segoe UI",Arial,sans-serif;
        }

        .columnt {
            float: left;
            width: 50%;
            padding: 14px 16px;
        }
        .columntr {
            text-align: center;
            padding: 3% 0;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
        /*@media screen and (max-width:600px) {
            .column {
                width: 95%;
            }*/
        }
    </style>
</head>


<body>

<div class="header">
    <div class = "row">
        <div class = "columnt">
            <center><img src="includes/ProvidenceSmall.png" alt="PAA" height=\'15%\';" /></center>
        </div>
        <div class = "columntr">
            <center>Block Patient Registration</center>
        </div>
    </div>
</div>

<div class="row">

<div class="column" style="width:10%">
  <h5 class="w3-bar-item"><b>Menu</b></h5>
  <button class="w3-bar-item w3-button tablink" onclick="openInfo(event, \'PtReg\')" id="defaultOpen">Patient Registration</button>
  <button class="w3-bar-item w3-button tablink" onclick="window.location.href=\'patientinfo.php\'">Active Patient List</button>
  <button class="w3-bar-item w3-button tablink" onclick="window.location.href=\'comPtList.php\'">Complete Patient List</button>
  <button class="w3-bar-item w3-button tablink" onclick="window.location.href=\'statistics.php\'">Statistics</button>
  <button class="w3-bar-item w3-button tablink" onclick="window.location.href=\'logout.php\'">Logout</button>
</div>

<div class="column" style="margin-left:10%"> 
<br><br>

<div id="PtReg" class="column" style="width:90%">
<form action="action_page0.php" method="post">'; 
    
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
            <td style="width:40%; border:none; text-align:right; padding:10px; font-size:24px">
            <b>First Name:</b>
            <td style="width:60%; padding:10px;">
                <input id="fir" type="text" name="ptfirst" style="font-size:24px;">
            </td>
        </tr>
        <tr>
            <td style="width:40%; border:none; text-align:right; padding:10px; font-size:24px">
            <b>Last Name:</b>
            </td>
            <td style="width:60%; padding:10px;">
                <input type="text" name="ptlast" style="font-size:24px;">
            </td>
        </tr>
        <tr>
            <td style="width:40%; border:none; text-align:right; padding:10px; font-size:24px"">
            <b>Phone Number:</b>
            </td>
            <td style="width:60%; padding:10px;">
                <input type="text" name="phoneac" maxlength="3" size="3" onkeyup="movetoNext(this, \'phonepre\')" style="font-size:24px;">.
                <input type="text" name="phonepre" id="phonepre" maxlength="3" size="3" onkeyup="movetoNext(this, \'phonepost\')"style="font-size:24px;">.
                <input type="text" name="phonepost" id="phonepost" maxlength="4" size="4" style="font-size:24px;">
            </td>
        </tr>
        <tr>
            <td style="width:40%; border:none; text-align:right; padding:10px; font-size:24px">
            <b>Email Address:</b>
            </td>
            <td style="width:60%; padding:10px;">
                <input type="text" name="email" style="font-size:24px;">
            </td>
        </tr>
    </table><br><br>';
    
    $locQ = "SELECT * FROM locations ORDER BY location";
    $locA = mysqli_query($dbc, $locQ);


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
                    <td style="width:40%; text-align:right; padding:10px">
                    <b>OR Location:</b>
                    </td>
                    <td style="width:60%; border:none; align:center; padding:10px">                    
                    <select name="location">';
    
   while ($locE = mysqli_fetch_array($locA))
   {
       echo '<option value='.$locE['id'].'>'.$locE['location'].'</option>';
   }
    
   echo'
                    </select>
                    </td>
                 </tr>
                 <tr>';
   $anesQ = "SELECT * FROM users WHERE physician=1 ORDER BY last";
   $anesA = mysqli_query($dbc, $anesQ);
   
   echo'
            <td style="width:40%; border:none; text-align:right; padding:10px;">
                <b>Block Anesthesiologist:</b>
            </td>
            
            <td style="border:none; width:60%; padding:10px">
            <select name="anes">';
   while ($anesE = mysqli_fetch_array($anesA))
   {
           echo '<option value='.$anesE['id'].'>'.strtoupper($anesE['last']).', '.strtoupper($anesE['first']).'</option>';
   }
   echo'
            </select>
            </td>
        </tr>
        </tr>';
   
   $surgeonQ = "SELECT * FROM surgeons";
   $surgeonA = mysqli_query($dbc, $surgeonQ);
   
   $cptQ = "SELECT id, asaCode, SUBSTRING(cptDescriptor, 1, 50) FROM asa";
   $cptA = mysqli_query($dbc, $cptQ);

   
   echo'
            <td style="width:40%; border:none; text-align:right">
                <b>Surgeon:</b>
            </td>
            
            <td style="border:none; width:60%; padding:10px">
            <select name="surgeon">';
   
   while ($surgeonE = mysqli_fetch_array($surgeonA))
   {
       if ($surgeonE['surgeonFirst']==$surgeonBF && $surgeonE['surgeonLast']==$surgeonBL)
           continue;
       else
       {
           echo '<option value='.$surgeonE['surgeonID'].'>'.strtoupper($surgeonE['surgeonLast']).', '.strtoupper($surgeonE['surgeonFirst']).'</option>';
           $surgeonBF = $surgeonE['surgeonFirst'];
           $surgeonBL = $surgeonE['surgeonLast'];
       }
   }
   echo'
            </select>
            </td>
         </tr>
         <tr>            
            <td style="width:40%; border:none; text-align:right">
                <b>CPT:</b>
            </td>
            
            <td style="border:none; width:60%; padding:10px">
            <select name="cpt">';
   while ($cptE = mysqli_fetch_array($cptA))
   {
       echo '<option value='.$cptE['id'].'>'.$cptE['asaCode'].' - '.$cptE[2].'</option>';
   }
   echo'
            </select>
            </td>
        </tr>
       </table>
       <br>

      <center>
      <h1 class="h1log" style="text-align:left color:#000000">Primary Block</h1>';
   
      
   $block1Q = "SELECT * FROM blocks ORDER BY block";
   $block1A = mysqli_query($dbc, $block1Q);
   
   $drug1Q = "SELECT * FROM drug ORDER BY med";
   $drug1A = mysqli_query($dbc, $drug1Q);
   
   
   echo'
       <table style="border-style:solid; width:60%; margin-right:auto; margin-left:auto;">
        <tr>
            <td style="width:16%; border:none; text-align:right; padding:10px">
                <b>Type of Block:</b>
            </td>
            


            <td style="border:none; width:16%; padding:10px">
            <select name="block1">';
   while ($block1E = mysqli_fetch_array($block1A))
   {
           echo '<option value='.$block1E['id'].'>'.$block1E['block'].'</option>';
   }
   echo'
            </select>
            </td>
            

            <td style="width:16%; border:none; text-align:right; padding:10px;">
                <b>Local:</b>
            </td>
            
            <td style="border:none; width:16%; padding:10px">
            <select name="drug1">';
   while ($drug1E = mysqli_fetch_array($drug1A))
   {
           echo '<option value='.$drug1E['id'].'>'.$drug1E['med'].'</option>';
   }
   echo'
            </select>
            </td>
            
            <td style="width:16%; border:none; text-align:right; padding:10px">
                <b>Volume (ml):</b>
            </td>
            
            <td style="width:16%; padding:10px">
                <input type="text" name="volume" maxlength="3" size="3" value="0">
            </td>
       </tr>
       </table>';
   
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
                    <td style="border: none; width:8%;">
                    <b>Additives:</b>
                    </td>
                    <td style="border: 1px solid black; width:23%; text-align:center;">
                    <label for="epi200">Epinephrine 1:200,000 </label>
                    <input type="checkbox" id="epi200" name="addi1[]" value="epi200" />                    
                    </td>
                    <td style="border: 1px solid black; width:23%; text-align:center">
                    <label for="epi100">Epinephrine 1:100,000</label>
                    <input type="checkbox" id="epi100" name="addi1[]" value="epi100" />
                    </td>
                </tr>
                <tr>
                    <td style="border:none; width:8%;">
                    </td>
                    <td style="border: 1px solid black; width:23%; text-align:center"> 
                    <label for="clonidine">Clonidine</label>
                    <input type="checkbox" id="clonidine" name="addi1[]" value="clonidine"/>       
                    </td>
                    <td style="border: 1px solid black; width:23%; text-align:center">
                    <label for="dex">Dexmedetomidine</label>
                    <input type="checkbox" id="dex" name="addi1[]" value="dex" />        
                    </td>   
                </tr>
                <tr>
                    <td style="border:none; width:8%;">
                    </td>
                    <td style="border: 1px solid black; width:23%; text-align:center"> 
                    <label for="decadron">Decadron</label>
                    <input type="checkbox" id="decadron" name="addi1[]" value="decadron"/>       
                    </td> 
                </tr>
      </table>
    <br>
     
    <center>
    <h1 class="h1log" style="text-align:left color:#000000">Secondary Block</h1>';
   
   
    $block2Q = "SELECT * FROM blocks ORDER BY block";

    $block2A = mysqli_query($dbc, $block2Q);

    $drug2Q = "SELECT * FROM drug ORDER BY med";
    $drug2A = mysqli_query($dbc, $drug2Q);
   
   
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
                <td style="width:16%; border:none; text-align:right; padding:10px">
                    <b>Type of Block:</b>
                </td>



                <td style="border:none; width:16%; padding:10px">
                <select name="block2">
                <option value=0>None</option>';
    while ($block2E = mysqli_fetch_array($block2A))
    {
           echo '<option value='.$block2E['id'].'>'.$block2E['block'].'</option>';
    }
    echo'
                </select>
                </td>


                <td style="width:16%; border:none; text-align:right; padding:10px">
                    <b>Local:</b>
                </td>

                <td style="border:none; width:16%; padding:10px">
                <select name="drug2">
                <option value=0>None</option>';
    while ($drug2E = mysqli_fetch_array($drug2A))
    {
           echo '<option value='.$drug2E['id'].'>'.$drug2E['med'].'</option>';
    }
    echo'
                </select>
                </td>

                <td style="width:16%; border:none; text-align:right; padding:10px">
                    <b>Volume (ml):</b>
                </td>

                <td style="width:16%; padding:10px">
                    <input type="text" name="volume2" maxlength="3" size="3" value="0">
                </td>
            </tr>
        </table>
        <table style="border-style:solid; width:60%; margin-right:auto; margin-left:auto;">
            <tr>
                <td style="border:none; width:8%;">
                <b>Additives:</b>
                </td>
                <td style="border: 1px solid black; width:23%; text-align:center">
                <label for="epi200">Epinephrine 1:200,000 </label>
                <input type="checkbox" id="epi2002" name="addi2[]" value="epi200" />                    
                </td>
                <td style="border: 1px solid black; width:23%; text-align:center">
                <label for="epi100">Epinephrine 1:100,000</label>
                <input type="checkbox" id="epi1002" name="addi2[]" value="epi100" />
                </td>
            </tr>
            <tr>
            <td style="border:none; width:8%;">
                </td>
                <td style="border: 1px solid black; width:23%; text-align:center"> 
                <label for="clonidine">Clonidine</label>
                <input type="checkbox" id="clonidine2" name="addi2[]" value="clonidine"/>       
                </td>
                <td style="border: 1px solid black; width:23%; text-align:center">
                <label for="dex">Dexmedetomidine</label>
                <input type="checkbox" id="dex2" name="addi2[]" value="dex" />        
                </td>   
            </tr>
            <tr>
                <td style="border:none; width:8%;">
                </td>
                <td style="border: 1px solid black; width:23%; text-align:center"> 
                <label for="decadron">Decadron</label>
                <input type="checkbox" id="decadron2" name="addi2[]" value="decadron"/>       
                </td> 
            </tr>
        </table>
        <br>

        <h1>Enter Date and Hour Block(s) was(were) placed</h1>
        <br>
        <table style="width:35%; border-style:solid;">
            <tr>
                <td style="width:33%; border:none; text-align:center"><b>Month</b></td><td style="width:33%; border:none; text-align:center">
                <b>Day</b></td><td style="width:33%; border:none; text-align:center"><b>Hour</b></td>
            </tr>


            <tr>
                <td style="width:33%; border:none; text-align:center">

                <select name="month" id="month" onchange="click2()">';
                if ($datetime->format('n')=="1")
                {
                    echo '<option selected value="1">January</option>';
                }
                else 
                {
                    echo '<option value="1">January</option>';
                }
                if ($datetime->format('n')=="2")
                {
                    echo '<option selected value="2">February</option>';
                }
                else 
                {
                    echo '<option value="2">February</option>';
                } 
                if ($datetime->format('n')=="3")
                {
                    echo '<option selected value="3">March</option>';
                }
                else 
                {
                    echo '<option value="3">March</option>';
                }
                if ($datetime->format('n')=="4")
                {
                    echo '<option selected value="4">April</option>';
                }
                else 
                {
                    echo '<option value="4">April</option>';
                }
                if ($datetime->format('n')=="5")
                {
                    echo '<option selected value="5">May</option>';
                }
                else 
                {
                    echo '<option value="5">May</option>';
                }
                if ($datetime->format('n')=="6")
                {
                    echo '<option selected value="6">June</option>';
                }
                else 
                {
                    echo '<option value="6">June</option>';
                }
                if ($datetime->format('n')=="7")
                {
                    echo '<option selected value="7">July</option>';
                }
                else 
                {
                    echo '<option value="7">July</option>';
                }
                if ($datetime->format('n')=="8")
                {
                    echo '<option selected value="8">August</option>';
                }
                else 
                {
                    echo '<option value="8">August</option>';
                }
                if ($datetime->format('n')=="9")
                {
                    echo '<option selected value="9">September</option>';
                }
                else 
                {
                    echo '<option value="9">September</option>';
                }
                if ($datetime->format('n')=="10")
                {
                    echo '<option selected value="10">October</option>';
                }
                else 
                {
                    echo '<option value="10">October</option>';
                }
                if ($datetime->format('n')=="11")
                {
                    echo '<option selected value="11">November</option>';
                }
                else 
                {
                    echo '<option value="11">November</option>';
                }
                if ($datetime->format('n')=="12")
                {
                    echo '<option selected value="12">December</option>';
                }
                else 
                {
                    echo '<option value="12">December</option>';
                }
    echo'                                               
                </select>';

    ?>

    <script type="text/javascript">

    document.write("</td><td style=\"width:33%; border:none; text-align:center\"><select name=\"day\" id=\"day\"");
    var mnth = document.getElementById("month").value;
    //alert(mnth);
    var today = new Date();
    //alert(today);
    var yyyy = today.getFullYear();
    //alert(yyyy);
    var dim = new Date(yyyy, mnth, 0).getDate();
    //alert(new Date(yyyy, mnth, 0).getDate());

    var st;
    var today = new Date();
    var dy = today.getDate();

    for (var x=1; x<=dim; x++)
    {
        if (x===dy)
        {
            st = "<option selected value="; 
            st = st.concat(x,">");
            st = st.concat(x,"</option>");
        }
        else
        {
            st = "<option value=";
            st = st.concat(x,">");
            st = st.concat(x,"</option>");
        }
        document.write(st);
        st='';
    }

    function click2(){
        var mnth = document.getElementById("month").value;
        //alert(mnth);
        var today = new Date();
        //alert(today);
        var yyyy = today.getFullYear();
        //alert(yyyy);
        var dim = new Date(yyyy, mnth, 0).getDate();
        //alert(new Date(yyyy, mnth, 0).getDate());
        
        var st = "";
        var today = new Date();
        var dy = today.getDate();

        for (var x=1; x<=dim; x++)
        {
            if (x===dy)
            {
                st = st.concat("<option selected value="); 
                st = st.concat(x,">");
                st = st.concat(x,"</option>");
            }
            else
            {
                st = st.concat("<option value=");
                st = st.concat(x,">");
                st = st.concat(x,"</option>");
            }
        }
        document.getElementById("day").innerHTML = st;
        st='';
   }
   

    window.addEventListener("resize", resetH);
    function resetH() 
    {       
        window.location.assign("resetWidth2.php");
    }                
    </script>

                
<?php

        echo'
            </select>
            </td>
            <td style="width:33%; border:none; text-align:center">
            <select name="hour">';


        for ($x=0; $x<=23; $x++)
        {
            if ($x == $datetime->format('G'))
            {
                $datetime2->setTime($x,00);
                echo'<option selected value='.$x.'>'.date_format($datetime2,"g A").'</option>';
            }
            else 
            {
                $datetime2->setTime($x,00);
                echo'<option value='.$x.'>'.date_format($datetime2,"g A").'</option>';
            }
        }

echo'
            </select>
            </td>
        </tr>
    </table>
    <br>

    <br><br>
    <table style="width:100%">
        <tr>
            <td align="center">
            <input type="submit" name="PtDemo" value="SUBMIT" class="btn">
            </td>
        </tr>
    </table>
    </form>
    </div>
    </div>
    </div>';
/*
</div>
    <div id="PtList" class="w3-container reg" style="display:none">
    </div>
    <div id="Stats" class="w3-container reg" style="display:none">
    </div>';
 * 
 */
?>

   
<script>
function openInfo(evt, cityName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("reg");
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < x.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" w3-pacolor", ""); 
  }
  document.getElementById(cityName).style.display = "block";
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
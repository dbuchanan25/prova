<?php
//////////////////////////////////////////////////////////////////////////////////////////////////
//PATIENT INTERFACE                                                                             //
//VERSION 01_03                                                                                 //
//LAST REVISED 20190225                                                                         //
//ALLOWS REVISON OF REGISTRATION INFORMATION WITHOUT LOSING PREVIOUSLY INPUTTED DATA            //
//It forwards information to the page "action_page0.php"                                        //
//////////////////////////////////////////////////////////////////////////////////////////////////

session_start();

echo '<link rel="manifest" href="/manifest.json">';
echo '<meta name="apple-mobile-web-app-capable" content="yes">';
echo '<meta name="apple-mobile-web-app-status-bar-style" content="default">';
echo '<link rel="apple-touch-icon" href="fi192.png">';

$datetime = new DateTime("now", new DateTimeZone('US/Eastern'));
$datetime2 = new DateTime("now", new DateTimeZone('US/Eastern'));


if (!isset($_SESSION['username']))
{
  error_log("Username Not Set.");
   require_once ('includes/login_functions.inc.php');
   $url = absolute_url();
   header("Location: $url");
   exit();
}
else
{
   $_SESSION['loginstring']='includes/connect.php';
   require_once ($_SESSION['loginstring']);
   
   if (isset($_GET["w"]) && !isset($_SESSION['w']))
   {
      $_SESSION['w'] = $_GET["w"];
   }  
   else if (!isset($_SESSION['w']))
   {
       echo '<body>';
       echo' <table id="dale" style="width:100%;"></table>';
       echo '</body>';
       ?>
        <script type="text/javascript">
        var elmnt = document.getElementById("dale");

        var txt1 = elmnt.clientWidth; 
        var txt2 = window.innerWidth;
        var txt3 = window.screen.width;

        var txt = Math.min(txt1, txt2, txt3);

        var loc = window.location.href;
        
        window.location = loc + "?w=" + txt + "&h=" + window.screen.height;  
        
        
        function doOnOrientationChange()
        {
            window.location("resetwidth.php");
        }
        window.addEventListener('orientationchange', doOnOrientationChange);
        </script>
        <?php 
   }
   
   $winwidth = $_SESSION['w'];
   
?>



<script type="text/javascript">
    
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
<title>Registration</title>
<link rel="stylesheet" href="styles/style2.css" type="text/css">
</head>
<body>

<div class="row" style="background-color:#7db4dc; width:95%; padding:10px; margin-right:auto; margin-left:auto;">';

if ($winwidth > 925)
{
  echo
  '<center><img src="includes/ProvidenceSmall.png" alt="PAA" height='.($winwidth*0.2369*.5*.7).'; width='.($winwidth*.5*.7).';" /></center>'.
  '<h1 style="text-align:center;">Block Patient Registration</h1>';
}
else
{
  echo
  '<center><img src="includes/ProvidenceSmall.png" alt="PAA" width=50%;" /></center>'.
  '<h3 style="text-align:center;">Block Patient Registration</h3>';
}

echo'
  
</div>';

echo'
<div class="topnav" style="width:95%; margin-right:auto; margin-left:auto">
  <a href="registration.php">Patient Registration</a>
  <a href="patientinfo.php">Active Patient List</a>
  <a href="comPtList.php">Complete Patient List</a>
  <a href="statistics.php">Statistics</a>
  <a href="logout.php">Logout</a>
</div>';

echo'
<br><br>'.
'<form action="action_page0.php" method="post">'; 
 
    
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
            <td style="width:60%; padding:10px;">';
    if (isset($_SESSION['fname']))
    {
        echo'
        <input id="fir" type="text" name="ptfirst" value="'.$_SESSION['fname'].'" style="font-size:24px;">';
    }
    else
    {
        echo'
        <input id="fir" type="text" name="ptfirst" style="font-size:24px;">';
    }
    echo
    '
            </td>
        </tr>
        <tr>
            <td style="width:40%; border:none; text-align:right; padding:10px; font-size:24px">
            <b>Last Name:</b>
            </td>
            <td style="width:60%; padding:10px;">';
            if (isset($_SESSION['lname']))
            {
                echo'
                <input id="las" type="text" name="ptlast" value="'.$_SESSION['lname'].'" style="font-size:24px;">';
            }
            else
            {
                echo'
                <input id="las" type="text" name="ptlast" style="font-size:24px;">';
            }
        echo
        '
            </td>
        </tr>
        <tr>
            <td style="width:40%; border:none; text-align:right; padding:10px; font-size:24px"">
            <b>Phone Number:</b>
            </td>';
        if (isset($_SESSION['phone']))
        {
            echo'
            <td style="width:60%; padding:10px;">
                <input type="text" name="phoneac" maxlength="3" size="3" value='.substr($_SESSION['phone'],1,3).' style="font-size:24px;">.
                <input type="text" name="phonepre" id="phonepre" maxlength="3" size="3" value='.substr($_SESSION['phone'],6,3).' style="font-size:24px;">.
                <input type="text" name="phonepost" id="phonepost" maxlength="4" size="4" value='.substr($_SESSION['phone'],10,4).' style="font-size:24px;">
            </td>';
        }
        else
        {
            echo'
            <td style="width:60%; padding:10px;">
                <input type="text" name="phoneac" maxlength="3" size="3" onkeyup="movetoNext(this, \'phonepre\')" style="font-size:24px;">.
                <input type="text" name="phonepre" id="phonepre" maxlength="3" size="3" onkeyup="movetoNext(this, \'phonepost\')"style="font-size:24px;">.
                <input type="text" name="phonepost" id="phonepost" maxlength="4" onkeyup="movetoNext(this, \'location\')" size="4" style="font-size:24px;">
            </td>';
        }
        echo'
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
                    <td style="width:40%; text-align:right; padding:10px; font-size:24px;">
                    <b>OR Location:</b>
                    </td>
                    <td style="width:60%; border:none; align:center; padding:10px; font-size:24px;">                    
                    <select name="location" id="location">';
    
    if (isset($_SESSION['orlocID']))
    {
       while ($locE = mysqli_fetch_array($locA))
       {
            if ($_SESSION['orlocID'] == $locE['id'])
            {
                echo '<option value='.$locE['id'].' selected>'.$locE['location'].'</option>';
            }
            else
            {
                echo '<option value='.$locE['id'].'>'.$locE['location'].'</option>';
            }            
       }
    }
    else
    {    
        while ($locE = mysqli_fetch_array($locA))
        {
           echo '<option value='.$locE['id'].'>'.$locE['location'].'</option>';
        }
    }    
    echo'
                    </select>
                    </td>
                 </tr>
                 <tr>';
    $anesQ = "SELECT * FROM users WHERE access=1 ORDER BY last";
    $anesA = mysqli_query($dbc, $anesQ);

    echo'
            <td style="width:40%; border:none; text-align:right; padding:10px; font-size:24px;">
                <b>Block Anesthesiologist:</b>
            </td>

            <td style="border:none; width:60%; padding:10px; font-size:24px;">
            <select name="anes">';
   
   
    if (isset($_SESSION['anesthesiologistID']))
    {
        while ($anesE = mysqli_fetch_array($anesA))
        {
            if ($_SESSION['anesthesiologistID'] == $anesE['id'])
            {
                echo '<option value='.$anesE['id'].' selected>'.strtoupper($anesE['last']).', '.strtoupper($anesE['first']).'</option>';
            }
            else
            {
                echo '<option value='.$anesE['id'].'>'.strtoupper($anesE['last']).', '.strtoupper($anesE['first']).'</option>';
            }
        }
    }
    else
    {
       while ($anesE = mysqli_fetch_array($anesA))
       {
               echo '<option value='.$anesE['id'].'>'.strtoupper($anesE['last']).', '.strtoupper($anesE['first']).'</option>';
       }
    }
   
   
    echo'
            </select>
            </td>
        </tr>
        <tr>';

    $surgeonQ = "SELECT * FROM surgeons";
    $surgeonA = mysqli_query($dbc, $surgeonQ);

    $cptQ = "SELECT id, asaCode, SUBSTRING(cptDescriptor, 1, 50) FROM asa";
    $cptA = mysqli_query($dbc, $cptQ);


    echo'
            <td style="width:40%; border:none; text-align:right; font-size:24px;">
                <b>Surgeon:</b>
            </td>

            <td style="border:none; width:60%; padding:10px; font-size:24px;">
            <select name="surgeon">';


    $surgeonBF="";
    $surgeonBL="";
   
    if (isset($_SESSION['surgeonID']))
    {
        while ($surgeonE = mysqli_fetch_array($surgeonA))
        {
            if ($surgeonE['surgeonFirst']==$surgeonBF && $surgeonE['surgeonLast']==$surgeonBL)
               continue;
            else if ($_SESSION['surgeonID'] == $surgeonE['surgeonID'])
            {
                echo '<option value='.$surgeonE['surgeonID'].' selected>'.strtoupper($surgeonE['surgeonLast']).', '.strtoupper($surgeonE['surgeonFirst']).'</option>';
                $surgeonBF = $surgeonE['surgeonFirst'];
                $surgeonBL = $surgeonE['surgeonLast'];
            }
            else
            {
                echo '<option value='.$surgeonE['surgeonID'].'>'.strtoupper($surgeonE['surgeonLast']).', '.strtoupper($surgeonE['surgeonFirst']).'</option>';
                $surgeonBF = $surgeonE['surgeonFirst'];
                $surgeonBL = $surgeonE['surgeonLast'];
            }
        }
    }
    else
    {
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
    }
    echo'
            </select>
            </td>
         </tr>
         <tr>            
            <td style="width:40%; border:none; text-align:right; font-size:24px;">
                <b>CPT:</b>
            </td>
            
            <td style="border:none; width:60%; padding:10px; font-size:24px;">
            <select name="cpt">';
    
    
    if (isset($_SESSION['cptID']))
    {
        while ($cptE = mysqli_fetch_array($cptA))
        {
            if ($_SESSION['cptID'] == $cptE['id'])
            {
                echo '<option value='.$cptE['id'].' selected>'.$cptE['asaCode'].' - '.$cptE[2].'</option>';
            }
            else
            {
                echo '<option value='.$cptE['id'].'>'.$cptE['asaCode'].' - '.$cptE[2].'</option>';
            }
        }
    }
    else
    {
        while ($cptE = mysqli_fetch_array($cptA))
        {
           echo '<option value='.$cptE['id'].'>'.$cptE['asaCode'].' - '.$cptE[2].'</option>';
        }
    }
    
    echo'
            </select>
            </td>
        </tr>
       </table>
       <br>';
    
    
    
    
    //////////////////////////////////////////////////////////////////////////////////////////
    //PRIMARY BLOCK                                                                         //
    //////////////////////////////////////////////////////////////////////////////////////////
    echo'
      <center>
      <h1 class="h1log" style="text-align:left color:#000000">Primary Block</h1>';
   
      
    $block1Q = "SELECT * FROM blocks ORDER BY block";
    $block1A = mysqli_query($dbc, $block1Q);

    $drug1Q = "SELECT * FROM drug ORDER BY id";
    $drug1A = mysqli_query($dbc, $drug1Q);


    if ($_SESSION['w'] > 925)
    {
        echo'
            <table style="border-style:solid; width:70%; margin-left:auto; margin-right:auto;">';
    }
    else
    {
        echo'
            <table style="margin-left:auto; margin-right:auto; border-style:solid; width:95%;">';
    }   
    echo'
        <tr>
            <td style="width:16%; border:none; text-align:right; padding:10px; font-size:20px;">
                <b>Type of Block:</b>
            </td>



            <td style="border:none; width:16%; padding:10px; font-size:20px;">
            <select name="block1">';
   
   
    if (isset($_SESSION['block1ID']))
    {
       while ($block1E = mysqli_fetch_array($block1A))
       {
           if ($_SESSION['block1ID'] == $block1E['id'])
           {
               echo '<option value='.$block1E['id'].' selected>'.$block1E['block'].'</option>';
           }
           else
           {
               echo '<option value='.$block1E['id'].'>'.$block1E['block'].'</option>';
           }
       }
    }
    else
    {
       while ($block1E = mysqli_fetch_array($block1A))
       {
               echo '<option value='.$block1E['id'].'>'.$block1E['block'].'</option>';
       }
    }
   
   
    echo'
            </select>
            </td>


            <td style="width:16%; border:none; text-align:right; padding:10px; font-size:20px;">
                <b>Local:</b>
            </td>

            <td style="border:none; width:16%; padding:10px; font-size:20px;">
            <select name="drug1">';

    if (isset($_SESSION['drug1ID']))
    {
       while ($drug1E = mysqli_fetch_array($drug1A))
       {
           if ($_SESSION['drug1ID'] == $drug1E['id'])
           {
               echo '<option value='.$drug1E['id'].' selected>'.$drug1E['med'].'</option>';
           }
           else
           {
                echo '<option value='.$drug1E['id'].'>'.$drug1E['med'].'</option>';
           }
       }
    }
    else
    {
       while ($drug1E = mysqli_fetch_array($drug1A))
       {
            echo '<option value='.$drug1E['id'].'>'.$drug1E['med'].'</option>';
       }
    }
   
   
    echo'
            </select>
            </td>
            
            <td style="width:16%; border:none; text-align:right; padding:10px; font-size:20px;">
                <b>Volume (ml):</b>
            </td>
            
            <td style="width:16%; padding:10px; font-size:20px;">';
    
    if (isset($_SESSION['volume1']))
    {
        echo'
        <input type="text" name="volume1" maxlength="3" size="3" value="'.$_SESSION['volume1'].'" style="font-size:20px;">';
    }
    else
    {
        echo'
        <input type="text" name="volume1" maxlength="3" size="3" value="0" style="font-size:20px;">';
    }
    
    echo'
            </td>
       </tr>
       </table>';
    
   
    if ($_SESSION['w'] > 925)
    {
        echo'
            <table style="border-style:solid; width:70%; margin-left:auto; margin-right:auto;">';
    }
    else
    {
        echo'
            <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">';
    }


    if (isset($_SESSION['addi1']))
    {
        $s = "";
        foreach($_SESSION['addi1'] as $a1)
        {
           $s .= $a1; 
        }

        echo'
            <tr>
                <td style="border: none; width:8%; font-size:20px;">
                <b>Additives:</b>
                </td>
                <td style="border: 1px solid black; width:23%; text-align:center;">
                <label for="epi400">Epinephrine 1:400,000 </label>';


        if (strpos($s,"epi400")!== false)
        {
            echo
            '<input type="checkbox" id="epi400" name="addi1[]" value="epi400" checked/>'; 
        }                    
        else
        {
            echo
            '<input type="checkbox" id="epi400" name="addi1[]" value="epi400"/>';
        }
        echo'                                 
                </td>
                <td style="border: 1px solid black; width:23%; text-align:center">
                <label for="epi200">Epinephrine 1:200,000</label>';

        if (strpos($s,"epi200") !== false)
        {
            echo
            '<input type="checkbox" id="epi200" name="addi1[]" value="epi200" checked/>'; 
        }                    
        else
        {
            echo
            '<input type="checkbox" id="epi200" name="addi1[]" value="epi200"/>';
        }
        
        echo'                                 
                </td>
            </tr>
            <tr>
                <td>
                </td>
                <td style="border: 1px solid black; width:23%; text-align:center">
                <label for="clonidine">Clonidine</label>';
        
        if (strpos($s,"clonidine") !== false)
        {
            echo
            '<input type="checkbox" id="clonidine" name="addi1[]" value="clonidine" checked/>'; 
        }                    
        else
        {
            echo
            '<input type="checkbox" id="clonidine" name="addi1[]" value="clonidine"/>';
        }
    

        echo'
                </td>
                <td style="border: 1px solid black; width:23%; text-align:center">
                <label for="dex">Dexmedetomidine</label>';
    
        if (strpos($s,"dex") !== false)
        {
            echo
            '<input type="checkbox" id="dex" name="addi1[]" value="dex" checked/>'; 
        }                    
        else
        {
            echo
            '<input type="checkbox" id="dex" name="addi1[]" value="dex"/>';
        }
        echo'                
                </td>   
            </tr>
            <tr>
                    <td style="border:none; width:8%;">
                    </td>
                    <td style="border: 1px solid black; width:23%; text-align:center"> 
                    <label for="decadron">Decadron</label>';
        if (strpos($s,"decadron") !== false)
        {
            echo
            '<input type="checkbox" id="decadron" name="addi1[]" value="decadron" checked/>'; 
        }                    
        else
        {
            echo
            '<input type="checkbox" id="decadron" name="addi1[]" value="decadron"/>';
        }
        echo'       
                    </td> 
                </tr>
            </table>';
    }
                

    else
    {
        echo'
                <tr>
                    <td style="border: none; width:8%; font-size:20px;">
                    <b>Additives:</b>
                    </td>
                    <td style="border: 1px solid black; width:23%; text-align:center;">
                    <label for="epi400">Epinephrine 1:400,000 </label>
                    <input type="checkbox" id="epi400" name="addi1[]" value="epi400" />                    
                    </td>
                    <td style="border: 1px solid black; width:23%; text-align:center">
                    <label for="epi200">Epinephrine 1:200,000</label>
                    <input type="checkbox" id="epi200" name="addi1[]" value="epi200" />
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
            </table>';
    }

            
    if ($_SESSION['w'] > 925)
    {
        echo'
            <table style="border-style:solid; width:70%; margin-left:auto; margin-right:auto;">';
    }
    else
    {
        echo'
            <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">';
    } 
    
    if (isset($_SESSION['method1']) && $_SESSION['method1']=='catheter')
    {
        echo'
                <tr>
                    <td style="text-align:center; font-weight: bold; font-size:20px;">
                    Method:
                    </td>
                    <td style="text-align:center">
                    <input type="radio" name="method1" value="singleshot">Single Shot
                    </td>
                    <td style="text-align:center">
                    <input type="radio" name="method1" value="catheter" checked>Catheter<br>
                    </td>
                </tr>
            </table>';
    }
    else
    {
        echo'
                <tr>
                    <td style="text-align:center; font-weight: bold;">
                    Method:
                    </td>
                    <td style="text-align:center">
                    <input type="radio" name="method1" value="singleshot" checked>Single Shot
                    </td>
                    <td style="text-align:center">
                    <input type="radio" name="method1" value="catheter">Catheter<br>
                    </td>
                </tr>
            </table>';
    }
   
    
    //////////////////////////////////////////////////////////////////////////////////////////
    //SECONDARY BLOCK                                                                       //
    //////////////////////////////////////////////////////////////////////////////////////////
    echo'
    <center>
    <h1 class="h1log" style="text-align:left color:#000000">Secondary Block</h1>';
   
   
    $block2Q = "SELECT * FROM blocks ORDER BY block";
    $block2A = mysqli_query($dbc, $block2Q);
   
    $drug2Q = "SELECT * FROM drug ORDER BY id";
    $drug2A = mysqli_query($dbc, $drug2Q);
   
   
    if ($_SESSION['w'] > 925)
    {
        echo'
            <table style="border-style:solid; width:70%; margin-left:auto; margin-right:auto;">';
    }
    else
    {
        echo'
            <table style="margin-left:auto; margin-right:auto; border-style:solid; width:95%;">';
    }   
    echo'
        <tr>
            <td style="width:16%; border:none; text-align:right; padding:10px; font-size:20px;">
                <b>Type of Block:</b>
            </td>



            <td style="border:none; width:16%; padding:10px; font-size:20px;">
            <select name="block2">';
   
   
    if (isset($_SESSION['block2ID']))
    {
       while ($block2E = mysqli_fetch_array($block2A))
       {
           if ($_SESSION['block2ID'] == $block2E['id'])
           {
               echo '<option value='.$block2E['id'].' selected>'.$block2E['block'].'</option>';
           }
           else
           {
               echo '<option value='.$block2E['id'].'>'.$block2E['block'].'</option>';
           }
       }
    }
    else
    {
       while ($block2E = mysqli_fetch_array($block2A))
       {
               echo '<option value='.$block2E['id'].'>'.$block2E['block'].'</option>';
       }
    }
   
   
    echo'
            </select>
            </td>


            <td style="width:16%; border:none; text-align:right; padding:10px; font-size:20px;">
                <b>Local:</b>
            </td>

            <td style="border:none; width:16%; padding:10px; font-size:20px;">
            <select name="drug2">';

    if (isset($_SESSION['drug2ID']))
    {
       while ($drug2E = mysqli_fetch_array($drug2A))
       {
           if ($_SESSION['drug2ID'] == $drug2E['id'])
           {
               echo '<option value='.$drug2E['id'].' selected>'.$drug2E['med'].'</option>';
           }
           else
           {
                   echo '<option value='.$drug2E['id'].'>'.$drug2E['med'].'</option>';
           }
       }
    }
    else
    {
       while ($drug2E = mysqli_fetch_array($drug2A))
       {
               echo '<option value='.$drug2E['id'].'>'.$drug2E['med'].'</option>';
       }
    }
   
   
    echo'
            </select>
            </td>
            
            <td style="width:16%; border:none; text-align:right; padding:10px; font-size:20px;">
                <b>Volume (ml):</b>
            </td>
            
            <td style="width:16%; padding:10px; font-size:20px;">';
    
    if (isset($_SESSION['volume2']))
    {
        echo'
        <input type="text" name="volume2" maxlength="3" size="3" value="'.$_SESSION['volume2'].'" style="font-size:20px;">';
    }
    else
    {
        echo'
        <input type="text" name="volume2" maxlength="3" size="3" value="0" style="font-size:20px;">';
    }
    
    echo'
            </td>
       </tr>
       </table>';
   
    if ($_SESSION['w'] > 925)
    {
        echo'
            <table style="border-style:solid; width:70%; margin-left:auto; margin-right:auto;">';
    }
    else
    {
        echo'
            <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">';
    }


    if (isset($_SESSION['addi2']))
    {
        $s = "";
        foreach($_SESSION['addi2'] as $a2)
        {
           $s .= $a2; 
        }

        echo'
            <tr>
                <td style="border: none; width:8%; font-size:20px;">
                <b>Additives:</b>
                </td>
                <td style="border: 1px solid black; width:23%; text-align:center;">
                <label for="epi400">Epinephrine 1:400,000 </label>';


        if (strpos($s,"epi400")!== false)
        {
            echo
            '<input type="checkbox" id="epi400" name="addi2[]" value="epi400" checked/>'; 
        }                    
        else
        {
            echo
            '<input type="checkbox" id="epi400" name="addi2[]" value="epi400"/>';
        }
        echo'                                 
                </td>
                <td style="border: 1px solid black; width:23%; text-align:center">
                <label for="epi200">Epinephrine 1:200,000</label>';

        if (strpos($s,"epi200") !== false)
        {
            echo
            '<input type="checkbox" id="epi200" name="addi2[]" value="epi200" checked/>'; 
        }                    
        else
        {
            echo
            '<input type="checkbox" id="epi200" name="addi2[]" value="epi200"/>';
        }
        
        echo'                                 
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="border: 1px solid black; width:23%; text-align:center">
                <label for="clonidine">Clonidine</label>';
        
        if (strpos($s,"clonidine") !== false)
        {
            echo
            '<input type="checkbox" id="clonidine" name="addi2[]" value="clonidine" checked/>'; 
        }                    
        else
        {
            echo
            '<input type="checkbox" id="clonidine" name="addi2[]" value="clonidine"/>';
        }
    

        echo'
                </td>
                <td style="border: 1px solid black; width:23%; text-align:center">
                <label for="dex">Dexmedetomidine</label>';
    
        if (strpos($s,"dex") !== false)
        {
            echo
            '<input type="checkbox" id="dex" name="addi2[]" value="dex" checked/>'; 
        }                    
        else
        {
            echo
            '<input type="checkbox" id="dex" name="addi2[]" value="dex"/>';
        }
        echo'                
                </td>   
            </tr>
            <tr>
                    <td style="border:none; width:8%;">
                    </td>
                    <td style="border: 1px solid black; width:23%; text-align:center"> 
                    <label for="decadron">Decadron</label>';
        if (strpos($s,"decadron") !== false)
        {
            echo
            '<input type="checkbox" id="decadron" name="addi1[]" value="decadron" checked/>'; 
        }                    
        else
        {
            echo
            '<input type="checkbox" id="decadron" name="addi1[]" value="decadron"/>';
        }
        echo'       
                    </td> 
                </tr>
            </table>';
    }
                

    else
    {
        echo'
                <tr>
                    <td style="border: none; width:8%; font-size:20px;">
                    <b>Additives:</b>
                    </td>
                    <td style="border: 1px solid black; width:23%; text-align:center;">
                    <label for="epi400">Epinephrine 1:400,000 </label>
                    <input type="checkbox" id="epi400" name="addi2[]" value="epi400" />                    
                    </td>
                    <td style="border: 1px solid black; width:23%; text-align:center">
                    <label for="epi200">Epinephrine 1:200,000</label>
                    <input type="checkbox" id="epi200" name="addi2[]" value="epi200" />
                    </td>
                </tr>
                <tr>
                    <td style="border:none; width:8%;">
                    </td>
                    <td style="border: 1px solid black; width:23%; text-align:center"> 
                    <label for="clonidine">Clonidine</label>
                    <input type="checkbox" id="clonidine" name="addi2[]" value="clonidine"/>       
                    </td>
                    <td style="border: 1px solid black; width:23%; text-align:center">
                    <label for="dex">Dexmedetomidine</label>
                    <input type="checkbox" id="dex" name="addi2[]" value="dex" />        
                    </td>   
                </tr>
                <tr>
                    <td style="border:none; width:8%;">
                    </td>
                    <td style="border: 1px solid black; width:23%; text-align:center"> 
                    <label for="decadron">Decadron</label>
                    <input type="checkbox" id="decadron" name="addi2[]" value="decadron"/>       
                    </td> 
                </tr>
            </table>';
    }

            
    if ($_SESSION['w'] > 925)
    {
        echo'
            <table style="border-style:solid; width:70%; margin-left:auto; margin-right:auto;">';
    }
    else
    {
        echo'
            <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">';
    } 
    
    if (isset($_SESSION['method2']) && $_SESSION['method2']=='catheter')
    {
        echo'
                <tr>
                    <td style="text-align:center; font-weight: bold; font-size:20px;">
                    Method:
                    </td>
                    <td style="text-align:center">
                    <input type="radio" name="method2" value="singleshot">Single Shot
                    </td>
                    <td style="text-align:center">
                    <input type="radio" name="method2" value="catheter" checked>Catheter<br>
                    </td>
                </tr>
            </table>';
    }
    else
    {
        echo'
                <tr>
                    <td style="text-align:center; font-weight: bold; font-size:20px;">
                    Method:
                    </td>
                    <td style="text-align:center">
                    <input type="radio" name="method2" value="singleshot" checked>Single Shot
                    </td>
                    <td style="text-align:center">
                    <input type="radio" name="method2" value="catheter">Catheter<br>
                    </td>
                </tr>
            </table>';
    }
    
    echo'
        <h1>Enter Date and Hour Block(s) was(were) placed</h1>
        <br>
        <table style="width:35%; border-style:solid;">
            <tr>
                <td style="width:33%; border:none; text-align:center; font-size:20px;"><b>Month</b></td>
                <td style="width:33%; border:none; text-align:center; font-size:20px;"><b>Day</b></td>
                <td style="width:33%; border:none; text-align:center; font-size:20px;"><b>Hour</b></td>
            </tr>


            <tr>
                <td style="width:33%; border:none; text-align:center; font-size:20px;">

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
    </div>';
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
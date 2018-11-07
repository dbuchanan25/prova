<?php
session_start();
$datetime = new DateTime("now", new DateTimeZone('US/Eastern'));
$datetime2 = new DateTime("now", new DateTimeZone('US/Eastern'));


if (!isset($_SESSION['username']))
{
    require_once ('includes/login_functions.inc.php');
    $_SESSION['pt1entry'] = true;
    $url = absolute_url();
    header("Location: $url");
    exit();
}
else
{
    $goahead = false;
    $_SESSION['loginstring']='includes/connect.php';
    require_once ($_SESSION['loginstring']);
    
    $ph = $_SESSION['ptphone'];
    $phcomplete = "(".substr($ph,0,3).") ".substr($ph,3,3)."-".substr($ph,6);
    
    $q = "SELECT painscore1, id ".
         "FROM patients ".
         "WHERE phone LIKE '".$phcomplete."' ".
         "AND active = 1";
    $r = mysqli_query($dbc, $q);
    if ($r !== false)
    {
        $s = mysqli_fetch_array($r);
        $_SESSION['id'] = $s[1];
        if ($s[0] == -1)
        {
            $goahead = true;
        }
        if (isset($_SESSION['again1']) && $_SESSION['again1'])
        {
            $goahead = true;
        }
        if (!$goahead)
        {
            header("Location: ptblock1.php");
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
<title>Day 1 Entry</title>
<body>

<div class="row2" style="background-color:#7db4dc; width:'.$_SESSION['w'].'">
  <center><img src="includes/ProvidenceSmall.png" alt="PAA" height='.($_SESSION['w']*0.2369*.5*.7).'; width='.($_SESSION['w']*.5*.7).';" /></center>
</div>';
?>

<div class="topnav">
  <a href="eos.php">Evening of Surgery</a>
  <a href="#">Postoperative Day #1</a>
  <a href="blockInformation.php">Block Information</a>
  <a href="faqs.php">FAQs</a>
  <a href="logout.php">Logout</a>
</div>
    <br><br>
    <center><h1>POSTOPERATIVE DAY #1</h1></center>
    <br><br>
    <center><h1>What is your current pain level?</h1></center>
    <br>
    <table style="border-style:solid; width:70%; margin-right:auto; margin-left:auto; font-size:20;">
            <tr>
            
                <td style="border:none; width:25%;">
                No Pain
                </td>
                
                <td style="border:none; width:25%;">
                Mild Pain
                </td>
                
                <td style="border:none; width:25%; text-align:center;">
                Moderate (tolerable) Pain
                </td>
                
                <td style="border:none; width:25%; text-align:right">
                Severe (intolerable) Pain
                </td>
                
            </tr>
    </table>

                

    <form action="action_page_pt_day1entry.php" method="post">
    <table style="border-style:solid; width:70%; margin-right:auto; margin-left:auto;">
            <tr>

                <td style="border:none; width:10%;">                
                <label class="control control-checkbox">
                 1
                <input type="radio" id="1" name="pscore" value="1"/>
                <div class="control_indicator"></div>
                </label>
                </td>

                <td style="border:none; width:10%;">
                <label class="control control-checkbox">
                 2
                <input type="radio" id="2" name="pscore" value="2"/>
                <div class="control_indicator"></div>
                </label>
                </td>
                
                <td style="border:none; width:10%;">
                <label class="control control-checkbox">
                 3
                <input type="radio" id="3" name="pscore" value="3"/>
                <div class="control_indicator"></div>
                </label>
                </td>

                <td style="border:none; width:10%;">
                <label class="control control-checkbox">
                 4
                <input type="radio" id="4" name="pscore" value="4"/>
                <div class="control_indicator"></div>
                </label>
                </td>

                <td style="border:none; width:10%;">
                <label class="control control-checkbox">
                 5
                <input type="radio" id="5" name="pscore" value="5"/>
                <div class="control_indicator"></div>
                </label>
                </td>

                <td style="border:none; width:10%;">
                <label class="control control-checkbox">
                 6
                <input type="radio" id="6" name="pscore" value="6"/>
                <div class="control_indicator"></div>
                </label>            
                </td>

                <td style="border:none; width:10%;">
                <label class="control control-checkbox">
                 7
                <input type="radio" id="7" name="pscore" value="7"/>
                <div class="control_indicator"></div>
                </label>                
                </td>

                <td style="border:none; width:10%;">
                <label class="control control-checkbox">
                 8
                <input type="radio" id="8" name="pscore" value="8"/>
                <div class="control_indicator"></div>
                </label>             
                </td>

                <td style="border:none; width:10%;">
                <label class="control control-checkbox">
                 9
                <input type="radio" id="9" name="pscore" value="9"/>
                <div class="control_indicator"></div>
                </label>             
                </td>

                <td style="border:none; width:10%;">
                <label class="control control-checkbox">
                 10
                <input type="radio" id="10" name="pscore" value="10"/>
                <div class="control_indicator"></div>
                </label>             
                </td>                
            </tr>
            <tr>
                <td>
                 <img src="1.png" width="50">
                </td>
                <td>
                 <img src="2.png" width="50">
                </td>
                <td>
                 <img src="3.png" width="50">
                </td>
                <td>
                 <img src="4.png" width="50">
                </td>
                <td>
                 <img src="5.png" width="50">
                </td>
                <td>
                 <img src="6.png" width="50">
                </td>
                <td>
                 <img src="7.png" width="50">
                </td>
                <td>
                 <img src="8.png" width="50">
                </td>
                <td>
                 <img src="9.png" width="50">
                </td>
                <td>
                 <img src="10.png" width="35">
                </td>
            </tr>           
    </table>
    <br><br>



    <svg height="10" width="'.$_SESSION['w'].'">
    <line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />
    </svg>
    <br><br>
    <center><h1>Do you have weakness in the area of the nerve block?</h1></center>
    <br>
    <table style="width:100%; margin-right:auto; margin-left:auto">
            <tr>

                <td style="border:none; width:25%">
                </td>
                
                <td style="border:none; width:25%;">

                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
		<label class="control control-checkbox">
                Yes
                <input type="checkbox" id="motory" name="motor" value="1"/>
                <div class="control_indicator"></div>
                </label>
                </td>
                </tr>
                </table>
                
                </td>
                
                <td style="border:none; width:25%;">
                
                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
		<label class="control control-checkbox">
                No
                <input type="checkbox" id="motorn" name="motor" value="0"/>
                <div class="control_indicator"></div>
                </label>
                </td>
                </tr>
                </table>

                </td>
                
                <td style="border:none; width:25%">
                </td>
                
            </tr>
    </table>
    <br><br>
    
    <script type="text/javascript">
    function clickYes() {
        if (document.getElementById("motorn").checked) {
                        document.getElementById("motorn").checked = false;
        }
    }

    function clickNo() {
        if (document.getElementById("motory").checked) {
                        document.getElementById("motory").checked = false;
        }
    }

    document.getElementById("motory").onchange = clickYes;
    document.getElementById("motorn").onchange = clickNo;


    function doOnOrientationChange()
    {
        window.location("resetwidth.php");
    }
    window.addEventListener('orientationchange', doOnOrientationChange);
    </script>
    
    
<?php
    echo'
    <svg height="10" width="'.$_SESSION['w'].'">
    <line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />
    </svg>
    <br><br>
    <h1><center>Do you have numbness in the area of the nerve block?</center></h1>
    <br>
     <table style=width:100%; margin-right:auto; margin-left:auto">
            <tr>

                <td style="border:none; width:25%">
                </td>
                
                <td style="border:none; width:25%;">

                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
		<label class="control control-checkbox">
                 Yes
                 <input type="checkbox" id="sensoryy" name="sensory" value="1"/>
                    <div class="control_indicator"></div>
                </label>
                </td>
                </tr>
                </table>
                
                </td>
                
                <td style="border:none; width:25%;">
                
                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
		<label class="control control-checkbox">
                 No
                 <input type="checkbox" id="sensoryn" name="sensory" value="0"/>
                    <div class="control_indicator"></div>
                </label>
                </td>
                </tr>
                </table>

                </td>
                
                <td style="border:none; width:25%">
                </td>
                
            </tr>
    </table>
    <br>';
    ?>
    
  
  
  
  

    <script type="text/javascript">
    function clickYes() {
        if (document.getElementById("sensoryn").checked) {
                        document.getElementById("sensoryn").checked = false;
        }
    }

    function clickNo() {
        if (document.getElementById("sensoryy").checked) {
                        document.getElementById("sensoryy").checked = false;
        }
    }

    document.getElementById("sensoryy").onchange = clickYes;
    document.getElementById("sensoryn").onchange = clickNo;
    </script>
    
    

    

   
                
<?php
echo'
    <svg height="10" width="'.$_SESSION['w'].'">
    <line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />
    </svg>
      
    <br><br>
    <center><h1>Have you been taking Tylenol (acetaminophen)?</h1></center>
    <br>
    <table style=width:100%; margin-right:auto; margin-left:auto">
        <tr>
            <td style="border:none; width:25%">
            </td>

            <td style="border:none; width:25%;">

            <table style="border-style:solid; margin-right:auto; margin-left:auto;">
            <tr>
            <td>
            <label class="control control-checkbox">
            Yes
            <input type="checkbox" id="tylenoly" name="tylenol" value="1"/>
            <div class="control_indicator"></div>
            </label>
            </td>
            </tr>
            </table>

            </td>

            <td style="border:none; width:25%;">

            <table style="border-style:solid; margin-right:auto; margin-left:auto;">
            <tr>
            <td>
            <label class="control control-checkbox">
            No
            <input type="checkbox" id="tylenoln" name="tylenol" value="0"/>
            <div class="control_indicator"></div>
            </label>
            </td>
            </tr>
            </table>

            </td>
            <td style="border:none; width:25%">
            </td>
        </tr>
    </table>
    <br>
    <svg height="10" width="'.$_SESSION['w'].'">
    <line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />
    </svg>
   
    <script type="text/javascript">
    function clickYesT() {
        if (document.getElementById("tylenoln").checked) {
                        document.getElementById("tylenoln").checked = false;
        }
    }

    function clickNoT() {
        if (document.getElementById("tylenoly").checked) {
                        document.getElementById("tylenoly").checked = false;
        }
    }

    document.getElementById("tylenoly").onchange = clickYesT;
    document.getElementById("tylenoln").onchange = clickNoT;
    </script>
    
    
    <br><br>
    <center><h1>Have you been taking Non-steroidal Anti-inflammatory Drugs (NSAIDS)?</h1></center><br>
    <center><h2>(such as Motrin, Advil, ibuprofen, diclofenac, naproxen, Naprosyn, etodolac, ketorolac, Toradol)</h2></center>
    <br>
    <table style=width:100%; margin-right:auto; margin-left:auto">
            <tr>

                <td style="border:none; width:25%">
                </td>

                <td style="border:none; width:25%;">

                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
                <label class="control control-checkbox">
                Yes
                <input type="checkbox" id="nsaidsy" name="nsaids" value="1"/>
                <div class="control_indicator"></div>
                </label>
                </td>
                </tr>
                </table>

                </td>

                <td style="border:none; width:25%;">

                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
                <label class="control control-checkbox">
                No
                <input type="checkbox" id="nsaidsn" name="nsaids" value="0"/>
                <div class="control_indicator"></div>
                </label>
                </td>
                </tr>
                </table>

                </td>

                <td style="border:none; width:25%">
                </td>

            </tr>
    </table>
    <br>
    <svg height="10" width="'.$_SESSION['w'].'">
    <line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />
    </svg>';
?>
   
    <script type="text/javascript">
    function clickYesN() {
        if (document.getElementById("nsaidsn").checked) {
                        document.getElementById("nsaidsn").checked = false;
        }
    }

    function clickNoN() {
        if (document.getElementById("nsaidsy").checked) {
                        document.getElementById("nsaidsy").checked = false;
        }
    }

    document.getElementById("nsaidsy").onchange = clickYesN;
    document.getElementById("nsaidsn").onchange = clickNoN;
    </script>';

<?php
    echo
    '<br><br> '.
    '<h1><center>Have you been taking any opioids?</center></h1><br> '.
    '<h2><center>(such as oxycodone, hydrocodone, codeine, Lortab, Lorcet, Oxycontin, Vicodin, Percocet)</center></h2> '.
    '<br> '.
    '<table style=width:100%; margin-right:auto; margin-left:auto"> '.
        '<tr> '.
            '<td style="border:none; width:25%"> '.
            '</td> '.                
            '<td style="border:none; width:25%;"> '.

            '<table style="border-style:solid; margin-right:auto; margin-left:auto;"> '.
                '<tr> '.
                    '<td> '.
                    '<label class="control control-checkbox"> '.
                    'Yes '.
                    '<input type="checkbox" id="narcsy" name="narcs" value="1"/> '.
                    '<div class="control_indicator"></div> '.
                    '</label> '.
                    '</td> '.
                '</tr> '.
            '</table> '.
               
            '</td> '.
            '<td style="border:none; width:25%;"> '.

            '<table style="border-style:solid; margin-right:auto; margin-left:auto;"> '.
                '<tr> '.
                    '<td> '.
                    '<label class="control control-checkbox"> '.
                    'No '.
                    '<input type="checkbox" id="narcsn" name="narcs" value="0"/> '.
                    '<div class="control_indicator"></div> '.
                    '</label> '.
                    '</td> '.
                '</tr> '.
            '</table> '.

            '</td> '.
            '<td style="border:none; width:25%"> '.
            '</td> '.     
        '</tr> '.
    '</table> '.
    '<br>';
?>
   
   <script type="text/javascript">
    function clickYesNa() {
        if (document.getElementById("narcsn").checked) {
                        document.getElementById("narcsn").checked = false;
        }
    }

    function clickNoNa() {
        if (document.getElementById("narcsy").checked) {
                        document.getElementById("narcsy").checked = false;
        }
    }

    document.getElementById("narcsy").onchange = clickYesNa;
    document.getElementById("narcsn").onchange = clickNoNa;
    </script>
    

<?php
echo
    '<svg height="10" width="'.$_SESSION['w'].'"> '.
    '<line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" /> '.
    '</svg> '.
    '<br><br> '.
      '<h1><center>If the Block Has Worn Off (if the area is not numb anymore):<br>Enter Date and Hour Block Wore Off.</center></h1> '.
      '<br> '.
            '<table style="width:35%; border-style:solid; margin-left:auto; margin-right:auto;"> '.
                '<tr> '.
                    '<td style="width:33%; border:none; text-align:center"><b>Month</b></td><td style="width:33%; border:none; text-align:center"> '.
                    '<b>Day</b></td><td style="width:33%; border:none; text-align:center"><b>Hour</b></td> '.
                '</tr> '.
                
                '<tr> '.
                    '<td style="width:33%; border:none; text-align:center"> '.                   
                    '<select name="month" id="month"  style="font-size:20;" onchange="click2()">';
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
                    };
?>
                    
    <script type="text/javascript">

    document.write("</td><td style=\"width:33%; border:none; text-align:center\"><select name=\"day\" id=\"day\"  style=\"font-size:20;\"");
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

                echo
                '</select> '.
                    '</td> '.
                    '<td style="width:33%; border:none; text-align:center"> '.
                    '<select name="hour" style="font-size:20;">';

                
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
                echo
                    '</select> '.
                    '</td> '.
                '</tr> '.
            '</table> '.
     '<br><br> '.                                               
     '</select>';
                    

echo
    '<table align="center" width="100%" style="text-align:left; padding-left:50px; padding-top:15px; padding-bottom:15px; border:none">'.
            '<tr>'.
                '<td width="50%" align="center" style="border: none">'.
                     '<input type="submit" name="BReg" value="SUBMIT" class="btn">'.
                '</td>'.
            '</tr>'.
    '</table>'.
    '</form>'.
    '<br><br>'.
    '</body>';
}
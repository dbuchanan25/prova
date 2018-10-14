<?php
//////////////////////////////////////////////////////////////////////////////////////////////////
//PATIENT INTERFACE                                                                             //
//VERSION 01_01                                                                                 //
//LAST REVISED 20180813                                                                         //
//////////////////////////////////////////////////////////////////////////////////////////////////

session_start();

echo'
<link rel="stylesheet" href="styles/style.css" type="text/css">
';

if (!isset($_SESSION['username']))
{
   require_once ('includes/login_functions.inc.php');
   $url = absolute_url();
   header("Location: $url");
   exit();
}
else
{
    include('includes/header.php');
    
    $datetime = new DateTime("now", new DateTimeZone('US/Eastern'));
    $datetime2 = new DateTime("now", new DateTimeZone('US/Eastern'));


    $_SESSION['loginstring']='includes/connect.php';
    require_once ($_SESSION['loginstring']);
    $page_title = 'Postoperative Block Survey';

    echo'
    <br><br>
    <h1><center>What is your current pain level? (Check One)</center></h1>
    <br>
    <table style="border-style:solid; width:70%; margin-right:auto; margin-left:auto;">
            <tr>
            
                <td style="border:none; width:25%;">
                No Pain
                </td>
                
                <td style="border:none; width:25%; text-align:center;">
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

                
       
    <table style="border-style:solid; width:70%; margin-right:auto; margin-left:auto;">
            <tr>

                <td style="border:none; width:10%;">
                <label for="1">1</label>
                <input type="checkbox" id="1" name="pscore" value="1" onchange="click2(1)"/>
                </td>

                <td style="border:none; width:10%;">
                <label for="2">2</label>
                <input type="checkbox" id="2" name="pscore" value="2" onchange="click2(2)"/>
                </td>

                <td style="border:none; width:10%;">
                <label for="3">3</label>                
                <input type="checkbox" id="3" name="pscore" value="3" onchange="click2(3)"/>
                </td>

                <td style="border:none; width:10%;">
                <label for="4">4</label>
                <input type="checkbox" id="4" name="pscore" value="4" onchange="click2(4)"/>
                </td>

                <td style="border:none; width:10%;">
                <label for="5">5</label>
                <input type="checkbox" id="5" name="pscore" value="5" onchange="click2(5)"/>
                </td>

                <td style="border:none; width:10%;">
                <label for="6">6</label>
                <input type="checkbox" id="6" name="pscore" value="6" onchange="click2(6)"/>                
                </td>

                <td style="border:none; width:10%;">
                <label for="7">7</label>
                <input type="checkbox" id="7" name="pscore" value="7" onchange="click2(7)"/>                
                </td>

                <td style="border:none; width:10%;">
                <label for="8">8</label>
                <input type="checkbox" id="8" name="pscore" value="8" onchange="click2(8)"/>                
                </td>

                <td style="border:none; width:10%;">
                <label for="9">9</label>
                <input type="checkbox" id="9" name="pscore" value="9" onchange="click2(9)"/>                
                </td>

                <td style="border:none; width:10%;">
                <label for="10">10</label>
                <input type="checkbox" id="10" name="pscore" value="10" onchange="click2(10)"/>                
                </td>


            </tr>
    </table>
    <br><br>';
    ?>
    
    <script type="text/javascript"> 
        
    function click2(y){
        var x;
        for (x=1; x<=10; x++)
        {
            if (x===y)
                continue;
            else if (document.getElementById(x).checked) {
                        document.getElementById(x).checked = false;
                    }
        }
    }
    
    </script>
    


    <?php
    echo'
    <svg height="10" width="'.$_SESSION['w'].'">
    <line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />
    </svg>
    <br><br>
    <h1><center>Do you have weakness in the area of the nerve block? (Check One)</center></h1>
    <br>
     <table style=width:100%; margin-right:auto; margin-left:auto">
            <tr>

                <td style="border:none; width:25%">
                </td>
                
                <td style="border:none; width:25%;">

                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
		<label for="motory">Yes</label>&nbsp;&nbsp;
		<input type="checkbox" id="motory" name="motor" />
                </td>
                </tr>
                </table>
                
                </td>
                
                <td style="border:none; width:25%;">
                
                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
		<label for="motorn">No</label>&nbsp;&nbsp;
		<input type="checkbox" id="motorn" name="motor" />
                </td>
                </tr>
                </table>

                </td>
                
                <td style="border:none; width:25%">
                </td>
                
            </tr>
    </table>
    <br><br>';
    ?>
    

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
    <h1><center>Do you have numbness in the area of the nerve block? (Check One)</center></h1>
    <br>
     <table style=width:100%; margin-right:auto; margin-left:auto">
            <tr>

                <td style="border:none; width:25%">
                </td>
                
                <td style="border:none; width:25%;">

                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
		<label for="sensoryy">Yes</label>&nbsp;&nbsp;
		<input type="checkbox" id="sensoryy" name="sensory" />
                </td>
                </tr>
                </table>
                
                </td>
                
                <td style="border:none; width:25%;">
                
                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
		<label for="sensoryn">No</label>&nbsp;&nbsp;
		<input type="checkbox" id="sensoryn" name="sensory" />
                </td>
                </tr>
                </table>

                </td>
                
                <td style="border:none; width:25%">
                </td>
                
            </tr>
    </table>';
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
    <br><br>
    <svg height="10" width="'.$_SESSION['w'].'">
    <line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />
    </svg>
    <br><br>
      <h1><center>Enter Date and Hour Block started to wear off.</center></h1>
      <br>
            <table style="width:35%; border-style:solid; margin-left:auto; margin-right:auto;">
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
      <br>';
                
                
echo'
    <br><br>
    <svg height="10" width="'.$_SESSION['w'].'">
    <line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />
    </svg>
    <br><br>
      <h1><center>Enter Date and Hour Block completely resolved.</center></h1>
      <br>
            <table style="width:35%; border-style:solid; margin-left:auto; margin-right:auto;">
                <tr>
                    <td style="width:33%; border:none; text-align:center"><b>Month</b></td><td style="width:33%; border:none; text-align:center">
                    <b>Day</b></td><td style="width:33%; border:none; text-align:center"><b>Hour</b></td>
                </tr>
                

                <tr>
                    <td style="width:33%; border:none; text-align:center">
                    
                    <select name="month2" id="month2" onchange="click3()">';
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
    var mnth = document.getElementById("month2").value;
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

    function click3(){
        var mnth = document.getElementById("month2").value;
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
                    <select name="hour2">';

                
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
      <br><br>
      <svg height="10" width="'.$_SESSION['w'].'">
      <line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />
      </svg>'; 
?>
   
<?php
    echo'
    <br><br>
    <h1><center>Have you been taking Tylenol (acetaminophen)? (Check One)</center></h1>
    <br>
     <table style=width:100%; margin-right:auto; margin-left:auto">
            <tr>

                <td style="border:none; width:25%">
                </td>
                
                <td style="border:none; width:25%;">

                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
		<label for="tylenoly">Yes</label>&nbsp;&nbsp;
		<input type="checkbox" id="tylenoly" name="tylenol" />
                </td>
                </tr>
                </table>
                
                </td>
                
                <td style="border:none; width:25%;">
                
                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
		<label for="tylenoln">No</label>&nbsp;&nbsp;
		<input type="checkbox" id="tylenoln" name="tylenol" />
                </td>
                </tr>
                </table>

                </td>
                
                <td style="border:none; width:25%">
                </td>
                
            </tr>
    </table><br><br>
    <svg height="10" width="'.$_SESSION['w'].'">
    <line x1="'.$_SESSION['w']*.15.'" y1="0" x2="'.$_SESSION['w']*.85.'" y2="0" style="stroke:#7db4dc;stroke-width:10" />
    </svg>';
?>
   
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
    
    
<?php

    echo'
    <br><br>
    <h1><center>Have you been taking Non-steroidal Anti-inflammatory Drugs (NSAIDS)? (Check One)</center></h1><br>
    <h2><center>(such as Motrin, Advil, ibuprofen, diclofenac, naproxen, Naprosyn, etodolac, ketorolac, Toradol)</center></h2>
    <br>
     <table style=width:100%; margin-right:auto; margin-left:auto">
            <tr>

                <td style="border:none; width:25%">
                </td>
                
                <td style="border:none; width:25%;">

                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
		<label for="nsaidsy">Yes</label>&nbsp;&nbsp;
		<input type="checkbox" id="nsaidsy" name="nsaids" />
                </td>
                </tr>
                </table>
                
                </td>
                
                <td style="border:none; width:25%;">
                
                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
		<label for="nsaidsn">No</label>&nbsp;&nbsp;
		<input type="checkbox" id="nsaidsn" name="nsaids" />
                </td>
                </tr>
                </table>

                </td>
                
                <td style="border:none; width:25%">
                </td>
                
            </tr>
    </table><br><br>
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
    </script>
    
    
    <?php

    echo'
    <br><br>
    <h1><center>Have you been taking any opioids? (Check One)</center></h1><br>
    <h2><center>(such as oxycodone, hydrocodone, codeine, Lortab, Lorcet, Oxycontin, Vicodin, Percocet)</center></h2>
    <br>
     <table style=width:100%; margin-right:auto; margin-left:auto">
            <tr>

                <td style="border:none; width:25%">
                </td>
                
                <td style="border:none; width:25%;">

                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
		<label for="narcsy">Yes</label>&nbsp;&nbsp;
		<input type="checkbox" id="narcsy" name="narcs" />
                </td>
                </tr>
                </table>
                
                </td>
                
                <td style="border:none; width:25%;">
                
                <table style="border-style:solid; margin-right:auto; margin-left:auto;">
                <tr>
                <td>
		<label for="narcsn">No</label>&nbsp;&nbsp;
		<input type="checkbox" id="narcsn" name="narcs" />
                </td>
                </tr>
                </table>

                </td>
                
                <td style="border:none; width:25%">
                </td>
                
            </tr>
    </table>';
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
echo'
    <br><br><br>
    <table align="center" width="100%" style="text-align:left; padding-left:50px; padding-top:15px; padding-bottom:15px; border:none">
            <tr>
                <td width="50%" align="center" style="border: none">
                     <input type="submit" name="BReg" value="SUBMIT" class="btn">
                </td>
            </tr>
      </table>
      </form>
      <br><br>
      </body>';
}
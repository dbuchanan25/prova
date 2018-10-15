<?php
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
    $_SESSION['ptblock1'] = false;  $_SESSION['ptblock2'] = false;
    $_SESSION['loginstring']='includes/connect.php';
    require_once ($_SESSION['loginstring']);
    
    $ph = $_SESSION['ptphone'];
    $phcomplete = "(".substr($ph,0,3).") ".substr($ph,3,3)."-".substr($ph,6);
    
?>
<head>
<title>Providence Anesthesiology</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
* {
    box-sizing: border-box;
}

body {
  margin: 0;
  font-family:"Segoe UI",Arial,sans-serif;
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


.control {
    font-family: arial;
    display: block;
    position: relative;
    padding-left: 40px;
    margin-bottom: 6px;
    padding-top: 6px;
    cursor: pointer;
    font-size: 20px;
}
    .control input {
        position: absolute;
        z-index: -1;
        opacity: 0;
    }
.control_indicator {
    position: absolute;
    top: 1px;
    left: 0;
    height: 30px;
    width: 30px;
    background: #e6e6e6;
    border: 2px solid #000000;
}
.control-radio .control_indicator {
    border-radius: undefined%;
}

.control:hover input ~ .control_indicator,
.control input:focus ~ .control_indicator {
    background: #cccccc;
}

.control input:checked ~ .control_indicator {
    background: #2aa1c0;
}
.control:hover input:not([disabled]):checked ~ .control_indicator,
.control input:checked:focus ~ .control_indicator {
    background: #0e6647d;
}
.control input:disabled ~ .control_indicator {
    background: #e6e6e6;
    opacity: 0.6;
    pointer-events: none;
}
.control_indicator:after {
    box-sizing: unset;
    content: '';
    position: absolute;
    display: none;
}
.control input:checked ~ .control_indicator:after {
    display: block;
}
.control-checkbox .control_indicator:after {
    left: 8px;
    top: 4px;
    width: 3px;
    height: 9px;
    border: solid #ffffff;
    border-width: 0 4px 4px 0;
    transform: rotate(45deg);
}
.control-checkbox input:disabled ~ .control_indicator:after {
    border-color: #7b7b7b;
}

input.btn {color:#000000; font: 100%"arial",helvetica,sans-serif; border-width: 3px; border-style: outset; background-color: #fafafa; padding:10px; align:center; font-size:100%;  width:30%;}
input.btn2 {color:#000000; font: 100%"arial",helvetica,sans-serif; border-width: 3px; border-style: outset; background-color: #fafafa; padding:10px; align:center; font-size:100%;  width:50%;}
input.btn:hover{ background-color: #7db4dc; -webkit-transition-duration: 1.0s;  transition-duration: 1.0s;}
input.btn2:hover{ background-color: #7db4dc; -webkit-transition-duration: 1.0s;  transition-duration: 1.0s;}
button.btn {color:#000000; font: 100%"arial",helvetica,sans-serif; border-width: 3px; border-style: outset; background-color: #fafafa; padding:10px; align:center; font-size:100%;  width:50%;}
button.btn:hover{ background-color: #7db4dc; -webkit-transition-duration: 1.0s;  transition-duration: 1.0s;}

</style>
</head>
<body>



<div class="header">
    <div class = "row">
        <div class = "columnt">
            <center><img src="includes/ProvidenceSmall.png" alt="PAA" /></center>
        </div>
        <div class = "columntr">
            <center>Patient Block Page</center>
        </div>
    </div>
</div>
    
    
    
<?php
if ($_SESSION['ptblock1'] && !$_SESSION['ptblock2'])
{
?>

<div class="topnav">
  <a href="eos.php">Evening of Surgery</a>
  <a href="ptblock1.php">Postoperative Day #1</a>
  <a href="blockInformation.php">Block Information</a>
  <a href="faq.php">FAQs</a>
  <a href="logout.php">Logout</a>
</div>
    
<?php
}
else if ($_SESSION['ptblock1'] && $_SESSION['ptblock2'])
{
?>
<div class="topnav">
  <a href="eos.php">Evening of Surgery</a>
  <a href="ptblock1.php">Postoperative Day #1</a>
  <a href="ptblock2.php">Postoperative Day #2</a>
  <a href="blockInformation.php">Block Information</a>
  <a href="faq.php">FAQs</a>
  <a href="logout.php">Logout</a>
</div>
<?php
}
else if (!($_SESSION['ptblock1'] && !$_SESSION['ptblock2']))
{
?>
<div class="topnav">
  <a href="eos.php">Evening of Surgery</a>
  <a href="blockInformation.php">Block Information</a>
  <a href="faq.php">FAQs</a>
  <a href="logout.php">Logout</a>
</div>
<?php
}

?>
    <br><br>
    <center><h1>Frequently Asked Questions</h1></center>
    <br><br>
    <br><br>
    </body>';
<?php
}


<?php
//////////////////////////////////////////////////////////////////////////////////////////////////                                                                             //
//VERSION 01_03                                                                                 //
//LAST REVISED 20190222                                                                         //
//Page enters data into the database which has been confirmed by a physician user about a       //
//patient's registration and block information.                                                 //
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
    require_once ($_SESSION['loginstring']);
    $yearnumber = date("Y");

    $SALT = "TheKeyFromHell";
    $hashname = md5( $SALT . md5( $_SESSION['lname'] . $SALT ) );

    if (isset($_SESSION['addi1']) && !isset($_SESSION['addi2']))
    {
        $addi1 = '';
        foreach($_SESSION['addi1'] as $a)
        {
            $addi1.=($a.' ');
        }

        $a = "INSERT INTO patients (fname, lname, phone,  orlocID, anesthesiologistID, surgeonID, cptID, block1ID, ".
                "drug1ID, vol1, addi1, method1, block2ID, drug2ID, vol2, method2, monthnumber, daynumber, hournumber, yearnumber, active) VALUES ('".
                $_SESSION['fname']."', '".$_SESSION['lname']."', '".$_SESSION['phone']."', ".$_SESSION['orlocID'].
                ", ".$_SESSION['anesthesiologistID'].", ".$_SESSION['surgeonID'].", ".$_SESSION['cptID'].", ".$_SESSION['block1ID'].
                ", ".$_SESSION['drug1ID'].", ".$_SESSION['volume1'].", '".$addi1."', '".$_SESSION['method1']."', ".$_SESSION['block2ID'].
                ", ".$_SESSION['drug2ID'].", ".$_SESSION['volume2'].", '".$_SESSION['method2']."', ".$_SESSION['monthnumber'].", ".$_SESSION['daynumber'].
                ", ".$_SESSION['hournumber'].", ".$yearnumber.", 1)";

        if (!mysqli_query($dbc,$a))
        {
          echo("Error description: " . mysqli_error($dbc));
        }
    }
    else if (isset($_SESSION['addi1']) && isset($_SESSION['addi2']))
    {
        $addi1 = '';
        $addi2 = '';
        foreach($_SESSION['addi1'] as $a)
        {
            $addi1.=($a.' ');
        }
        foreach($_SESSION['addi2'] as $b)
        {
            $addi2.=($b.' ');
        }
        $a = "INSERT INTO patients (fname, lname, phone, orlocID, anesthesiologistID, surgeonID, cptID, block1ID, ".
                "drug1ID, vol1, block2ID, drug2ID, vol2, addi1, addi2, method1, method2, monthnumber, daynumber, hournumber, yearnumber, active) VALUES ('".
                $_SESSION['fname']."', '".$_SESSION['lname']."', '".$_SESSION['phone']."', ', ".$_SESSION['orlocID'].
                ", ".$_SESSION['anesthesiologistID'].", ".$_SESSION['surgeonID'].", ".$_SESSION['cptID'].", ".$_SESSION['block1ID'].
                ", ".$_SESSION['drug1ID'].", ".$_SESSION['volume1'].", ".$_SESSION['block2ID'].", ".$_SESSION['drug2ID'].
                ", ".$_SESSION['volume2'].", '".$addi1."', '".$addi2."', '".$_SESSION['method1']."', '".$_SESSION['method2']."', ".$_SESSION['monthnumber'].
                ", ".$_SESSION['daynumber'].", ".$_SESSION['hournumber'].", ".$yearnumber.", 1)";

        if (!mysqli_query($dbc,$a))
        {
          echo("Error description: " . mysqli_error($dbc));
        }
    }
    else
    {
        $a = "INSERT INTO patients (fname, lname, phone, orlocID, anesthesiologistID, surgeonID, cptID, block1ID, ".
                "drug1ID, vol1, method1, block2ID, drug2ID, vol2, method2, monthnumber, daynumber, hournumber, yearnumber, active) VALUES ('".
                $_SESSION['fname']."', '".$_SESSION['lname']."', '".$_SESSION['phone']."',  ".$_SESSION['orlocID'].
                ", ".$_SESSION['anesthesiologistID'].", ".$_SESSION['surgeonID'].", ".$_SESSION['cptID'].", ".$_SESSION['block1ID'].
                ", ".$_SESSION['drug1ID'].", ".$_SESSION['volume1'].", '".$_SESSION['method2']."', ".$_SESSION['block2ID'].", ".$_SESSION['drug2ID'].
                ", ".$_SESSION['volume2'].", '".$_SESSION['method2']."', ".$_SESSION['monthnumber'].", ".$_SESSION['daynumber'].", ".$_SESSION['hournumber'].
                ", ".$yearnumber.", 1)";

        if (!mysqli_query($dbc,$a))
        {
          echo("Error description: " . mysqli_error($dbc));
        }
    }
    
    $un = strtolower($_SESSION['fname'][0]).strtolower($_SESSION['lname']);
    $paall =  $_SESSION['phone'];
    $pa = substr($paall,1,3).substr($paall,6,3).substr($paall,10,4);
    $pa = SHA1($pa);

    $z = "SELECT id FROM patients WHERE fname LIKE '".$_SESSION['fname']."' AND lname LIKE '".$_SESSION['lname']."' AND active=1";
    $w = mysqli_query($dbc, $z);
    $v = mysqli_fetch_array($w);
    $idp = $v[0];

    $c = "INSERT INTO patientusers (username, pass, patientsid, hashname) ".
         "VALUES ('".$un."', '".$pa."', ".$idp.", '".$hashname."')";
    $d = mysqli_query($dbc, $c);
    $_SESSION['ptid'] = $idp;
    
    
    $c1 = "";
    for ($x=0; $x<10; $x++)
    {
        $s1 = base_convert(rand ( 0 , 31 ),10,32);
        $c1.=$s1;
    }
    
    $c2 = "";
    for ($x=0; $x<10; $x++)
    {
        $s1 = base_convert(rand ( 0 , 31 ),10,32);
        $c2.=$s1;
    }
    
    $c3 = "";
    for ($x=0; $x<10; $x++)
    {
        $s1 = base_convert(rand ( 0 , 31 ),10,32);
        $c3.=$s1;
    }
    
    $c4 = "";
    for ($x=0; $x<10; $x++)
    {
        $s1 = base_convert(rand ( 0 , 31 ),10,32);
        $c4.=$s1;
    }
    
    $c5 = "";
    for ($x=0; $x<10; $x++)
    {
        $s1 = base_convert(rand ( 0 , 31 ),10,32);
        $c5.=$s1;
    }
    
    $cc = "INSERT INTO codes (patientsid, day1code, day2code, day3code, day4code, ptsatcode) ".
         "VALUES (".$_SESSION['ptid'].", '".$c1."', '".$c2."', '".$c3."', '".$c4."', '".$c5."')";

    $dd = mysqli_query($dbc, $cc);
    
    echo'
    <script>
        window.location="textconsent.php";
    </script>
    ';
}
?>
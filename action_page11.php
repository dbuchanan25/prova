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

        $a = "UPDATE patients SET fname='".$_SESSION['fname']."', lname='".$_SESSION['lname']."', phone='".$_SESSION['phone']."', ".
                "orlocID=".$_SESSION['orlocID'].", anesthesiologistID=".$_SESSION['anesthesiologistID'].", surgeonID=".$_SESSION['surgeonID'].
                ", cptID=".$_SESSION['cptID'].", block1ID=".$_SESSION['block1ID'].", drug1ID=".$_SESSION['drug1ID'].", vol1=".$_SESSION['volume1'].
                ", addi1='".$addi1."', method1='".$_SESSION['method1']."', block2ID=".$_SESSION['block2ID'].", drug2ID=".$_SESSION['drug2ID'].
                ", vol2=".$_SESSION['volume2'].", method2='".$_SESSION['method2']."', monthnumber=".$_SESSION['monthnumber'].", daynumber=".
                $_SESSION['daynumber'].", hournumber=".$_SESSION['hournumber'].", yearnumber=".$yearnumber.", active=".$_SESSION['active'].
                " WHERE id=".$_SESSION['currentptnum'];;

        
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
        
        $a = "UPDATE patients SET fname='".$_SESSION['fname']."', lname='".$_SESSION['lname']."', phone='".$_SESSION['phone']."', ".
                "orlocID=".$_SESSION['orlocID'].", anesthesiologistID=".$_SESSION['anesthesiologistID'].", surgeonID=".$_SESSION['surgeonID'].
                ", cptID=".$_SESSION['cptID'].", block1ID=".$_SESSION['block1ID'].", drug1ID=".$_SESSION['drug1ID'].", vol1=".$_SESSION['volume1'].
                ", addi1='".$addi1."', method1='".$_SESSION['method1']."', block2ID=".$_SESSION['block2ID'].", drug2ID=".$_SESSION['drug2ID'].
                ", vol2=".$_SESSION['volume2'].", addi2='".$addi2."', method2='".$_SESSION['method2']."', monthnumber=".$_SESSION['monthnumber'].", daynumber=".
                $_SESSION['daynumber'].", hournumber=".$_SESSION['hournumber'].", yearnumber=".$yearnumber.", active=".$_SESSION['active'].
                " WHERE id=".$_SESSION['currentptnum'];
        

        if (!mysqli_query($dbc,$a))
        {
          echo("Error description: " . mysqli_error($dbc));
        }
    }
    else
    {
        $a = "UPDATE patients SET fname='".$_SESSION['fname']."', lname='".$_SESSION['lname']."', phone='".$_SESSION['phone']."', ".
                "orlocID=".$_SESSION['orlocID'].", anesthesiologistID=".$_SESSION['anesthesiologistID'].", surgeonID=".$_SESSION['surgeonID'].
                ", cptID=".$_SESSION['cptID'].", block1ID=".$_SESSION['block1ID'].", drug1ID=".$_SESSION['drug1ID'].", vol1=".$_SESSION['volume1'].
                ", method1='".$_SESSION['method1']."', block2ID=".$_SESSION['block2ID'].", drug2ID=".$_SESSION['drug2ID'].
                ", vol2=".$_SESSION['volume2'].", method2='".$_SESSION['method2']."', monthnumber=".$_SESSION['monthnumber'].", daynumber=".
                $_SESSION['daynumber'].", hournumber=".$_SESSION['hournumber'].", yearnumber=".$yearnumber.", active=".$_SESSION['active'].
                " WHERE id=".$_SESSION['currentptnum'];;
        

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
    
    echo'
    <script>
        window.location="specificpatient.php";
    </script>
    ';
}
?>
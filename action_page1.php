<?php
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
</script>

<?php
    require_once ($_SESSION['loginstring']);
    $yearnumber = date("Y");
    
    echo("Pre-Salt<br>");

    $SALT = "TheKeyFromHell";
    $hashname = md5( $SALT . md5( $_SESSION['lname'] . $SALT ) );

    echo("Post-Salt");

    if (isset($_SESSION['addi1']) && !isset($_SESSION['addi2']))
    {
        $addi1 = '';
        foreach($_SESSION['addi1'] as $a)
        {
            $addi1.=($a.' ');
        }

        $a = "INSERT INTO patients (fname, lname, phone, email, orlocID, anesthesiologistID, surgeonID, cptID, block1ID, ".
                "drug1ID, vol1, addi1, block2ID, drug2ID, vol2, monthnumber, daynumber, hournumber, yearnumber, active) VALUES ('".
                $_SESSION['fname']."', '".$_SESSION['lname']."', '".$_SESSION['phone']."', '".$_SESSION['email']."', ".$_SESSION['orlocID'].
                ", ".$_SESSION['anesthesiologistID'].", ".$_SESSION['surgeonID'].", ".$_SESSION['cptID'].", ".$_SESSION['block1ID'].
                ", ".$_SESSION['drug1ID'].", ".$_SESSION['volume1'].", '".$addi1."', ".$_SESSION['block2ID'].
                ", ".$_SESSION['drug2ID'].", ".$_SESSION['volume2'].", ".$_SESSION['monthnumber'].", ".$_SESSION['daynumber'].
                ", ".$_SESSION['hournumber'].", ".$yearnumber.", 1)";
        $b = mysqli_query($dbc, $a);
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
        $a = "INSERT INTO patients (fname, lname, phone, email, orlocID, anesthesiologistID, surgeonID, cptID, block1ID, ".
                "drug1ID, vol1, block2ID, drug2ID, vol2, addi1, addi2, monthnumber, daynumber, hournumber, yearnumber, active) VALUES ('".
                $_SESSION['fname']."', '".$_SESSION['lname']."', '".$_SESSION['phone']."', '".$_SESSION['email']."', ".$_SESSION['orlocID'].
                ", ".$_SESSION['anesthesiologistID'].", ".$_SESSION['surgeonID'].", ".$_SESSION['cptID'].", ".$_SESSION['block1ID'].
                ", ".$_SESSION['drug1ID'].", ".$_SESSION['volume1'].", ".$_SESSION['block2ID'].", ".$_SESSION['drug2ID'].
                ", ".$_SESSION['volume2'].", '".$addi1."', '".$addi2."', ".$_SESSION['monthnumber'].
                ", ".$_SESSION['daynumber'].", ".$_SESSION['hournumber'].", ".$yearnumber.", 1)";
        $b = mysqli_query($dbc, $a);
    }
    else
    {
        $a = "INSERT INTO patients (fname, lname, phone, email, orlocID, anesthesiologistID, surgeonID, cptID, block1ID, ".
                "drug1ID, vol1, block2ID, drug2ID, vol2, monthnumber, daynumber, hournumber, yearnumber, active) VALUES ('".
                $_SESSION['fname']."', '".$_SESSION['lname']."', '".$_SESSION['phone']."', '".$_SESSION['email']."', ".$_SESSION['orlocID'].
                ", ".$_SESSION['anesthesiologistID'].", ".$_SESSION['surgeonID'].", ".$_SESSION['cptID'].", ".$_SESSION['block1ID'].
                ", ".$_SESSION['drug1ID'].", ".$_SESSION['volume1'].", ".$_SESSION['block2ID'].", ".$_SESSION['drug2ID'].
                ", ".$_SESSION['volume2'].", ".$_SESSION['monthnumber'].", ".$_SESSION['daynumber'].", ".$_SESSION['hournumber'].
                ", ".$yearnumber.", 1)";
        $b = mysqli_query($dbc, $a);
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
        window.location="textconsent.php";
    </script>
    ';
}
?>
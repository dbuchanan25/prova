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
    echo'
    <script>
        window.location="registration.php";
    </script>
    ';
}
?>
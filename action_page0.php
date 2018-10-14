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
//comment
    require_once ($_SESSION['loginstring']);
    echo '<link rel="stylesheet" href="styles/stylew3.css" type="text/css">';

    $winwidth = $_SESSION['w'];

    if (check_alpha_plus(trim(filter_input(INPUT_POST, "ptfirst"))) && check_alpha_plus(trim(filter_input(INPUT_POST,"ptlast"))))
    {
        if (check_num(trim(filter_input(INPUT_POST, "phoneac"))) && check_num(trim(filter_input(INPUT_POST, "phonepre"))) && check_num(trim(filter_input(INPUT_POST, "phonepost"))))
        {
            if (filter_var(trim(filter_input(INPUT_POST, "email"),FILTER_VALIDATE_EMAIL)))
            {
                if (check_num(trim(filter_input(INPUT_POST, "volume"))) && check_num(trim(filter_input(INPUT_POST, "volume2"))))
                {
                    if (($_POST['block1']>0 && $_POST['drug1']>0 && $_POST['block2']==0) || ($_POST['block1']>0 && $_POST['drug1']>0 && $_POST['block2']>0 && $_POST['drug2']>0))
                    {
                        $_SESSION['fname'] = trim(filter_input(INPUT_POST, "ptfirst"));
                        $_SESSION['lname'] = trim(filter_input(INPUT_POST, "ptlast"));
                        $_SESSION['phone'] = '('.trim(filter_input(INPUT_POST, "phoneac")).') '.trim(filter_input(INPUT_POST, "phonepre")).'-'.trim(filter_input(INPUT_POST, "phonepost"));
                        $_SESSION['email'] = trim(filter_input(INPUT_POST, "email"));

                        $loc = "SELECT location FROM locations WHERE id = ".$_POST['location'];
                        $locA = mysqli_query($dbc, $loc);
                        $locE = mysqli_fetch_array($locA);                
                        $_SESSION['orloc'] = $locE[0];
                        $_SESSION['orlocID'] = $_POST['location'];

                        $a = "SELECT first, last FROM users WHERE id = ".$_POST['anes'];
                        $aA = mysqli_query($dbc, $a);
                        $aE = mysqli_fetch_array($aA);
                        $_SESSION['anesthesiologist'] = strtoupper($aE[0]).' '.strtoupper($aE[1]);
                        $_SESSION['anesthesiologistID'] = $_POST['anes'];

                        $s = "SELECT surgeonFirst, surgeonLast FROM surgeons WHERE surgeonID = ".$_POST['surgeon'];
                        $sA = mysqli_query($dbc, $s);
                        $sE = mysqli_fetch_array($sA);
                        $_SESSION['surgeon'] = $sE[0].' '.$sE[1];
                        $_SESSION['surgeonID'] = $_POST['surgeon'];

                        $c = "SELECT asaCode, cptDescriptor FROM asa WHERE id = ".$_POST['cpt'];
                        $cA = mysqli_query($dbc, $c);
                        $cE = mysqli_fetch_array($cA);               
                        $_SESSION['cpt'] = $cE[0].' - '.$cE[1];
                        $_SESSION['cptID'] = $_POST['cpt'];


                        $b1 = "SELECT block FROM blocks WHERE id = ".$_POST['block1'];
                        $b1A = mysqli_query($dbc, $b1);
                        $b1E = mysqli_fetch_array($b1A);
                        $_SESSION['block1ID'] = $_POST['block1'];
                        $_SESSION['block1'] = $b1E[0];

                        $d1 = "SELECT med FROM drug WHERE id = ".$_POST['drug1'];
                        $d1A = mysqli_query($dbc, $d1);
                        $d1E = mysqli_fetch_array($d1A);
                        $_SESSION['drug1ID'] = $_POST['drug1'];
                        $_SESSION['drug1'] = $d1E[0];

                        $_SESSION['volume1'] = trim(filter_input(INPUT_POST, "volume"));
                        if (isset($_POST['addi1']))
                            $_SESSION['addi1'] = $_POST['addi1'];

                        $b2 = "SELECT block FROM blocks WHERE id = ".$_POST['block2'];
                        $b2A = mysqli_query($dbc, $b2);
                        $b2E = mysqli_fetch_array($b2A);
                        $_SESSION['block2ID'] = $_POST['block2'];
                        $_SESSION['block2'] = $b2E[0];

                        $d2 = "SELECT med FROM drug WHERE id = ".$_POST['drug2'];
                        $d2A = mysqli_query($dbc, $d2);
                        $d2E = mysqli_fetch_array($d2A);
                        $_SESSION['drug2ID'] = $_POST['drug2'];
                        $_SESSION['drug2'] = $d2E[0];


                        $_SESSION['volume2'] = trim(filter_input(INPUT_POST, "volume2"));
                        if (isset($_POST['addi2']))
                            $_SESSION['addi2'] = $_POST['addi2'];
                        
                        $_SESSION['monthnumber'] = $_POST['month'];
                        $_SESSION['daynumber'] = $_POST['day'];
                        $_SESSION['hournumber'] = $_POST['hour'];

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
                          <div class="w3-padding w3-center"><h1>Block Patient Registration Confirmation</h1></div>
                        </div>';



                        if ($_SESSION['w'] > 925)
                        {
                            echo'
                                <br>
                                <table style="border-style:solid; width:60%; margin-left:auto; margin-right:auto;">';
                        }
                        else
                        {
                            echo'
                                <br>
                                <table style="border-style:solid; width:100%; margin-left:auto; margin-right:auto;">';
                        }
                        echo'
                            <tr>                                      
                                <td style="width:40%; border:none; text-align:right; padding:10px; font-size:24px">
                                <b>Patient Name:</b>
                                <td style="width:60%; padding:10px; font-size:24px">'.
                                    $_SESSION['fname'].' '.$_SESSION['lname'].'
                                </td>
                            </tr>
                            <tr>
                                <td style="width:40%; border:none; text-align:right; padding:10px; font-size:24px">
                                <b>Phone:</b>
                                </td>
                                <td style="width:60%; padding:10px; font-size:24px">'.
                                    $_SESSION['phone'].'
                                </td>
                            </tr>
                            <tr>
                                <td style="width:40%; border:none; text-align:right; padding:10px; font-size:24px">
                                    <b>Email Address:</b>
                                </td>
                                <td style="width:60%; padding:10px; font-size:24px">'
                                    .$_SESSION['email'].'
                                </td>
                            </tr>
                        </table><br><br>';

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
                            <td style="width:60%; border:none; align:center; padding:10px">'.                    
                                $_SESSION['orloc'].'
                            </td>
                         </tr>
                         <tr>
                            <td style="width:40%; border:none; text-align:right; padding:10px;">
                                <b>Block Anesthesiologist:</b>
                            </td>

                            <td style="border:none; width:60%; padding:10px">'.
                                $_SESSION['anesthesiologist'].'
                            </td>
                        </tr>
                        </tr>
                            <td style="width:40%; border:none; text-align:right">
                                <b>Surgeon:</b>
                            </td>

                            <td style="border:none; width:60%; padding:10px">'.
                                $_SESSION['surgeon'].'
                            </td>
                         </tr>
                         <tr>            
                            <td style="width:40%; border:none; text-align:right">
                                <b>CPT:</b>
                            </td>

                            <td style="border:none; width:60%; padding:10px">'.
                                $_SESSION['cpt'].
                            '</td>
                        </tr>
                    </table>
                    <br>

                    <center>
                    <h1 class="h1log" style="text-align:left color:#000000">Primary Block</h1>';

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
                                <td style="width:40%; border:none; text-align:right; padding:10px">
                                    <b>Type of Block:</b>
                                </td>

                                <td style="border:none; width:60%; padding:10px">'.
                                    $_SESSION['block1'].'
                                </td>
                            </tr>
                            <tr>            
                                <td style="width:40%; border:none; text-align:right; padding:10px;">
                                    <b>Local:</b>
                                </td>

                                <td style="border:none; width:60%; padding:10px">'.
                                    $_SESSION['drug1'].'                
                                </td>
                            </tr>
                            <tr>            
                                <td style="width:40%; border:none; text-align:right; padding:10px">
                                    <b>Volume (ml):</b>
                                </td>

                                <td style="width:60%; padding:10px">'.
                                    $_SESSION['volume1'].'
                                </td>
                            </tr>
                            <tr>
                                <td style="width:40%; border:none; text-align:right; padding:10px;">
                                        <b>Additives:</b>
                                </td>';

                            if (isset($_SESSION['addi1']))
                            {
                               foreach($_SESSION['addi1'] as $a1)
                               {
                                   switch($a1)
                                   {
                                        case "epi100":
                                            $a11 = "Epinephrine 1:100,000";
                                            break;
                                        case "epi200":
                                            $a11 = "Epinephrine 1:200,000";
                                            break;
                                        case "clonidine":
                                            $a11 = "Clonidine";
                                            break;
                                        case "dex":
                                            $a11 = "Dexmedetomidine";
                                            break;
                                        case "decadron":
                                            $a11 = "Decadron";
                                            break;
                                   }
                                   echo '<td style="width:60%; padding:10px">'.$a11.'</td></tr><tr><td style="width:40%; padding:10px"></td>';
                               }
                            }
                            else
                            {
                                echo '<td style="width:60%; padding:10px">None</td>';
                            }
                        echo'
                                </tr>            
                            </table>
                            <br>
                            <br>';

                        if (isset($_SESSION['block2']))
                        {            
                        echo'
                        <center>
                            <h1 class="h1log" style="text-align:left color:#000000">Secondary Block</h1>';

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
                                    <td style="width:40%; border:none; text-align:right; padding:10px">
                                        <b>Type of Block:</b>
                                    </td>

                                    <td style="border:none; width:60%; padding:10px">'.
                                        $_SESSION['block2'].'
                                    </td>
                                </tr>
                                <tr>            
                                    <td style="width:40%; border:none; text-align:right; padding:10px;">
                                        <b>Local:</b>
                                    </td>

                                    <td style="border:none; width:60%; padding:10px">'.
                                        $_SESSION['drug2'].'                
                                    </td>
                                </tr>
                                <tr>            
                                    <td style="width:40%; border:none; text-align:right; padding:10px">
                                        <b>Volume (ml):</b>
                                    </td>

                                    <td style="width:60%; padding:10px">'.
                                        $_SESSION['volume2'].'
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width:40%; border:none; text-align:right; padding:10px;">
                                            <b>Additives:</b>
                                    </td>';

                                if (isset($_SESSION['addi2']))
                                {
                                   foreach($_SESSION['addi2'] as $a2)
                                   {
                                       switch($a2)
                                       {
                                            case "epi100":
                                                $a22 = "Epinephrine 1:100,000";
                                                break;
                                            case "epi200":
                                                $a22 = "Epinephrine 1:200,000";
                                                break;
                                            case "clonidine":
                                                $a22 = "Clonidine";
                                                break;
                                            case "dex":
                                                $a22 = "Dexmedetomidine";
                                                break;
                                            case "decadron":
                                                $a22 = "Decadron";
                                                break;
                                       }
                                       echo '<td style="width:60%; padding:10px">'.$a22.'</td></tr><tr><td style="width:40%; padding:10px"></td>';
                                   }
                                }
                                else
                                {
                                    echo '<td style="width:60%; padding:10px">None</td>';
                                }
                        echo'
                                </tr>            
                            </table>';    
                        }
                        else
                        {
                            echo'
                            <center>
                            <h1 class="h1log" style="text-align:left color:#000000">No Secondary Block</h1><br>';
                        }
                    }
                    else
                    {
                        ?>
                        <script>
                            var answer = confirm ("You entered invalid block(s)/medication(s).");
                            if (answer)
                            {
                                window.location="registration.php";
                            }
                        </script>
                        <?php
                    }
                }
                else
                {
                    ?>
                    <script>
                        var answer = confirm ("You entered an invalid email address.");
                        if (answer)
                        {
                            window.location="registration.php";
                        }
                    </script>
                <?php
                }
            }            
        }
        else
        {
        ?>
            <script>
                var answer = confirm ("You entered an invalid phone number.");
                if (answer)
                {
                    window.location="registration.php";
                }
            </script>
        <?php
        }
    }
    else
    {
    ?>
        <script>
            var answer = confirm ("You entered an invalid name.");
            if (answer)
            {
                window.location="registration.php";
            }
        </script>
    <?php
    }   
        echo'
        <center>
            <h1 class="h1log" style="text-align:left color:#000000">Date & Time</h1>';
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
                <td style="width:33%; border:none; text-align:center; padding:10px">
                    <b>Month</b>
                </td>
                <td style="width:33%; border:none; text-align:center; padding:10px">
                    <b>Day</b>
                </td>
                <td style="width:33%; border:none; text-align:center; padding:10px">
                    <b>Hour</b>
                </td>
            </tr>
            <tr>            
                <td style="width:33%; border:none; text-align:center; padding:10px;">'.
                    $_SESSION['monthnumber'].'
                </td>
                <td style="width:33%; border:none; text-align:center; padding:10px;">'.
                    $_SESSION['daynumber'].'
                <td style="width:33%; border:none; text-align:center; padding:10px;">'.
                    $_SESSION['hournumber'].'
                </td>
                </td>
            </tr>
            </table>
            <br>
            <table style="width:60%">
                <tr>
                    <td align="center">
                    <button class="btn" id="ce" onclick="ce()">CONFIRM ENTRY</button>
                    </td>
                    <td align="center">
                    <button class="btn" id="dso" onclick="godso()">DISCARD/START OVER</button>
                    </td>
                </tr>
            </table><br><br>';
}


function check_alpha_plus($str)
{
    if ($str == NULL)
        return false;
    for ($x=0; $x<strlen($str); $x++)
    {
        $ord = ord($str[$x]);
        if ($ord>64 && $ord<91)
        {}
        else if ($ord>96 && $ord<123)
        {}
        else if ($ord == 45)
        {}
        else
        {
            return false;
        }
    }
    return true;
}

function check_num($str)
{
    if ($str == NULL)
        return false;
    for ($x=0; $x<strlen($str); $x++)
    {
        $ord = ord($str[$x]);
        if ($ord>=48 && $ord<=57)
        {}
        else
        {
            return false;
        }
        return true;
    }
}
?>
        
        
<script>
    function godso() 
    {
        window.location="registration.php";
    }
    function ce()
    {
        window.location="action_page1.php";
    }
</script>
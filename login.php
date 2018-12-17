<?php 
session_start();

// Check if user login cookie is set and if so, send to correct url :
if (isset($_COOKIE['authentication'])) {

    // Connect to the Database :
    $_SESSION['loginstring']='includes/connect.php';
    require_once ('includes/login_functions.inc.php');
    require_once ($_SESSION['loginstring']);

    // Open the cookie info on the Users computer :
    list($identifier, $token) = explode(':', $_COOKIE['authentication']);

    $token = mysqli_real_escape_string($dbc, $token);

    $qp = mysqli_query($dbc, "SELECT a.username, a.pass, a.hashname, a.keychain, a.lastlogin ".
        "FROM patientusers AS a ".
        "INNER JOIN patients AS b ".
        "ON a.patientsid = b.id ".
        "WHERE a.hashname ='$identifier' AND a.keychain = '$token' AND a.lastlogin > CURDATE()");
    if(!$qp) {
        error_log(mysqli_error($dbc));
    }

    if(mysqli_num_rows($qp) > 0) {

        // User is a patient :
        $keyval = (string)md5(uniqid(rand(), true));
        $keya = mysqli_real_escape_string($dbc, $keyval);

        if (!mysqli_query($dbc, "UPDATE patientusers SET keychain = '$keya' WHERE hashname = '$identifier';")) {
            error_log("Failed in the update: ".mysqli_error($dbc));
        }

        $row = mysqli_fetch_array ($qp, MYSQLI_ASSOC);
        $_SESSION['ptphone'] = $ph;
        $_SESSION['username'] = $row['username'];
        $_SESSION['pass'] = $row['pass'];

        // Update the cookie on the users side :
        setcookie('authentication', "$identifier:$keyval", $row['lastlogin']);

        mysqli_close($dbc);

        // Reroute as necessary :
        if (isset($_SESSION['pt1entry']) && $_SESSION['pt1entry']==true)
        {
            unset($_SESSION['pt1entry']);
            header("Location: pt1entry.php");
        }
        else if (isset($_SESSION['pt2entry']) && $_SESSION['pt2entry']==true)
        {
            unset($_SESSION['pt2entry']);
            header("Location: pt2entry.php");
        }
        else
        {
            header("Location: blockInformation.php");
        }
        die();

    } else {     
        //User is a Dr? :
        $qd = mysqli_query($dbc, "SELECT * FROM users WHERE hashname LIKE '$identifier' AND keychain LIKE '$token' AND (lastlogin > CURDATE())");
        
        if(mysqli_num_rows($qd) > 0) {
            $row = mysqli_fetch_array($qd, MYSQLI_ASSOC);
            error_log("username : ".$row['username']);
            $_SESSION['username'] = $row['username'];
            $_SESSION['pass'] = $row['pass'];

            // Update the database and cookies :
            $keyval = (string)md5(uniqid(rand(), true));
            $keya = mysqli_real_escape_string($dbc, $keyval);

            if (!mysqli_query($dbc, "UPDATE users SET keychain = '$keya' WHERE hashname = '$identifier';")) {
                error_log("Failed in the update: ".mysqli_error($dbc));
            }

            setcookie('authentication', "$identifier:$keyval", $row['lastlogin']);

            // Reroute :
            header("Location: registration.php");
            die();
        } else {
            error_log("MySQL Query :"."SELECT * FROM users WHERE hashname LIKE '$identifier' AND keychain LIKE '$token' AND (lastlogin > CURDATE())");
            error_log("MySQL Error : ".mysqli_error($dbc)." # of Rows : ".mysqli_num_rows($qd));
        }
    }   
}

//////////////////////////////////////////////////////////////////////////////////////////////////
//PATIENT INTERFACE                                                                             //
//VERSION 01_01                                                                                 //
//LAST REVISED 20180811                                                                         //
//////////////////////////////////////////////////////////////////////////////////////////////////
echo '<body>';
if (isset($_GET["w"]) || isset($_SESSION['w']))
{
    if (!isset($_SESSION['w']))
    {
        $_SESSION['w'] = $_GET["w"];
    }
    
    include ('includes/login_page.inc.php');
?>
    <script type="text/javascript">       
    function doOnOrientationChange()
    {
        window.location.assign("resetwidth.php");
    }
    window.addEventListener('orientationchange', doOnOrientationChange);
    </script>
  
<?php

    // Otherwise present the Login Page :
    if (isset($_POST['submitted']))
    {
        error_log("Submit Button Called.");

        $_SESSION['loginstring']='includes/connect.php';

        require_once ('includes/login_functions.inc.php');

        require_once ($_SESSION['loginstring']);

        list($check, $data) = check_login($dbc, $_POST['username'], $_POST['pass']);

        if ($check)
        {
            $_SESSION['username'] = $data['username'];
            $_SESSION['pass'] = $data['pass'];
            $identifier = (string)$data['hashname'];

            if (empty($identifier)) {
                $SALT = "TheKeyFromHell";
                error_log("id was empty");
                $identifier = md5( $SALT . md5( $_SESSION['username'] . $SALT ) );
            }

            $keyval = (string)md5(uniqid(rand(), true));
            $timeout = time() + (3 * 24 * 60 * 60); // Timeout set for 3 days later
            setcookie('authentication', "$identifier:$keyval", $timeout);

            $date = new DateTime(); //Defaults to current day
            $date->add(new DateInterval('P3D')); // P1D means a period of 1 day
            $expiry = $date->format('Y-m-d');
            
            if (isset($_SESSION['ptphone']) && filterphone($_SESSION['ptphone']))
            {
                if (!mysqli_query($dbc, "UPDATE patientusers SET hashname = '".$identifier."', keychain = '".$keyval."', lastlogin = '$expiry' WHERE username = '".$data['username']."';")) {
                    error_log(mysqli_error($dbc));
                }
                mysqli_close($dbc);

                if (isset($_SESSION['pt1entry']) && $_SESSION['pt1entry']==true)
                {
                    unset($_SESSION['pt1entry']);
                    ?>
                        <script type="text/javascript">
                            window.location = "pt1entry.php";
                        </script>
                    <?php
                }
                else if (isset($_SESSION['pt2entry']) && $_SESSION['pt2entry']==true)
                {
                    unset($_SESSION['pt2entry']);
                    ?>
                        <script type="text/javascript">
                            window.location = "pt2entry.php";
                        </script>
                    <?php
                }
                else
                {
<<<<<<< HEAD
                    ?>
                    <script type="text/javascript">
                        window.location = "blockInformation.php";
                    </script>
                    <?php
=======
                    header("Location: blockInformation.php");
>>>>>>> AlexDBApp
                }
                die();
            }
            else
            {
<<<<<<< HEAD
                ?>
                <script type="text/javascript">
                    window.location = "registration.php";
                </script>
                <?php
=======
                if (!mysqli_query($dbc, "UPDATE users SET hashname = '".$identifier."', keychain = '".$keyval."', lastlogin = '$expiry' WHERE username = '".$data['username']."';")) {
                    error_log(mysqli_error($dbc));
                }
                mysqli_close($dbc);
                header("Location: registration.php");
                die();
>>>>>>> AlexDBApp
            }
        }
        else
        {
          $errors = $data;
        }
    }
}
else
{ 
    unset($_SESSION['ptphone']);
    echo' <table id="dale" style="width:100%;"></table>';
    ?>
    <script type="text/javascript">
    var elmnt = document.getElementById("dale");
    
    var txt1 = elmnt.clientWidth; 
    var txt2 = window.innerWidth;
    var txt3 = window.screen.width;
    
    var txt = Math.min(txt1, txt2, txt3);
    
    
 
    var loc = window.location.href;
    window.location = loc + "?w=" + txt + "&h=" + window.screen.height;
    </script>
    <?php
}


echo '</body>';

?>
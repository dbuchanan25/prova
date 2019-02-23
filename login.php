<?php 
session_start();

//////////////////////////////////////////////////////////////////////////////////////////////////
//PATIENT INTERFACE                                                                             //
//VERSION 01_01                                                                                 //
//LAST REVISED 20190212                                                                         //
//SERVES AS THE LOGIN PAGE FOR PHYSICIANS AND PATIENTS                                          //
//STORES 2 COOKIES, IF ALLOWED, FOR AUTOMATIC LOGIN                                             //
//////////////////////////////////////////////////////////////////////////////////////////////////


echo '<link rel="manifest" href="/manifest.json">';
echo '<meta name="apple-mobile-web-app-capable" content="yes">';
echo '<meta name="apple-mobile-web-app-status-bar-style" content="default">';
echo '<link rel="apple-touch-icon" href="fi192.png">';
?>


<script type="text/javascript">
    if ('serviceWorker' in navigator) 
    {
        console.log("Service Worker in navigator.");
        window.addEventListener('load', function() 
        {
            navigator.serviceWorker.register('/serviceworker.js').then(function(registration) 
            {
                // Registration was successful
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            }, function(err) 
            {
              // registration failed :(
              console.log('ServiceWorker registration failed: ', err);
            });
        });
    }

    let defferedPrompt;
    var btnAdd = document.createElement("BUTTON");

    window.addEventListener('beforeinstallprompt', (e) => 
    {
      // Prevent Chrome 67 and earlier from automatically showing the prompt
      e.preventDefault();
      // Stash the event so it can be triggered later.
      deferredPrompt = e;
      // Update UI notify the user they can add to home screen
      btnAdd.style.display = 'block';
    });

    btnAdd.addEventListener('click', (e) => 
    {
      // hide our user interface that shows our A2HS button
      btnAdd.style.display = 'none';
      // Show the prompt
      deferredPrompt.prompt();
      // Wait for the user to respond to the prompt
      deferredPrompt.userChoice.then((choiceResult) => 
        {
          if (choiceResult.outcome === 'accepted') 
          {
            console.log('User accepted the A2HS prompt');
          } 
          else 
          {
            console.log('User dismissed the A2HS prompt');
          }
          deferredPrompt = null;
        });
    });

    window.addEventListener('appinstalled', (evt) => {
      app.logEvent('a2hs', 'installed');
    });

    console.log("Reached SW Location Login.");
    
    function doOnOrientationChange()
    {
        window.location.assign("resetwidth.php");
    }
    window.addEventListener('orientationchange', doOnOrientationChange);
</script>


<?php
$_SESSION['loginstring']='includes/connect.php';
require_once ('includes/login_functions.inc.php');
require_once ($_SESSION['loginstring']);

if (isset($_GET["w"]) && !isset($_SESSION['w']))
{
    $_SESSION['w'] = $_GET["w"];
}

// Check if user login cookie is set and if so, send to correct url:
if (isset($_COOKIE['provmun']) && isset($_COOKIE['provmkey'])) 
{
    // Open the cookie info on the Users computer :
    //list($identifier, $token) = explode(':', $_COOKIE['authentication']);
    $identifier = $_COOKIE['provmun'];
    $token = $_COOKIE['provmkey'];

    $token = mysqli_real_escape_string($dbc, $token);

    $qp = mysqli_query($dbc, "SELECT a.username, a.pass, a.hashname, a.keychain, a.lastlogin ".
        "FROM patientusers AS a ".
        "INNER JOIN patients AS b ".
        "ON a.patientsid = b.id ".
        "WHERE a.hashname ='$identifier' AND a.keychain = '$token'");
    

    if(mysqli_num_rows($qp) > 0) 
    {
        // User is a patient :
        $keyval = (string)md5(uniqid(rand(), true));
        $keya = mysqli_real_escape_string($dbc, $keyval);

        if (!mysqli_query($dbc, "UPDATE patientusers SET keychain = '$keya' WHERE hashname = '$identifier'")) {
            error_log("Failed in the update: ".mysqli_error($dbc));
        }

        $row = mysqli_fetch_array ($qp, MYSQLI_ASSOC);
        //$_SESSION['ptphone'] = $ph;
        $_SESSION['username'] = $row['username'];
        $_SESSION['pass'] = $row['pass'];

        // Update the cookie on the users side :
        setcookie('provmkey', $keya, time() + 3*(86400 * 30), '/');
        
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
    } 
    else 
    {     
        //User is a Dr? :
        $qd = mysqli_query($dbc, "SELECT * FROM users WHERE hashname LIKE '$identifier' AND keychain LIKE '$token'");
        
        if(mysqli_num_rows($qd) > 0) 
        {
            $row = mysqli_fetch_array($qd, MYSQLI_ASSOC);
            //error_log("username : ".$row['username']);
            $_SESSION['username'] = $row['username'];
            $_SESSION['pass'] = $row['pass'];

            // Update the database and cookies :
            $keyval = (string)md5(uniqid(rand(), true));
            $keya = mysqli_real_escape_string($dbc, $keyval);

            if (!mysqli_query($dbc, "UPDATE users SET keychain = '$keya' WHERE hashname = '$identifier'")) 
            {
                error_log("Failed in the update: ".mysqli_error($dbc));
            }
           
            setcookie('provmkey', $keya, time() + 3*(86400 * 30), '/');

            // Reroute :
            header("Location: registration.php");
            die();
        } 
    }   
}
//End of COOKIE LOGIN and forwarding
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//TRY TO SET LOGIN COOKIE   
else if (isset($_POST['submitted']))
{
    list($check, $data) = check_login($dbc, $_POST['username'], $_POST['pass']);
    $_SESSION['username'] = $data['username'];
    $_SESSION['pass'] = $data['pass'];
    $identifier = (string)$data['hashname'];
      
    if ($check)
    {
        if (isset($_SESSION['ptphone']) && filterphone($_SESSION['ptphone']))
        {
            $SALT = "TheKeyFromHell";
            $identifier = md5( $SALT . md5( $_SESSION['username'] . $SALT ) );
            $keyval = (string)md5(uniqid(rand(), true));
            $keya = mysqli_real_escape_string($dbc, $keyval);
            
            if (!mysqli_query($dbc, "UPDATE patientusers SET hashname = '".$identifier."', keychain = '".$keya.
                    "', lastlogin = '$expiry' WHERE username = '".$data['username']."';")) 
            {
                error_log(mysqli_error($dbc));
            }
            mysqli_close($dbc);
        
            
            $timeout = time() + (3 * 24 * 60 * 60); // Timeout set for 3 days later

            setcookie('provmun', $identifier, $timeout, '/');
            setcookie('provmkey', $keya, $timeout, '/');
            
            
            
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
                        console.log("Login Successful.");
                        window.location = "pt2entry.php";
                    </script>
                <?php
            }
            else
            {
                ?>
                    <script type="text/javascript">
                        console.log("Session Issue.");
                        window.location = "blockInformation.php";
                    </script>
                <?php
            }
            die();
        }
        else
        {
            $SALT = "TheKeyFromHell";
            $identifier = md5( $SALT . md5( $_SESSION['username'] . $SALT ) );

            $keyval = (string)md5(uniqid(rand(), true));
            $keya = mysqli_real_escape_string($dbc, $keyval);
            
            if (!mysqli_query($dbc, "UPDATE users SET hashname = '".$identifier."', keychain = '".$keya.
                    "' WHERE username = '".$data['username']."'")) 
            {
                error_log(mysqli_error($dbc));
            }
            mysqli_close($dbc);
            
            
            setcookie('provmun', $identifier, time() + (10 * 365 * 24 * 60 * 60), '/');
            setcookie('provmkey', $keya, time() + (10 * 365 * 24 * 60 * 60), '/');
            
            if (isset($_COOKIE['provmun']))
                echo 'Cookie set';
            ?>
                    <script type="text/javascript">
                        console.log("Login Works");
                        window.location = "registration.php";
                    </script>
                <?php
            die();
        }
    }
}


else if (isset($_SESSION['w']))
{ 
    unset($_SESSION['ptphone']);
    include ('includes/login_page.inc.php');
}

else
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
    </script>
    <?php   
}
?>
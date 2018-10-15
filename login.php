<?php 
session_start();

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
    if (isset($_POST['submitted']))
    {
        $_SESSION['loginstring']='includes/connect.php';

        require_once ('includes/login_functions.inc.php');

        require_once ($_SESSION['loginstring']);

        list($check, $data) = check_login($dbc, $_POST['username'], $_POST['pass']);

        if ($check)
        {
            $_SESSION['username'] = $data['username'];
            $_SESSION['pass'] = $data['pass'];
            mysqli_close($dbc);

            if (isset($_SESSION['ptphone']) && filterphone($_SESSION['ptphone']))
            {
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
                    header("Location: blockinformation.php");
                }
                die();
            }
            else
            {
                header("Location: registration.php");
                die();
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
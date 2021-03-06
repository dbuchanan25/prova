<?php
if (!isset($_SESSION)) 
{ 
    session_start();
}

include ('includes/header.php');
require_once "includes/Mobile_Detect.php";

$page_title = 'Login';
$detect = new Mobile_Detect;

echo'
<link rel="stylesheet" href="styles/style.css" type="text/css">
';

if (!empty($errors))
{
   echo '<h1>Error!</h1> <p class="error">The following error(s) occurred:<br />';
   foreach ($errors as $msg)
   {
       echo " - $msg<br />\n";
   }
   echo '</p><br><br.<p>Please try again.</p><br><br>';
}
else
{
    if ( $detect->isMobile() ) {
        echo '
        <div id="note" style="background-color:#6b9cff"> <a id="applink"> Download App </a> <a id="close"> [Exit] </a> </div>
        <script>

            close = document.getElementById("close");
            close.addEventListener(\'click\', function() {
              note = document.getElementById("note");
              note.style.display = \'none\';
            }, false);

            downlink = document.getElementById("applink");
            downlink.addEventListener(\'click\', function() {';
                if( $detect->isiOS() ){
                    echo'
                    window.location.href=\'\';
                    ';
                }
                 
                if( $detect->isAndroidOS() ){
                    echo'
                    window.location.href=\'https://play.google.com/store/apps/details?id=com.ProvidenceMed.adhd.hello_world\';
                    '; 
                }
                echo'
                note = document.getElementById("note");
                note.style.display = \'none\';
            }, false);
        </script>';
    } else {
        echo '
        <div id="note" style="background-color:#6b9cff"> Try Our Mobile App! <a id="close"> [Exit] </a> </div>
        <script>

            close = document.getElementById("close");
            close.addEventListener(\'click\', function() {
              note = document.getElementById("note");
              note.style.display = \'none\';
            }, false);
        </script>';
    }
    echo'
    <body style="background-color:dddddd">
    
    <br><br>
    <h1 class="h1log" style="text-align:center; color:#000000">Login Page</h1><br><br>

    <form action="login.php" method="post">';
    
    echo'
    <table width=100% align=center>
    <tr>
        <td width=25%></td>
        <td width = 25% align=center height=50px style="background-color:#EEEEEE; font-size:150%">
            UserName: 
        </td>
        <td width = 25% align=center style="background-color:#EEEEEE;">';

    if ($_SESSION['w']>500)
    {
        echo'<input type="text" name="username" size="20"  maxlength="20" autofocus style="height:30; font-size:20px;" />';
    }
    else
    {
        echo'<input type="text" name="username" size="20"  maxlength="20" autofocus style="height:'.intval($_SESSION['w']*.06).'; font-size:18px;" />';
    }
    echo'
        </td>
        <td width=25%></td>
    </tr>
    <tr>
        <td width=25%></td>
        <td width=25% align=center height=50px style="background-color:#EEEEEE; font-size:150%">
            Password: 
        </td>
        <td width=25% align=center style=background-color:#EEEEEE;>';
    if ($_SESSION['w']>500)
    {
        echo'<input type="password" name="pass" size="20" maxlength="25" style="height:30px; font-size:20px;" />';
    }
    else
    {
        echo'<input type="password" name="pass" size="20" maxlength="25" style="height:'.intval($_SESSION['w']*.06).'; font-size:18px;" />';
    }
    echo'
        </td>
        <td width=25%></td>
    </tr>
    </table>

    <br>
    <br>
    <br>


    <center>';
    
    if ($_SESSION['w']>500)
    {
        echo'<input type="submit" name="submit" value="Submit" class="btn" style="height:40px; width:200px" />';
    }
    else
    {
        echo'<input type="submit" name="submit" value="Submit" class="btn" style="height:'.intval($_SESSION['w']*.08).'px; width:'.intval($_SESSION['w']*.4).'px" />';
    }
    echo'
    <input type="hidden" name="submitted" value="TRUE" />
    <br>
    <br>
    <table>
        <tr>
            <td>(User name for patients is their last name, password consist of digits only)</td>
        </tr>
    </table>

    </form>
    <br>
    <br>
    </body>';
}
?>

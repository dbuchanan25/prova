<?php
//////////////////////////////////////////////////////////////////////////////////////////////////
//VERSION 01_03                                                                                 //
//LAST REVISED 20190222                                                                         //
//Patient entry page for day 3.  This page will log the patient into the entry page             //
//It forwards information to the page "pt1entry.php"                                            //
//////////////////////////////////////////////////////////////////////////////////////////////////
session_start();

if (!isset($_SESSION['username']))
{
    if (isset($_GET['p']))
    {
        $_SESSION['loginstring']='includes/connect.php';
        require_once ($_SESSION['loginstring']);
        $day1code = $_GET['p'];
        $getPIDQ = "SELECT patientsid FROM codes WHERE day3code LIKE '".$day3code."' AND day3used = 0";
        $getPIDA = mysqli_query($dbc, $getPIDQ);
        
        if (mysqli_num_rows($getPIDA) == 1)
        {
            $getPIDR = mysqli_fetch_array($getPIDA);
            $_SESSION['currentptnum'] = $getPIDR[0];
            
            $getLIQ = "SELECT a.username, b.phone FROM patientusers AS a INNER JOIN patients AS b ON a.patientsid=b.id "
                    . "WHERE a.patientsid=".$_SESSION['currentptnum']." AND b.active = 1";
            $getLIA = mysqli_query($dbc, $getLIQ);
            if (mysqli_num_rows($getLIA) == 1)
            {
                $getLIR = mysqli_fetch_array($getLIA);
                $_SESSION['username'] = $getLIR[0];
                $_SESSION['ptphone']=$getLIR[1];
                $setUQ = "UPDATE codes SET day3used = 1 WHERE patientsid = ".$_SESSION['currentptnum'];
                mysqli_query($dbc, $setUQ);
                echo'
                <script>
                window.location = "pt3entry.php";
                </script>';
            }
            else
            {
                echo'
                <script>
                window.location = "login.php";
                </script>';
            }
        }
        else
        {
            echo'
            <script>
            window.location = "login.php";
            </script>';
        }
    }
    else
    {
        echo'
        <script>
        window.location = "login.php";
        </script>';
    }        
}
else
{
    $setUQ = "UPDATE codes AS a INNER JOIN patientusers AS b ON a.patientsid=b.patientsid SET a.day3used = 1 WHERE b.username = '".$_SESSION['username']."'";
    mysqli_query($dbc, $setUQ);
    echo'
    <script>
    window.location = "pt3entry.php";
    </script>';
}
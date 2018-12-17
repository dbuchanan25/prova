<?php 

//////////////////////////////////////////////////////////////////////////////////////////////////
//PATIENT INTERFACE                                                                             //
//VERSION 01_01                                                                                 //
//LAST REVISED 20180811                                                                         //
//////////////////////////////////////////////////////////////////////////////////////////////////

function absolute_url ($page = 'login.php')
{
   $url = 'https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
   $url = rtrim($url, '/\\');
   $url .='/'.$page;
   return $url;
}

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function check_login($dbc, $username='', $pass='')
{
   $errors = array();
   if (empty($username))
   {
      $errors[] = 'You forgot to enter your ID.';
   }
   else
   {
      $e = mysqli_real_escape_string($dbc,trim($username));
   }
   
   if (empty($pass))
   {
      $errors[] = 'You forgot to enter your Password.';
   }
   else
   {
      $p = mysqli_real_escape_string($dbc,trim($pass));
   }
   if (empty($errors))
   {  
        $ph = filterphone($p);
        if ($ph != 0) 
        {
            $f = strtolower($e);
            $q = "SELECT a.username, a.pass, a.hashname, a.keychain, a.lastlogin ".
                 "FROM patientusers AS a ".
                 "INNER JOIN patients AS b ".
                 "ON a.patientsid = b.id ".
                 "WHERE a.username='$f' AND a.pass=SHA1('$p') AND b.active=1";
            $r = @mysqli_query ($dbc, $q);
            if (mysqli_num_rows($r) == 1)
            {
                $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
                $_SESSION['ptphone'] = $ph;
                return array(true, $row);
            }
            else
            {
                $errors[] = 'The ID and Password entered do not match those on file.';
            }
        }
        else
        {
            $q = "SELECT username, pass, hashname, keychain, lastlogin FROM users WHERE username='$e' AND pass=SHA1('$p')";
            $r = @mysqli_query ($dbc, $q);
            if (mysqli_num_rows($r) == 1)
            {
                $row = mysqli_fetch_array ($r, MYSQLI_ASSOC);
                return array(true, $row);
            }
            else
            {
                $errors[] = 'The ID and Password entered do not match those on file.';
            }
          }
   }
   return array(false, $errors);
}

function filterphone($p)
{
   $x = strlen($p);
   $phon = "";
   for ($i=0; $i<$x; $i++)
   {
       if (is_numeric($p[$i]) )
       {
           $phon = $phon.$p[$i];
       }
   }
   if (strlen($phon) == 10)
   {
       return $phon;
   }
   else
   {
       return 0;
   }
}
?>
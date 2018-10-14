<?php

//////////////////////////////////////////////////////////////////////////////////////////////////
//PATIENT INTERFACE                                                                             //
//VERSION 01_01                                                                                 //
//LAST REVISED 20180811                                                                         //
//////////////////////////////////////////////////////////////////////////////////////////////////

try 
{
    DEFINE ('DB_USER', 'taschete_pwa');
    DEFINE ('DB_PASSWORD', '4764047998220');
    DEFINE ('DB_HOST', 'localhost');
    DEFINE ('DB_NAME', 'taschete_ptinterface');

    $dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    
    if (!$dbc) 
    {
        throw new Exception("Could not connect to database");
    }
}
catch (Exception $e){
    echo $e;
}

?>
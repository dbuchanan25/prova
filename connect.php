<?php

//////////////////////////////////////////////////////////////////////////////////////////////////
//PATIENT INTERFACE                                                                             //
//VERSION 01_01                                                                                 //
//LAST REVISED 20180811                                                                         //
//////////////////////////////////////////////////////////////////////////////////////////////////


try 
{
    
    DEFINE ('DB_USER', 'alex');
    DEFINE ('DB_PASSWORD', '$eaml101!');
    DEFINE ('DB_HOST', 'localhost');
    DEFINE ('DB_NAME', 'ptinterface');


    $dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME,null,'/var/www/html/mysql/mysql.sock');
    
    
    if (!$dbc) 
    {
        DEFINE ('DB_USER2', 'root');
        DEFINE ('DB_PASSWORD2', '!Srt101!');
        DEFINE ('DB_HOST2', 'localhost');
        DEFINE ('DB_NAME2', 'ptinterface');


        $dbc = @mysqli_connect (DB_HOST2, DB_USER2, DB_PASSWORD2, DB_NAME2);
        
    }
    
    if (!$dbc) 
    {
        throw new Exception("Could not connect to database");
    }
}
catch (Exception $e)
{
    echo $e;
}

?>
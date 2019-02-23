<?php

//////////////////////////////////////////////////////////////////////////////////////////////////
//PATIENT INTERFACE                                                                             //
//VERSION 01_01                                                                                 //
//LAST REVISED 20180811                                                                         //
//////////////////////////////////////////////////////////////////////////////////////////////////

    $h = intval(floor($_SESSION['w'])*158/667*.5);
    

    echo'
        <head>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
        <title>Providence Anesthesiology</title>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <style>
        * {
            box-sizing: border-box;
        }

        .column {
            float: left;
            width: 50%;
            height: '.$h.'px;
            background-color:#7db4dc;
        }
        
        .column2 {
            float: right;
            width: 50%;
            padding: '.intval($h/3).'px;
            height: '.$h.'px;
            text-align: center;
            color:#ffffff;
            font-size:'.$h*.3.'px;
            background-color:#7db4dc;
        }
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
        </style>
        </head>

        <body style="background-color:eeeeee">
            <div class="row">
                <div class="column">
                    <img src="includes/ProvidenceSmall.png" alt="PAA" height=100% width=100% />
                </div>
                <div class="column2">
                    Block Reporting
                </div>
            </div>';
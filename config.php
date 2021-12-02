<?php
session_start();
    $dbHost = 'us-cdbr-east-04.cleardb.com';
    $dbUsername = 'b2a2784d1d4897';
    $dbPassword = '2a178fe4';
    $dbName = 'heroku_e79c9ad2ac8e9f9';
    
    $conection = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

    if (mysqli_ping($conection)) {
        printf ("Our connection is ok!\n");
    } else {
        printf ("Error: %s\n", mysqli_error($link));
    }

   /* if($conection->connect_errno){
        echo "Erro";
    }
    else{
        echo "Successfully connected";
    } */
?>
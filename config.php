<?php
session_start();
    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'xminerei';
    
    $conection = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

    mysqli_query($conection, "USE xminerei;");

   /* if($conection->connect_errno){
        echo "Erro";
    }
    else{
        echo "Successfully connected";
    } */
?>
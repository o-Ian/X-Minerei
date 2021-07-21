<?php

    $dbHost = 'Localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'xminerei';
    
    $conection = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

    if($conection->connect_errno){
        echo "Erro";
    }
    else{
        echo "Successfully connected";
    }
?>
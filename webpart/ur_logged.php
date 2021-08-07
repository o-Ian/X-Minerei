<?php
include_once('config.php');
if(!$_SESSION['email']){
    header('Location: login.php');
    exit();
} 
?>
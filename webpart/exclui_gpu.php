<?php 
include_once('config.php');

$id_gpu = $_GET['id']; 

$sql_query = mysqli_query($conection, "DELETE from inputs where id_input = '$id_gpu'");

header('Location: charts.php');
?>
<?php
include_once('config.php');

$hashrate_update = $_POST['hashrate_update'];
$GPU_update = $_POST['GPU_update'];
$preco_update_gpu = $_POST['preco_update_gpu'];

$query = '';

$c = 0;
if($hashrate_update != $_SESSION['hashrate_update']){
    $query .= "hashrate = $hashrate_update, ";
    $c = $c + 1;

}
if($GPU_update != $_SESSION['gpu_update']){
    $query .= "GPU = $GPU_update, ";
    $c = $c + 1;
}
if($preco_update_gpu != $_SESSION['preco_update']){
    $query .= "preco = $preco_update_gpu,";
    $c = $c + 1;
}
if($c == 1){
    $query = str_replace(',', '', $query);
}
else{
    $query = rtrim($query, ',');
}

$id_input = $_SESSION['id_input'];

$query_full = "UPDATE inputs set " . $query . " where id_input = $id_input";


$loko = mysqli_query($conection, $query_full);


header('Location: charts.php');

?>
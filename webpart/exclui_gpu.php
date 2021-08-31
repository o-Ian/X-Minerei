<?php 
include_once('config.php');

$id_gpu = $_POST['id_gpu']; 

$qntd = $_POST['qntd'];

$hashrate = $_POST['hashrate'];

$preco = $_POST['preco'];

$potencia_w = $_POST['potencia_w'];

$sql_query = mysqli_query($conection, "DELETE from inputs where id_input = '$id_gpu'");


$email = $_SESSION['email'];
$senha = $_SESSION['senha'];
$query_id = "SELECT * FROM usuarios where email = '$email' and senha = '$senha'";
$dados = mysqli_query($conection, $query_id);
$row = mysqli_fetch_array($dados,MYSQLI_ASSOC);
$id = $row['id'];
$_SESSION['id'] = $id;


// Catching hashrateMhs_total, potencia_w_total, preco_total
$busca = "SELECT * from usuarios_total where id = '$id'";
$result_usuarios_total = mysqli_query($conection, $busca);
$row2 = mysqli_fetch_array($result_usuarios_total);

// Sum row2 data and input data user on usuarios_total 
$hashrateMhs_total =  $row2["hashrateMhs_total"] - ($hashrate * $qntd);
$preco_total = $row2["preco_total"] - ($preco * $qntd);
$potencia_w_total = $row2["potencia_w_total"] - ($potencia_w * $qntd);


$insercao = mysqli_query($conection, 
    "UPDATE usuarios_total
    set hashrateMhs_total = '$hashrateMhs_total',  potencia_w_total = '$potencia_w_total', preco_total = '$preco_total' where id = '$id'");

?>
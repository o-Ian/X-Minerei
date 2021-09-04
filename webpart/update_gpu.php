<?php
include_once('config.php');

$hashrate_update = $_POST['hashrate_update'];
$GPU_update = $_POST['GPU_update'];
$preco_update_gpu = $_POST['preco_update_gpu'];
$qntd = $_POST['qntd_update'];
$tarifa_energia = $_POST['tarifa_energia_update'];
$potencia_w = $_POST['potencia_update'];

//Pegando o valor que era
$hashrate_update_antes = $_POST['hashrate_antes'];
$GPU_update_antes = $_POST['select_value_antes'];
$preco_update_gpu_antes = $_POST['preco_update_antes'];
$qntd_antes = $_POST['qntd_antes'];
$tarifa_energia_antes = $_POST['tarifa_energia_antes'];
$potencia_w_antes = $_POST['potencia_w_antes'];


$query = '';

$c = 0;
if($hashrate_update != $_SESSION['hashrate_update']){
    $query .= "hashrate = $hashrate_update, ";
    $c = $c + 1;

}
if($qntd != $_SESSION['qntd_update']){
    $query .= "qntd = '$qntd', ";
    $c = $c + 1;
}
if($GPU_update != $_SESSION['gpu_update']){
    $query .= "GPU = '$GPU_update', ";
    $c = $c + 1;
}
if($tarifa_energia != $_SESSION['tarifa_energia_update']){
    $query .= "tarifa_energia_real = '$tarifa_energia', ";
    $c = $c + 1;
}
if($potencia_w != $_SESSION['potencia_update']){
    $query .= "potencia_w = '$potencia_w', ";
    $c = $c + 1;
}
if($preco_update_gpu != $_SESSION['preco_update']){
    $query .= "preco = $preco_update_gpu,";
    $c = $c + 1;
}


if($c == 1){
    $query = str_replace(',', '', $query);
}
if($c != 1){
    $query = rtrim($query, ',');
}

$id_input = $_SESSION['id_input'];

$query_full = "UPDATE inputs set " . $query . " where id_input = $id_input";

$loko = mysqli_query($conection, $query_full);

print_r("Essa é a query dos inputs: " . $query_full );


//Atualizando tabela usuarios_total

$id = $_SESSION['id'];

// Catching hashrateMhs_total, potencia_w_total, preco_total
$busca = "SELECT * from usuarios_total where id = '$id'";
$result_usuarios_total = mysqli_query($conection, $busca);
$row2 = mysqli_fetch_array($result_usuarios_total);


// Sum row2 data and input data user on usuarios_total 
$hashrateMhs_total = $row2["hashrateMhs_total"] + ($hashrate_update * $qntd) - ($hashrate_update_antes * $qntd_antes);
$potencia_w_total = $row2["potencia_w_total"] + ($potencia_w * $qntd) - ($potencia_w_antes * $qntd_antes);
$preco_total = $row2["preco_total"] + ($preco_update_gpu * $qntd) - ($preco_update_gpu_antes * $qntd_antes);

echo "O QUE ERA O HASHRATE TOTAL: " . $row2["hashrateMhs_total"] ;
echo "||| HASHRATE ANTES: " . $hashrate_update_antes;
echo "||| HASHRATE: " . $hashrate_update;
echo "||| QNTD: " . $qntd;
echo "||| QNTD ANTES: " . $qntd_antes;

// Calculating tarifa_energia
$buscando_linhas = "SELECT id_user, preco, tarifa_energia_real, qntd from inputs where id_user= '$id'";
$resultado = mysqli_query($conection, $buscando_linhas);
$multiplica = 0;
$pesos = 0;
while($linhas = mysqli_fetch_array($resultado)){
  $peso = $linhas['qntd'] * $linhas['preco'];
  $multiplica = ($peso * $linhas ['tarifa_energia_real']) + $multiplica;
  $pesos = $peso + $pesos;
}
$tarifa_energia_real = $multiplica/$pesos;

$insercao = mysqli_query($conection, 
"UPDATE usuarios_total
set hashrateMhs_total = '$hashrateMhs_total',  potencia_w_total = '$potencia_w_total', preco_total = '$preco_total', tarifa_energia_media = '$tarifa_energia_real'
where id = '$id'");





mysqli_close($conection);


//header('Location: charts.php');

?>
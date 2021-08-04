<?php
session_start();
include_once('config.php');

// Catching id user
$id = $_SESSION['id'];

// Catching inputs user
$query = "SELECT * from usuarios_total where id = '$id'";   
$data = mysqli_query($conection, $query);
$row2 = mysqli_fetch_assoc($data);

// Power cost total
$power_cost = $row2['tarifa_energia_media'];

// Hashrate total
$hashrate = $row2['hashrateMhs_total'];

// Power w total
$power_w = $row2['potencia_w_total'];

// Total cost with GPU
$total_cost_GPU = $row2['preco_total'];


// Making arrays 
$result_columns = "SELECT * from mineration_data";
$result = mysqli_query($conection, $result_columns);
$PowerCost_list = array();
$ETH_made_day_list = array();
$Date_UTC = array();
$Revenue_BRL = array();
$Cost_BRL = array();
$Profit_day_BRL = array();
$cont = 0;
while($row = mysqli_fetch_assoc($result)){
    array_push($PowerCost_list, $row['inflacao'] * $power_cost . "<br>");
    $calculo = (((($hashrate*1000000)*(1-(1)/100))/($row['networkDifficulty']*1000000000000))*$row['ethperday'])*24;
    array_push($ETH_made_day_list, $calculo . "<br>");
    array_push($Revenue_BRL, $row['ethPrice_BRL'] * $calculo . "<br>");
    array_push($Cost_BRL, $power_w * 0.001 * ($row['inflacao'] * $power_cost) * 24 . "<br>");
    array_push($Profit_day_BRL, ($row['ethPrice_BRL'] * $calculo) - ($power_w * 0.001 * ($row['inflacao'] * $power_cost) * 24)  . "<br>");


}
print_r($Profit_day_BRL);

?>
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
$Cost_day_BRL = array();
$Profit_day_BRL = array();
$Profit_month_BRL = array();
$GPU_Price = array();
$Pays_itself_months = array();
$total_cost_GPU_position775 = $total_cost_GPU/3.196936374084848;

while($row = mysqli_fetch_assoc($result)){
    array_push($PowerCost_list, $row['inflacao'] * $power_cost . "<br>");
    $calculo = (((($hashrate*1000000)*(1-(1)/100))/($row['networkDifficulty']*1000000000000))*$row['ethperday'])*24;
    array_push($ETH_made_day_list, $calculo . "<br>");
    array_push($Revenue_BRL, $row['ethPrice_BRL'] * $calculo . "<br>");
    array_push($Cost_day_BRL, $power_w * 0.001 * ($row['inflacao'] * $power_cost) * 24 . "<br>");
    $calculo_profit_day = ($row['ethPrice_BRL'] * $calculo) - ($power_w * 0.001 * ($row['inflacao'] * $power_cost) * 24);
    array_push($Profit_day_BRL, $calculo_profit_day . "<br>");
    array_push($Profit_month_BRL, $calculo_profit_day * 30 . "<br>");
    $calculo_gpuprice = $total_cost_GPU * $row['multiple_gpuPrice'];

    if(array_key_exists(775, $GPU_Price)){
        if ($calculo_gpuprice == 0){
            $GPU_Price_unit = $total_cost_GPU * $row['Difficulty_LastDifficulty'];
            array_push($GPU_Price, $GPU_Price_unit . "<br>");
            
        }
        else if($calculo_gpuprice != 0){
            $GPU_Price_unit = $calculo_gpuprice;
            array_push($GPU_Price, $GPU_Price_unit . "<br>");
        }
    }
    else{
        $GPU_Price_unit = $total_cost_GPU_position775 * $row['inflacao'];
        array_push($GPU_Price, $GPU_Price_unit . "<br>"); 
    }
    array_push($Pays_itself_months, $GPU_Price_unit/ ($calculo_profit_day * 30) . "<br>");
}
print_r($Cost_day_BRL);

?>
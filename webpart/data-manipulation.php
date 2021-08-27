<?php
include_once('config.php');

// Catching id user
$id = $_SESSION['id'];

// Catching inputs user
$query = "SELECT * from inputs where id_user = '$id'";   
echo $id;
$data = mysqli_query($conection, $query);
$qntd_rows = mysqli_num_rows($data);

$avg_profit_day = '00,00';
$avg_cost_day = '00,00';
$avg_revenue_day = '00,00';
$avg_payItself_day = '0,0';
$cost_revenue_indicator = '00,00';
$profit_revenue_indicator = '00,00';
$gpuPrice_return_indicator = '00,00';

if($qntd_rows >= 1){
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
$EnergyCost_Revenue = array();
$Profit_day_BRL = array();
$Profit_month_BRL = array();
$GPU_Price = array();
$Pays_itself_months = array();
$total_cost_GPU_position775 = $total_cost_GPU/3.196936374084848;
$hashrate = $hashrate * 1000000;


while($row = mysqli_fetch_assoc($result)){
    array_push($Date_UTC, $row['data_utc']);
    array_push($PowerCost_list, $row['inflacao'] * $power_cost);
    $calculo = ((($hashrate*(1-((1)/100)))/($row['networkDifficulty']*1000000000000))*($row['ethperday'])/$row['total_blocks'])* 3600 * 24;
    $calculo_revenue = $row['ethPrice_BRL'] * $calculo;
    if($calculo_revenue != 0){
        $calculo_energy_cost_revenue = $calculo_energy_cost_day/$calculo_revenue*100;
    }else{
        $calculo_energy_cost_revenue = 0;
    }
    array_push($ETH_made_day_list, $calculo);
    array_push($Revenue_BRL, $calculo_revenue);
    $calculo_energy_cost_day = $power_w * 0.001 * ($row['inflacao'] * $power_cost) * 24;
    array_push($Cost_day_BRL, $calculo_energy_cost_day);
    $calculo_profit_day = ($calculo_revenue) - ($calculo_energy_cost_day);
    array_push($Profit_day_BRL, $calculo_profit_day);
    array_push($Profit_month_BRL, $calculo_profit_day * 30);
    array_push($EnergyCost_Revenue, number_format($calculo_energy_cost_revenue, 2));
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
// Making profit day average of the past 6 months
$avg_profit_day_list = array_slice($Profit_day_BRL, -181, 181);
$avg_profit_day = array_sum($avg_profit_day_list)/count($avg_profit_day_list);
$avg_profit_day = number_format($avg_profit_day, 2);
$avg_profit_day = str_replace(',', '', $avg_profit_day);
$avg_profit_day = str_replace('.', ',', $avg_profit_day);

// Making cost day average of the past 6 months
$avg_cost_day_list = array_slice($Cost_day_BRL, -181, 181);
$avg_cost_day = array_sum($avg_cost_day_list)/count($avg_cost_day_list);
$avg_cost_day = number_format($avg_cost_day, 2);
$avg_cost_day = str_replace(',', '', $avg_cost_day);
$avg_cost_day = str_replace('.', ',', $avg_cost_day);

// Making revenue day average of the past 6 months
$avg_revenue_day_list = array_slice($Revenue_BRL, -181, 181);
$avg_revenue_day = array_sum($avg_revenue_day_list)/count($avg_revenue_day_list);
$avg_revenue_day = number_format($avg_revenue_day, 2);
$avg_revenue_day = str_replace(',', '', $avg_revenue_day);
$avg_revenue_day = str_replace('.', ',', $avg_revenue_day);

// Making pay itself month average of the past 3 months
$avg_payItself_day_list = array_slice($Pays_itself_months, -92, 92);
$avg_payItself_day = array_sum($avg_payItself_day_list)/count($avg_payItself_day_list);
$avg_payItself_day = number_format($avg_payItself_day, 1);
$avg_payItself_day = str_replace(',', '', $avg_payItself_day);
$avg_payItself_day = str_replace('.', ',', $avg_payItself_day);

// Indicators
// Costs/Revenue
$cost_revenue_indicator = array_sum($avg_cost_day_list) / array_sum($avg_revenue_day_list) * 100;
$cost_revenue_indicator = number_format($cost_revenue_indicator, 2);

// Profit/Revenue
$profit_revenue_indicator = array_sum($avg_profit_day_list) / array_sum($avg_revenue_day_list) * 100;
$profit_revenue_indicator = number_format($profit_revenue_indicator, 2);

// GPU Price/Return
$Revenue_42_months = array_slice($Revenue_BRL, -1277, 1277);
$gpuPrice_return_indicator = array_sum($Revenue_42_months)/$total_cost_GPU;
$gpuPrice_return_indicator = number_format($gpuPrice_return_indicator, 2);

$Date_UTC = json_encode($Date_UTC);
$EnergyCost_Revenue = json_encode($EnergyCost_Revenue);
}
 
?>
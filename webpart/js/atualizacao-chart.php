<!DOCTYPE html>
<?php
$chart = array();

$chart['Date_UTC'] = $_SESSION['Date_UTC'];

$chart['EnergyCost_Revenue'] = $_SESSION['EnergyCost_Revenue'];

echo json_encode($chart);

?>
</html>
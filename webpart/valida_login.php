<?php
include_once('config.php');

if(empty($_POST['email']) || empty($_POST['password'])){
    header('Location: login.html');
    exit();
}

$email =  mysqli_real_escape_string($conection, $_POST['email']);
$password =  mysqli_real_escape_string($conection, $_POST['password']);

$query = "select * from usuarios where email = '{$email}' and senha = '{$password}'";


$result = mysqli_query($conection, $query);

$row = mysqli_num_rows($result);

echo $row;
if($row == 1){
    header('Location: charts.html');
    $invalido = false;
} 
else{
    $invalido =  true;
}

?>
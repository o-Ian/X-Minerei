<?php
session_start();
include_once('config.php');

if(empty($_POST['email']) || empty($_POST['password'])){
    header('Location: login.php');
    exit();
}

$email =  mysqli_real_escape_string($conection, $_POST['email']);
$password =  mysqli_real_escape_string($conection, $_POST['password']);

$query = "select * from usuarios where email = '{$email}' and senha = '{$password}'";

$result = mysqli_query($conection, $query);

$row = mysqli_num_rows($result);

echo $row;
if($row == 1){
    $_SESSION['email'] = $email;
    $_SESSION['senha'] = $password;
    $row2 = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $_SESSION['id'] = $row2['id'];
    header('Location: charts.php');
} 
else{
    $_SESSION['not_find'] = true;
    header('Location: login.php');
}
?>
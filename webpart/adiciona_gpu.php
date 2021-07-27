<?php
session_start();
  if(isset($_POST['submit2'])){

    include_once('config.php');

    $GPU = $_POST['GPU'];
    $GPU_qntd = $_POST['GPU_qntd'];
    $hashrate = $_POST['hashrate'];
    $potencia_w = $_POST['potencia_w'];
    $tarifa_energia = $_POST['tarifa_energia'];
    $preco_GPU = $_POST['preco_GPU'];
    $email = $_SESSION['email'];
    $senha = $_SESSION['senha'];

    // Catching user id  
    $query_id = "SELECT * FROM usuarios where email = '$email' and senha = '$senha'";
    $dados = mysqli_query($conection, $query_id);
    $row = mysqli_fetch_array($dados,MYSQLI_ASSOC);
    $id = $row["id"];


    $result = mysqli_query($conection, 
    "INSERT INTO inputs(id_user, GPU, qntd, hashrate, potencia_w, tarifa_energia_real, preco) VALUES ('$id', '$GPU',' $GPU_qntd', '$hashrate',' $potencia_w', '$tarifa_energia', '$preco_GPU')"); 
  }
  header('Location: charts.php')
?>
<?php
 include_once('config.php');

    $GPU = $_POST['select_adiciona_gpu'];
    $GPU_qntd = $_POST['quantidade_adiciona_gpu']; 
    $hashrate = $_POST['hashrate_adiciona_gpu'];
    $potencia_w = $_POST['potencia_adiciona_gpu'];
    $tarifa_energia = $_POST['tarifa_adiciona_gpu'];
    $preco_GPU = $_POST['preco_gpu_adiciona_pgu'];
    $email = $_SESSION['email'];
    $senha = $_SESSION['senha'];

    // Catching user id 
    $query_id = "SELECT * FROM usuarios where email = '$email' and senha = '$senha'";
    $dados = mysqli_query($conection, $query_id);
    $row = mysqli_fetch_array($dados,MYSQLI_ASSOC);
    $id = $row['id'];
    $_SESSION['id'] = $id;

    $result = mysqli_query($conection, 
    "INSERT INTO inputs(id_user, GPU, qntd, hashrate, potencia_w, tarifa_energia_real, preco) VALUES ('$id', '$GPU',' $GPU_qntd', '$hashrate',' $potencia_w', '$tarifa_energia', '$preco_GPU')");
    
    // Catching hashrateMhs_total, potencia_w_total, preco_total
    $busca = "SELECT * from usuarios_total where id = '$id'";
    $result_usuarios_total = mysqli_query($conection, $busca);
    $row2 = mysqli_fetch_array($result_usuarios_total);

    // Sum row2 data and input data user on usuarios_total 
    $hashrateMhs_total = ($row2["hashrateMhs_total"] + $hashrate) * $GPU_qntd;
    $potencia_w_total = ($row2["potencia_w_total"] + $potencia_w) * $GPU_qntd;
    $preco_total = ($row2["preco_total"] + $preco_GPU) * $GPU_qntd;
    
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
?>
<?php

  if(isset($_POST['submit'])){

    include_once('config.php');

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $result = mysqli_query($conection, 
    "INSERT INTO usuarios(nome, email, senha) VALUES ('$nome', '$email', '$senha')");

    // Searching ID

    $busca_id = "select id from usuarios where email = '{$email}' and senha = '{$senha}'";
    $result_id = mysqli_query($conection, $busca_id); 
    $row = mysqli_fetch_array($result_id);
    $id = $row['id'];
  
    // Adding ID on usuarios_total table

    $adding_id = mysqli_query($conection, "INSERT INTO usuarios_total(id) VALUES ('$id')");

  }
   mysqli_close($conection);
   header('Location: login.php')
?>
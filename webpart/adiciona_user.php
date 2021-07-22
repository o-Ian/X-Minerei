<?php

  if(isset($_POST['submit'])){

    include_once('config.php');

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $result = mysqli_query($conection, 
    "INSERT INTO usuarios(nome, email, senha) VALUES ('$nome', '$email', '$senha')"); 
  }
  header('Location: login.html')
?>
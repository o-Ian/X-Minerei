<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - X-Minerei</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="./img/favicon.png">
</head>
<body>
    <div class="center">
        <header class="superior">
            <a href="index.php" class="logo-all">
                <i class="logo"></i>
            </a>
            <ul class="menu">
                <li class="menu-li"><a href="index.php " class="menu__link">Início</a></li>
                <li class="menu-li"><a href="charts.php" class="menu__link">Dashboard</a></li>
            </ul>
        </header>
    </div>

    <div class = "container">
        <div class = "container_login">
          <h2 class="title-login">Login</h2>
          <?php
            session_start();
            if(isset($_SESSION['not_find'])):
          ?>
          <div class="error">
            E-mail ou senha inválidos
          </div>
          <?php
            endif;
            unset($_SESSION['not_find']);
          ?>
          <form action="valida_login.php" method="POST"> 
              <input type="email" name="email" class="form-control" id="email_input" placeholder="E-mail"> 
              
              <input type="password" name="password" class="form-control" id="senha_input" placeholder="Senha">
              <a href = "cadastro.html" class="n-tem"> Não tem cadastro? Cadastre-se aqui </a>

              <button type="submit" class="btn"> Continuar </button>
          </form>
          <footer>
            <span>Ou conecte-se com as redes socias</span>
            <div class="social-field-facebook">
              <a href="#">
                <img src="img/facebook.png" alt="">
                Logar com o Facebook
              </a>
            </div>
            <div class="social-field-google">
              <a href="#">
                <img src="img/google..png" alt="">
                Logar com o Google
              </a>
            </div>

          </footer>
         
        </div> 
        
      </div>
      <script src="js/validacao_login.js"></script>
</body>
</html>
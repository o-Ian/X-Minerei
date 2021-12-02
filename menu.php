<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>X-Minerei</title>
    <link rel="stylesheet" href="css/styles.css">
    
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="./img/favicon.png">
</head>
<body>
    <div class="center" >
        <div class="superior">
            <a href="index.php" class="logo-all">
                <i class="logo"></i>
            </a>
            
            <nav id="nav">
            <button id="btn-mobile">Menu

            <span id="hamburguer"></span>
            </button>


            <ul class="menu" id = "menu">
                <li class="menu-li"><a href="index.php" class="menu__link">Início</a></li>
                <li class="menu-li"><a href="charts.php" class="menu__link">Dashboard</a></li>
                <?php
                if(!isset($_SESSION['email'])):
              ?>
                <li class="menu-li2"><a href="login.php" class="bt_signin">Login</a></li>
                <li class="menu-li2"><a href="cadastro.html" class="bt_signup">Cadastro</a></li>
              <?php
                endif;
              ?>
              <?php
                if(isset($_SESSION['email'])):
                  
              ?>
                <li class="menu-li"><a href="#" class="menu__link"><img src="img/user (1).png" alt="" class="dropdown-main-image"></a>
                    <ul>
                        <li class="dropdown-itens"><img src="img/logout.png" alt="" class="dropdown-images"><a href="logout.php" class="dropdown-menu__link">Sair</a></li>
                        <li class="dropdown-itens"><a href="#" class="dropdown-menu__link">Entrar</a></li>
                        
                    </ul>
                </li>
              <?php
                endif;
              ?>
            </ul>
            </nav>
        </div>
    </div>

 

  <script src="js/top-fixed.js"></script>
  <script src="js/menu-hamburguer.js"></script>
</body>
</html>
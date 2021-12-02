<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>X-Minerei TESTE DEPLOY AUTOMÁTICO</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="./img/favicon.png">
</head>
<body>
    <?php session_start(); include_once('menu.php'); ?>
        <!-- <div class="center" >
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
    </div> -->

        <div class="img-right">
            <img class="image1" src="./img/background2.png">
            <div class="image2">
                <div class="lucro-box">
                    <buttom class="lucro-box-text">Seu lucro diário</buttom> <img src="img/profits.png" alt="" class="icon-profit-box">
                    <div class="money-lucro-box money-lucro-box-text">
                        +$23,12
                    </div>
                </div>
            </div>
        </div>
        <div class="texto-botoes">
            <div class="texto">
                <h2 class="title-apresentacao">Minere de forma inteligente.</h2>
                <p class="sub-titulo">Insira seus dados e conheça detalhadamente tudo<br>sobre seu lucro e gastos, de graça.</p>
                <div class="bt-position">
                    <a href="charts.php" class="bt-text"><buttom class="uni-bt">Calcule seu lucro</buttom></a>
                </div>
            </div>
        </div>
    <div class="icons">
        <div class="icon-wrapping">
            <div class="box-icon box-icon-color2">
                <img src="./img/easy-use.png" alt="">
            </div>
            <h6 class="box-icone-title">Facilidade</h6>
            <p class="box-icone-text">Analise tudo o que precisa de forma rápida e fácil</p>
        </div>
        <div class="icon-wrapping">
            <div class="box-icon box-icon-color">
                <img src="./img/dart.png" alt="">
            </div>
            <h6 class="box-icone-title">Precisão</h6>
            <p class="box-icone-text">Todos nossos dados são retirados diretamente da fonte</p>
        </div>
        <div class="icon-wrapping">
            <div class="box-icon box-icon-color2">
                <img src="./img/integration.png" alt="">
            </div>
            <h6 class="box-icone-title">Integridade</h6>
            <p class="box-icone-text">Usamos de aprendizado de máquina para melhor integridade dos dados</p>
        </div>
        <div class="icon-wrapping">
            <div class="box-icon box-icon-color">
                <img src="./img/light-bulb.png" alt="">
            </div>
            <h6 class="box-icone-title">Simplicidade</h6>
            <p class="box-icone-text">Criamos indicadores para que sua análise seja feita de uma forma mais acertiva e simples</p>
        </div>
        <div class="clear"></div>
    </div>
    
    <div class="texto2">
        <div class="eth_ico">
            <img src="./img/ethereum.png" alt="">
        </div>
        <h2 class="title-apresentacao2">Um mundo de possibilidades!</h2>
        <p class="sub-titulo2">Com nossa dashboard, é possível analisar todos os dados de faturamento,  lucro, gasto de energia e vários outros indicadores.</p>
        <div class="bt-baixo-position">
            <a href="charts.hmtl" class="bt-text-baixo"><buttom class="uni-bt-baixo">Acessar dashboard</buttom></a>
        </div>
        
    </div>
        
    <div>
        <footer class="rodape">
            <ol>
                <li class="rodape-title"><h4></h4>Institucional</li>
                <a href="#"><li class="rodape-text">Termos de serviços</li></a>
                <a href="#"><li class="rodape-text">Política de privacidade</li></a>
            </ol>
            <footer class="copyright">
                <p>Copyright © 2021</p>
            </footer>
        </footer>
    </div>
        
    
  <script src="js/top-fixed.js"></script>
</body>
</html>
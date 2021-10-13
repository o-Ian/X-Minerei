<?php
include_once('ur_logged.php');
//include_once('data-manipulation.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráficos - X-Minerei</title>
    <link rel="stylesheet" href="css/charts.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="./img/favicon.png">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->

    <script 
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="css/select2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <?php include_once('menu.php')?>
    <!-- <div class="center">
        <div class="superior">
            <a href="index.php" class="logo-all">
                <i class="logo"></i>
            </a>
            <ul class="menu">
                <li class="menu-li"><a href="index.php" class="menu__link">Início</a></li>
                <li class="menu-li"><a href="#" class="menu__link">Dashboard</a></li>
                <li class="menu-li"><a href="#" class="menu__link"><img src="img/user (1).png" alt="" class="dropdown-main-image"></a>
                    <ul>
                        <li class="dropdown-itens"><img src="img/logout.png" alt="" class="dropdown-images"><a href="logout.php" class="dropdown-menu__link">Sair</a></li>
                        <li class="dropdown-itens"><a href="#" class="dropdown-menu__link">Entrar</a></li>
                        <li class="dropdown-itens"><a href="#" class="dropdown-menu__link">Manter-se</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div> -->

        <div class="menu-lado">
            <ol>
                <li><a href="#"><img src="./img/input.png" alt="" class="butao-atual"></a></li>
                <li><a href="#"><img src="./img/grafico-de-barras.png" alt="" class="butao"></a></li>
            </ol>
        </div>
    
    <div class="menu-esquerdo">
        <div class="box-cima">
            <h2 class="titulo">Coloque suas informações!</h2>
            <p class="box-cima-desc">Preencha cada peça que você tem e tenha acesso aos dados.</p>
        </div>
        <div class="inputs">
            <form action="adiciona_gpu.php" method="POST" id = "form_adiciona_pgu">
                <div class="linha-input">
                    <select id="gpu" required style= "width: 280px" name="GPU">
                        <option value="default" selected hidden disabled>Qual a sua placa de vídeo?</option>
                        <optgroup label="GTX">
                            <option value="GTX 1050">GTX 1050</option>
                            <option value="GTX 1060">GTX 1060</option>
                            <option value="GTX 1080">GTX 1080</option>
                        </optgroup>
                        <optgroup label="AMD">
                            <option value="GTX 1050">GTX 1050</option>
                            <option value="GTX 1060">GTX 1060</option>
                            <option value="GTX 1080">GTX 1080</option>
                            <option value="GTX 1080">GTX 1080 TI</option>
                            <option value="GTX 1050">GTX 1050 TI</option>
                            <option value="GTX 1070">GTX 1070</option>
                        </optgroup>
                    </select>
                    <div class="quantidade">
                        <h4 class="box-quantidade-title" >Quantidade</h4>
                        <input type="number" name="GPU_qntd" id="quantidade_adiciona_gpu" class="box-quantidade" value="1" required>
                    </div>
                </div>
                <section class="boxs">
                    <div class="box-itens">
                        <label for="" class="box-hashrate-title">Qual seu hashrate?</label>
                        <input required type="number" required name="hashrate" id="hashrate_adiciona_gpu" class="box-hashrate-input" min="0.01"placeholder="00.00" step="any">
                        <span class="input-group-addon">Mh/s</span>
                    </div>
                    <div class="box-itens2">
                        <label for="" class="box-hashrate-title">Qual a potência?</label>
                        <input type="number" required name="potencia_w" id="potencia_adiciona_gpu" class="box-hashrate-input" min="0.01" placeholder="00.00" step="any">
                        <span class="input-group-addon">W</span>
                    </div>
                    <div class="break"></div>
                    <div class="box-itens3">
                        <label for="" class="box-hashrate-title">Quanto é sua tarifa<br>de energia?</label>
                        <span class="input-group-addon-esquerda">R$</span>
                        <input type="number" required name="tarifa_energia" id="tarifa_adiciona_gpu" min="0.01" class="box-hashrate-input" placeholder="00.00" step="any">
                    </div>
                    <div class="box-itens4">
                        <label for="" class="box-hashrate-title">Qual o preço da peça?</label>
                        <span class="input-group-addon-esquerda">R$</span>
                        <input type="number" required name="preco_GPU" min="1" id="preco_gpu_adiciona_pgu" class="box-hashrate-input" placeholder="00.00" step="any">
                    </div>
                    <div class="break"></div>
                    <div>
                        <button type="submit" id = "submit2" class="input-button" name="submit2"><img src="img/Stroke 3.png" alt="" class="img-button"> Adicionar</button>
                    </div>
                </section>
        </div>
            </form>
            <span id="resposta_adicionar"></span>
        <div class="devices" >
            <h2>Minhas peças</h2>
            <div id="conteudo">
            </div>
        </div>   
            
    </div>
    <div class="menu-right">
    <div class="menu-direito">
        <div class="linha-1">
            <h3 class="menu-general-title">Visão geral</h3>
            <a href=""><button hred class="details-button"><img src="img/Arrow Copy.png" alt="" class="img-button2">Acessar detalhes</button></a>
        </div>
        <section class="boxes-rigth">
            <div class="box-itens-rigth1">
                <div class="linha-box-rigth">
                    <img src="img/lucro-icon.png" alt="" class="img-position-box-rigth">
                    <span class="input-group-addon-box-rigth" id= "avg_profit_day">R$ <?=$_SESSION['avg_profit_day']?></span>
                </div>
                <label for="" class="box-hashrate-title-rigth">Lucro médio/dia</label>
            </div>
            <div class="box-itens-rigth2">
                <div class="linha-box-rigth">
                    <img src="img/baixo-custo 1.png" alt="" class="img-position-box-rigth">
                    <span class="input-group-addon-box-rigth" id = "avg_cost_day">R$ <?=$_SESSION['avg_cost_day'];?></span>
                </div>
                <label for="" class="box-hashrate-title-rigth">Gastos médio/dia</label>            
            </div>
            <div class="box-itens-rigth3">
                <div class="linha-box-rigth">
                    <img src="img/money-bag.png" alt="" class="img-position-box-rigth">
                    <span class="input-group-addon-box-rigth" id = "avg_revenue_day">R$ <?=$_SESSION['avg_revenue_day'];?></span>
                </div>
                <label for="" class="box-hashrate-title-rigth">Faturamento<br>médio/dia</label>            
            </div>
            <div class="box-itens-rigth4">
                <label for="" class="box-hashrate-title-rigth4" id="avg_payItself_day">Se paga em <?=$_SESSION['avg_payItself_day'];?> meses</label>            
            </div>
        </section>
        <div class="indicadores">
            <div class="linha-2">
                <h3 class="menu-indicators-title">Indicadores</h3>
            </div>    
            <div class="box-indicators">
                <div class="box-indicators1">
                    <h4 class="box-indicators-title">Gastos/<br>Faturamento</h4>
                    <h2 class="box-indicators-porc" id ="cost_revenue_indicator"><?=$_SESSION['cost_revenue_indicator'];?>%</h2>
                </div>
                <div class="box-indicators1">
                    <h4 class="box-indicators-title">Lucro/<br>Faturamento</h4>
                    <h2 class="box-indicators-porc" id = "profit_revenue_indicator"><?=$_SESSION['profit_revenue_indicator'];?>%</h2>
                </div>
                <div class="box-indicators1">
                    <h4 class="box-indicators-title">Retorno/<br>Custo das peças</h4>
                    <h2 class="box-indicators-porc" id = "gpuPrice_return_indicator"><?=$_SESSION['gpuPrice_return_indicator'];?>x</h2>
                </div>
            </div>
        </div>
        <div class="graph">
            <h3 class="menu-graph-title">Consumo de energia</h3>
            <div class="graph-align">
                <canvas id="chart" width="400px" height="250px"></canvas>
            </div>
        </div>
    </div>
    </div>
    <!--<div>
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
    </div>-->    
    <!-- Small modal -->
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    <form class="form_update" id ="modal-modal"> 
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" class="fechar">X</span>
            </button>
            <span id = "infos_gpu"></span>
              
    </form>
    </div>
  </div>
</div>

    <script>
        $(document).ready(function (){
            $(document).on('click', '.view-data', function(){
                           
                
                var id_input = $(this).attr("id");
                // Verificar se há valor no id
                if(id_input !== ''){
                    var dados = {
                        id_input: id_input
                    }
                    
                    $.post('visualizar.php', dados, function(retorna){  
                        // Carregar o conteúdo para o usuário
                        $('#infos_gpu').html(retorna)
                        $('#select_gpu_update').select2({
                            width: '160px'
                        });
                    })
                }
            })
        })
                
    </script>
    <script>
        if(window.screen.width <= 1590){
            var qntd_result_pg = 10; // Quantidade de registros por página
            
        }else{
            var qntd_result_pg = 12; // Quantidade de registros por página
        }

       
        
        var pagina = 1; // Inicia pela página 1
        $(document).ready(function (){
            listar_usuario(pagina, qntd_result_pg)
        })

        function listar_usuario(pagina, qntd_result_pg){
            var dados = {
                qntd_result_pg: qntd_result_pg,
                pagina: pagina
            }
            $.post('listar_gpu.php', dados, function(retorna){
                // Substitui o valor no seletor id = "conteudo"
                $('#conteudo').html(retorna)
            })
        }
        
    </script>
    

    <script src="js/selectgpu.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/5.7.0/d3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php include_once('js/chart.php'); ?>
    <script src="adiciona_gpu-ajax.js"></script>
    <script src="js/visao_geral-ajax.js"></script>
    <script src="js/excluir-gpu.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    

</body>
</html>
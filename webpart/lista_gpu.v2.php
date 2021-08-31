<?php
    include_once('config.php');
    $id = $_SESSION['id'];

    //Paginação - Somar a quantidade de inputs

    $resultado_pg = mysqli_query($conection, "SELECT COUNT(id_input) as num_result from inputs where id_user = $id");
    $row_pg = mysqli_fetch_assoc($resultado_pg);

    //Qntd de paginas
    $quantidade_pg = ceil($row_pg['num_result'] / 12);

    $pagina = $quantidade_pg;
    $qntd_result_pg = filter_input(INPUT_POST, 'qntd_result_pg', FILTER_SANITIZE_NUMBER_INT);
    //calcular o inicio visualização
    $inicio = ($pagina * $qntd_result_pg) - $qntd_result_pg;
    $qntd_result_pg = $qntd_result_pg;

    //consultar no banco de dados
    $consulta = mysqli_query($conection,"SELECT * from inputs where id_user = '$id' LIMIT $inicio, 12");

    $c = 0;
    while ($row = mysqli_fetch_assoc($consulta)){
        $c = $c + 1;
        $id_input = $row['id_input'];
        echo "<div class ='devices_styles animation_devices'>";
        echo "<div class = 'qtnd'>" . $row['qntd'] . "<br>" . "</div>";
        echo  "<a href='exclui_gpu.php?id=$id_input'><img src='img/trash.png' class = 'img-excluir' alt='' srcset=''> </a>";
        echo  "<a><img src='img/caneta-roller.png' class = 'view-data' id=$id_input alt='' srcset='' data-toggle='modal' data-target='.bd-example-modal-sm'></a>";
        echo "<div class = 'nome_GPU'>" . $row['GPU'] . "<br>" . "</div>";
        echo "R$ " . $row['preco'] . "<br>";
        echo $row['hashrate'] . " Mh/s";
        echo "</div>";
    }

    //Limitar o link antes e depois
    $max_links = 1;

    echo "<div class ='vaifuncionar'>";
    echo "<a onclick='listar_usuario(1, 12)'> <div class = 'paginacao-position'> <img src='img/pontas-de-flecha-de-contorno-fino-a-esquerda.png' alt=''> </div> </a>";

    if($pagina == $quantidade_pg){
        $pagina3 = $pagina - 2;
        if($pagina3 >= 1){
        echo "<a onclick='listar_usuario($pagina3, 12)'> $pagina3 </a>";
        }
    }

    $qntd_pag_anterior = 0;
    $qntd_pag_depois = 0;
    for($pag_ant = $pagina - $max_links; $pag_ant<= $pagina - 1; $pag_ant++){
        if($pag_ant >= 1){
        echo "<a onclick='listar_usuario($pag_ant, 12)'> $pag_ant </a>";
        $qntd_pag_anterior = $qntd_pag_anterior + 1;
        }

    }

    echo "<a> <div class = 'pag_atual'>$pagina </div> </a>";

    for($pag_dps = $pagina + 1; $pag_dps <= $pagina + $max_links; $pag_dps++){
        if($pag_dps <= $quantidade_pg){
            echo "<a onclick='listar_usuario($pag_dps, 12)'> $pag_dps </a>";
            $qntd_pag_depois = $qntd_pag_depois + 1;
        }
        if($qntd_pag_anterior == 0){
            $pagina2 = $pagina + 2;
            if($pagina2 <= $quantidade_pg){
            echo "<a onclick='listar_usuario($pagina2, 12)'> $pagina2 </a>";
            $qntd_pag_depois = $qntd_pag_depois + 1;
            }
        }
    }

    echo "<a onclick='listar_usuario($quantidade_pg, 12)'><img src='img/pontas-de-flechas-direitas.png' alt='' srcset=''></a>";
    echo "</div>";
    
?>
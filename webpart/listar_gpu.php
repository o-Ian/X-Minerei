<?php
    include_once('config.php');
    $id = $_SESSION['id'];

    $pagina = filter_input(INPUT_POST, 'pagina', FILTER_SANITIZE_NUMBER_INT);
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
        echo "<div class ='devices_styles'>";
        echo "<div class = 'qtnd'>" . $row['qntd'] . "<br>" . "</div>";
        echo  "<a href='exclui_gpu.php?id=$id_input'><img src='img/trash.png' class = 'img-excluir' alt='' srcset=''> </a>";
        echo "<div class = 'nome_GPU'>" . $row['GPU'] . "<br>" . "</div>";
        echo "R$ " . $row['preco'] . "<br>";
        echo $row['hashrate'] . " Mh/s";
        echo "</div>";
    }
    //Paginação - Somar a quantidade de inputs

    $resultado_pg = mysqli_query($conection, "SELECT COUNT(id_input) as num_result from inputs where id_user = $id");
    $row_pg = mysqli_fetch_assoc($resultado_pg);

    //Qntd de paginas
    $quantidade_pg = ceil($row_pg['num_result'] / 12);

    //Limitar o link antes e depois
    $max_links = 2;


    echo "<a href = '#' onclick='listar_usuario(1, 12)'> Primeira </a>";

    
    for($pag_ant = $pagina - $max_links; $pag_ant<= $pagina - 1; $pag_ant++){
        if($pag_ant >= 1){
        echo "<a href = '#' onclick='listar_usuario($pag_ant, 12)'> $pag_ant </a>";
        }
    }

    echo "<a href = '#' > $pagina </a>";
    echo "<a href = '#' onclick='listar_usuario($quantidade_pg, 12)'> Última </a>"
    
?>
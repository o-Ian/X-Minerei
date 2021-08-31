<?php 

$id_gpu = $_GET['id']; 

?>

<script 
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous">
</script>

<script>
     $('.img-excluir').click(function(e){  
        e.preventDefault()
        console.log('CLICOU E TA ENTRANDO NA EXCLUSAO')
        console.log(<?=$id_gpu;?>)
        //Mandando o $id_gpu para o arquivo exclui_gpu.php
        $.ajax
    ({
        //Configurações
        type: 'POST',//Método que está sendo utilizado.
        dataType: 'html',//É o tipo de dado que a página vai retornar.
        url: 'exclui_gpu.php',//Indica a página que está sendo solicitada.        
        //Dados para envio
        data: {
            id_gpu: <?=$id_gpu;?>
        }
    })
    //Fazer os cálculos e atualizá-los novamente
    $.post('data-manipulation.php', function(retorna){
            obj_retorna = JSON.parse(retorna)
            
            
            $('#avg_profit_day').html('')
            $('#avg_profit_day').html('R$ ' + obj_retorna.avg_profit_day)
    
            $('#avg_cost_day').html('')
            $('#avg_cost_day').html('R$ ' + obj_retorna.avg_cost_day)
    
            $('#avg_revenue_day').html('')
            $('#avg_revenue_day').html('R$ ' + obj_retorna.avg_revenue_day)
    
            $('#cost_revenue_indicator').html('')
            $('#cost_revenue_indicator').html(obj_retorna.cost_revenue_indicator + '%')
    
            $('#profit_revenue_indicator').html('')
            $('#profit_revenue_indicator').html(obj_retorna.profit_revenue_indicator + '%')
    
            $('#gpuPrice_return_indicator').html('')
            $('#gpuPrice_return_indicator').html(obj_retorna.gpuPrice_return_indicator + 'X')
    
            $('#avg_payItself_day').html('')
            $('#avg_payItself_day').html('Se paga em ' + obj_retorna.avg_payItself_day + ' meses')
    
            //TESTING
            console.log(obj_retorna.Date_UTC)
            console.log(obj_retorna.EnergyCost_Revenue)
    
    
            chart.data.labels = obj_retorna.Date_UTC;
            chart.data.datasets[0].data = obj_retorna.EnergyCost_Revenue;
            chart.update();
    
    
    
    })     
    })
 </script>   
    
    $('#form_adiciona_pgu').submit(function(e){   
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
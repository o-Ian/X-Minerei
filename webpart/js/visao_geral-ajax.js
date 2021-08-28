    
    $('#form_adiciona_pgu').submit(function(e){   
    $.post('data-manipulation.php', function(retorna){
        // Substitui o valor no seletor id = "conteudo"
        obj_retorna = JSON.parse(retorna)
        console.log(obj_retorna.avg_profit_day)
        $('#avg_profit_day').html('')
        $('#avg_profit_day').html('R$ ' + obj_retorna.avg_profit_day)
        //console.log(retorna.data_manipulation['avg_profit_day'])
    })
    console.log('TA ENTRNADO')  
    /*console.log('TA ENTRNADO')
    var meupau = 123213132
    $.ajax
    ({
        type: 'POST',
        data: {meupau: meupau},
        dataType: 'json',
        url: '../data-manipulation.php'
    }).done(function(data){
        console.log(data)
        
    })*/

})

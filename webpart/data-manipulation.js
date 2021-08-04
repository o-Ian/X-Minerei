$(document).ready(function (){
    $.post('data-manipulation.php', function(retorna){
        $('#conteudo').html(retorna)
    })
})
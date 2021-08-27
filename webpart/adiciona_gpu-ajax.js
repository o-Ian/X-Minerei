$('#form_adiciona_pgu').submit(function(e){
    e.preventDefault()
    console.log("VÁ TOM ANO CU ") 
    let form_adiciona_pgu = document.querySelector('#form_adiciona_pgu')
    let quantidade_adiciona_gpu = document.querySelector('#quantidade_adiciona_gpu')
    let hashrate_adiciona_gpu = document.querySelector('#hashrate_adiciona_gpu')
    let potencia_adiciona_gpu = document.querySelector('#potencia_adiciona_gpu')
    let tarifa_adiciona_gpu = document.querySelector('#tarifa_adiciona_gpu')
    let preco_gpu_adiciona_pgu = document.querySelector('#preco_gpu_adiciona_pgu')
    let select_adiciona_gpu = document.getElementById('gpu')
    let submit2 = document.getElementById('submit2')
    $.ajax
    ({
        //Configurações
        type: 'POST',//Método que está sendo utilizado.
        dataType: 'html',//É o tipo de dado que a página vai retornar.
        url: 'adiciona_gpu.php',//Indica a página que está sendo solicitada.        
        //Dados para envio
        data: {
            form_adiciona_pgu: form_adiciona_pgu.value,
            quantidade_adiciona_gpu: quantidade_adiciona_gpu.value,
            hashrate_adiciona_gpu: hashrate_adiciona_gpu.value,
            potencia_adiciona_gpu: potencia_adiciona_gpu.value,
            tarifa_adiciona_gpu: tarifa_adiciona_gpu.value,
            preco_gpu_adiciona_pgu: preco_gpu_adiciona_pgu.value,
            select_adiciona_gpu: select_adiciona_gpu.options[select_adiciona_gpu.selectedIndex].value
        }
    }).done(function(data){
        $('#quantidade_adiciona_gpu').val('1')
        $('#hashrate_adiciona_gpu').val('')
        $('#gpu').val('default').select2()
        $('#potencia_adiciona_gpu').val('')
        $('#tarifa_adiciona_gpu').val('')
        $('#preco_gpu_adiciona_pgu').val('')
        

    })
})  
    



/*form_adiciona_pgu.addEventListener('submit', function(event){
    event.preventDefault()
let dados = {
    form_adiciona_pgu: form_adiciona_pgu.value,
    quantidade_adiciona_gpu: quantidade_adiciona_gpu.value,
    hashrate_adiciona_gpu: hashrate_adiciona_gpu.value,
    potencia_adiciona_gpu: potencia_adiciona_gpu.value,
    tarifa_adiciona_gpu: tarifa_adiciona_gpu.value,
    preco_gpu_adiciona_pgu: preco_gpu_adiciona_pgu.value,
    select_adiciona_gpu: select_adiciona_gpu.options[select_adiciona_gpu.selectedIndex].value
    }
    console.log(dados)

var xmlhttp = new XMLHttpRequest()
xmlhttp.open("POST", "adiciona_gpu.php", true)
xmlhttp.send(dados)

})*/

<?php
if(isset($_POST['id_input'])){
    include_once('config.php');
    ?>
    <script>
        var c = 0
        var select = document.getElementById('select_gpu_update')
        select_value_antes = select.options[select.selectedIndex].value
        var preco_update_antes = document.getElementById('preco_update_gpu').value
        var hashrate_antes = document.getElementById('hashrate_update').value
        var qntd_antes = document.getElementById('qntd_update').value
        var potencia_w_antes = document.getElementById('potencia_update').value
        var tarifa_energia_antes = document.getElementById('tarifa_update').value
        


                $(document).on('click', '#submit_update_gpu', function(e){
                    e.preventDefault()
                    var select = document.getElementById('select_gpu_update')
                    select_value = select.options[select.selectedIndex].value
                    var preco = document.getElementById('preco_update_gpu')
                    var hashrate = document.getElementById('hashrate_update')
                    var qntd = document.getElementById('qntd_update')
                    var cor_select = document.querySelectorAll('.select2-selection--single')
                    var potencia_w = document.getElementById('potencia_update')
                    var tarifa_energia = document.getElementById('tarifa_update')


                    select_certo = cor_select[1]

                    if (select_value == select_value_antes && preco.value == preco_update_antes && hashrate.value == hashrate_antes && qntd.value == qntd_antes && potencia_w_antes == potencia_w.value && tarifa_energia_antes == tarifa_energia.value){
                        console.log('AQUI TÁ ENTRANADO LHA')
                        select_certo.classList.add("errorInput")
                        preco.classList.add("errorInput")
                        hashrate.classList.add("errorInput")
                        qntd.classList.add("errorInput")
                        potencia_w.classList.add("errorInput")
                        tarifa_energia.classList.add("errorInput")

                    }   
                    else{                     
                        if(c == 0){  
                        console.log('É PRA DAR')
                        select_certo.classList.remove("errorInput")
                        preco.classList.remove("errorInput")
                        hashrate.classList.remove("errorInput")
                        qntd.classList.remove("errorInput")
                        potencia_w.classList.remove("errorInput")
                        tarifa_energia.classList.remove("errorInput")
                        

                        var hashrate_update = hashrate.value
                        var GPU_update = select_value
                        var preco_update_gpu = preco.value
                        var qntd_update = qntd.value
                        var tarifa_energia_update = tarifa_energia.value
                        var potencia_update = potencia_w.value


                        
                        // Mandar o update
                        $.ajax
                        ({
                            //Configurações
                            type: 'POST',//Método que está sendo utilizado.
                            dataType: 'html',//É o tipo de dado que a página vai retornar.
                            url: 'update_gpu.php',//Indica a página que está sendo solicitada.        
                            //Dados para envio
                            data: {
                                hashrate_update: hashrate.value,
                                GPU_update: select_value,
                                preco_update_gpu: preco.value,
                                qntd_update: qntd.value,
                                tarifa_energia_update: tarifa_energia.value,
                                potencia_update: potencia_w.value, 
                                
                                
                                select_value_antes: select_value_antes,
                                preco_update_antes: preco_update_antes,
                                qntd_antes : qntd_antes,
                                tarifa_energia_antes: tarifa_energia_antes,
                                potencia_w_antes: potencia_w_antes, 
                                hashrate_antes: hashrate_antes
                            }
                        }).done(function(data){
                            console.log("TUDO O QUE MANDA PRA BANDA: " + data)

                            //Atualizar conteúdo das peças
                            var qntd_result_pg = 12; // Quantidade de registros por página
                            var pagina = 1; // Inicia pela página 1
                            $(document).ready(function (){
                            listar_usuario(pagina, qntd_result_pg)
                            })

                            function listar_usuario(pagina, qntd_result_pg){
                                var dados = {
                                    qntd_result_pg: qntd_result_pg,
                                    pagina: pagina
                                }
                                $.post('lista_gpu.v3.php', dados, function(retorna){
                                    // Substitui o valor no seletor id = "conteudo"
                                    $('#conteudo').html(retorna)
                                })
                            }


                        //Atualizar dados do visão geral
                            $.post('data-manipulation.php', function(retorna){
                                obj_retorna = JSON.parse(retorna)
                                
                                $('#avg_profit_day').html('')
                                $('#avg_profit_day').html('R$  ' + obj_retorna.avg_profit_day)

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


                                chart.data.labels = obj_retorna.Date_UTC;
                                chart.data.datasets[0].data = obj_retorna.EnergyCost_Revenue;
                                chart.update();
                                })
                        })
                        c = c + 1
                        $('.modal').modal('hide'); 

                    }
                    }

                    
                    
                

                })
                
        </script>
    <?php
    $busca = mysqli_query($conection, "SELECT * from inputs where id_input = '" . $_POST['id_input'] . "' ");
    $rows = mysqli_fetch_assoc($busca);
    $gpu = $rows['GPU'];
    $preco = $rows['preco'];
    $hashrate = $rows['hashrate'];
    $qntd = $rows['qntd'];
    $potencia = $rows['potencia_w'];
    $tarifa_energia = $rows['tarifa_energia_real'];
    //Putting all data in sessions
    $_SESSION['gpu_update'] = $gpu;
    $_SESSION['preco_update'] = $preco;
    $_SESSION['hashrate_update'] = $hashrate;
    $_SESSION['qntd_update'] = $qntd;
    $_SESSION['id_input'] = $_POST['id_input'];
    $_SESSION['potencia_update'] = $potencia;
    $_SESSION['tarifa_energia_update'] = $tarifa_energia;


    echo "<div class = 'select-modal-box'>Dispositivo: <select id='select_gpu_update' style= 'width: 280px' name='GPU_update'>
    <option value='$gpu' selected>$gpu</option>
    <optgroup label='GTX'>
        <option value='GTX 1050'>GTX 1050</option>
        <option value='GTX 1060'>GTX 1060</option>
        <option value='GTX 1080'>GTX 1080</option>
    </optgroup>
    </select></div>";
    echo "<div>Qntd: <input type='number' min ='1' class ='form-gpu_update2 att-qntd-modal-box' id = 'qntd_update' name='qntd_update' value= '$qntd'></div>";
    echo "<div class = 'preco_update'>Preço: <span class='input-group-addon-preco'>R$</span><input type='number' min ='0' class ='form-gpu_update' name='preco_update_gpu' id = 'preco_update_gpu' value= '$preco'> </span></div>";
    echo "<div>Hashrate: <input type='number' min ='0' class ='form-gpu_update2' id = 'hashrate_update' name='hashrate_update' value= '$hashrate'><span class='input-group-addon-preco'>Mh/s</span></div>";
    echo "<div>Potência: <input type='number' min ='0' class ='form-gpu_update2' id = 'potencia_update' name='potencia_update' value= '$potencia'><span class='input-group-addon-preco'>W</span></div>";
    echo "<div class = 'tarifa-modal-box'>Tarifa energia: <input type='number' min ='0.01' step = 'any' class ='form-gpu_update3' id = 'tarifa_update' name='potencia_update' value= '$tarifa_energia'><span class='input-group-addon-preco2'>R$ / kWh</span></div>";

    
    echo "<input type = 'submit' name='submit_update_gpu' id='submit_update_gpu' class='btn2' value='Atualizar'>";
    
}
else{
    echo "NÃO DEU";
}

?>
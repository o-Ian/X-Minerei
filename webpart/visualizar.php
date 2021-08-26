<?php
if(isset($_POST['id_input'])){
    include_once('config.php');
    ?>
    <script>
        var select = document.getElementById('select_gpu_update')
        select_value_antes = select.options[select.selectedIndex].value
        var preco_update_antes = document.getElementById('preco_update_gpu').value
        var hashrate_antes = document.getElementById('hashrate_update').value
        var qntd_antes = document.getElementById('qntd_update').value
        


                $(document).on('click', '#submit_update_gpu', function(){
                    console.log('DEU CERTO ESSA PORA???')
                    var select = document.getElementById('select_gpu_update')
                    select_value = select.options[select.selectedIndex].value
                    console.log(select_value)
                    var preco = document.getElementById('preco_update_gpu')
                    console.log(preco.value)
                    var hashrate = document.getElementById('hashrate_update')
                    var qntd = document.getElementById('qntd_update')
                    var cor_select = document.querySelectorAll('.select2-selection--single')
                    select_certo = cor_select[1]

                    if (select_value == select_value_antes && preco.value == preco_update_antes && hashrate.value == hashrate_antes && qntd.value == qntd_antes){
                        select_certo.classList.add("errorInput")
                        preco.classList.add("errorInput")
                        hashrate.classList.add("errorInput")
                        qntd.classList.add("errorInput")
                        event.preventDefault()
                    }   
                    else{
                        console.log('É PRA DAR')
                        select_certo.classList.remove("errorInput")
                        preco.classList.remove("errorInput")
                        hashrate.classList.remove("errorInput")
                        qntd.classList.remove("errorInput")
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
    //Putting all data in sessions
    $_SESSION['gpu_update'] = $gpu;
    $_SESSION['preco_update'] = $preco;
    $_SESSION['hashrate_update'] = $hashrate;
    $_SESSION['qntd_update'] = $qntd;
    $_SESSION['id_input'] = $_POST['id_input'];


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

    echo "<input type = 'submit' name='submit_update_gpu' id='submit_update_gpu' class='btn2' value='Atualizar'>";
    
}
else{
    echo "NÃO DEU";
}

?>
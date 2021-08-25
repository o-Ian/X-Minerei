<?php
if(isset($_POST['id_input'])){
    include_once('config.php');

    $busca = mysqli_query($conection, "SELECT * from inputs where id_input = '" . $_POST['id_input'] . "' ");
    $rows = mysqli_fetch_assoc($busca);
    $gpu = $rows['GPU'];
    $preco = $rows['preco'];
    $hashrate = $rows['hashrate'];
    //Putting all data in sessions
    $_SESSION['gpu_update'] = $gpu;
    $_SESSION['preco_update'] = $preco;
    $_SESSION['hashrate_update'] = $hashrate;
    $_SESSION['id_input'] = $_POST['id_input'];

    echo "<div>Dispositivo: <select id='select_gpu_update' style= 'width: 280px' name='GPU_update'>
    <option value='$gpu' selected>$gpu</option>
    <optgroup label='GTX'>
        <option value='GTX 1050'>GTX 1050</option>
        <option value='GTX 1060'>GTX 1060</option>
        <option value='GTX 1080'>GTX 1080</option>
    </optgroup>
    </select></div>";
    echo "<div class = 'preco_update'>Preço: <span class='input-group-addon-preco'>R$</span><input type='number' class ='form-gpu_update' name='preco_update_gpu' id = 'preco_update_gpu' value= '$preco'> </span></div>";
    echo "<div>Hashrate: <input type='number' class ='form-gpu_update2' id = 'hashrate_update' name='hashrate_update' value= '$hashrate'><span class='input-group-addon-preco'>Mh/s</span></div>";

    echo "<input type = 'submit' name='submit_update_gpu' id='submit_update_gpu' class='btn2' value='Atualizar'>";
    
}
else{
    echo "NÃO DEU";
}

?>
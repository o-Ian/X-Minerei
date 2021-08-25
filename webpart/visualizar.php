<?php
if(isset($_POST['id_input'])){
    include_once('config.php');

    $busca = mysqli_query($conection, "SELECT * from inputs where id_input = '" . $_POST['id_input'] . "' ");
    $rows = mysqli_fetch_assoc($busca);
    echo $rows['GPU'];
}
else{
    echo "NÃO DEU";
}

?>
<?php
include_once("data-manipulation.php");
?>
<div id="array"><?=$Profit_day_BRL;?></div>


<script>
        $(document).ready(function(){
  var dadosJson = $("#array").html();
  console.log(dadosJson);

})
    </script>
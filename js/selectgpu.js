$(document).ready(function() {
    $('#gpu').select2({
        placeholder: {
            id: 'default', // the value of the option
            text: 'Qual sua placa de vídeo?'
          }
    });
});
$(document).ready(function() {
    $('#gpu_update').select2();
});

var preco_update_antes = document.getElementById('preco_update_gpu')
                console.log(preco_update_antes) 

                $(document).on('click', '#submit_update_gpu', function(){
                    var select = document.getElementById('select_gpu_update')
                    select_value = select.options[select.selectedIndex].value
                    console.log(select_value)
                    var preco = document.getElementById('preco_update_gpu')
                    console.log(preco.value)
                    var hashrate = document.getElementById('hashrate_update')
                    var cor_select = document.querySelectorAll('.select2-selection--single')
                    select_certo = cor_select[1]

                    if (select_value == "<?=$_SESSION['gpu_update'];?>" && preco.value == <?=$_SESSION['preco_update'];?> && hashrate.value == <?=$_SESSION['hashrate_update'];?>){
                        select_certo.classList.add("errorInput")
                        preco.classList.add("errorInput")
                        hashrate.classList.add("errorInput")
                        event.preventDefault()
                    }   
                    else{
                        console.log('É PRA DAR')
                        select_certo.classList.remove("errorInput")
                        preco.classList.remove("errorInput")
                        hashrate.classList.remove("errorInput")
                    }

                })
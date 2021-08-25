<script>
const button = document.getElementById('submit_update_gpu')

button.addEventListener('click', (event) => {

    const select = document.getElementById('select_gpu_update')
    const preco = document.getElementById('preco_update_gpu')
    const hashrate = document.getElementById('hashrate_update')
    console.log(select.value)
    if (select.value == <?=$_SESSION['gpu_update'];?> && preco.value == <?=$_SESSION['preco_update'];?> && hashrate.value == <?=$_SESSION['hashrate_update'];?>){
        preco.classList.add("errorInput")
        event.preventDefault()
    }   
    else{
        preco.classList.remove("errorInput")
    }
    exit
})    
</script>
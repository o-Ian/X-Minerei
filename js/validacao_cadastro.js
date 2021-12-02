const button = document.getElementById('submit')

button.addEventListener('click', (event) => {

    const nome = document.getElementById('nome')
    const email = document.getElementById('email')
    const senha = document.getElementById('senha')
    const senhaConfir = document.getElementById('senhaconf')

    if (nome.value == ''){
        nome.classList.add("errorInput")
        event.preventDefault()
    }   else{
        nome.classList.remove("errorInput")
    }
    
    if (senha.value == '' || senha.value.length < 6 || (senha.value != senhaConfir.value)) {
        senha.classList.add("errorInput")
        event.preventDefault()
    }   else{
        senha.classList.remove("errorInput")   
    }
  
    if (senhaConfir.value == '' || (senhaConfir.value != senha.value) || senhaConfir.value.length < 6){
        senhaConfir.classList.add("errorInput")
        event.preventDefault()
    }   else{
        senhaConfir.classList.remove("errorInput")
    }
    if (email.value == '' || email.value.indexOf("@") == -1 || email.value.indexOf(".") == -1 || (email.value.indexOf(".") - email.value.indexOf("@")) == 1){
        email.classList.add("errorInput")
        event.preventDefault()
    }   else{
        email.classList.remove("errorInput")
    }
    exit
} )    

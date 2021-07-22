const button = document.getElementById('submit')

button.addEventListener('click', (event) => {

    const email = document.getElementById('email')
    const senha = document.getElementById('password')
    
    if (invalido) {
        senha.classList.add("errorInput")
        event.preventDefault()
    }   else{
        senha.classList.remove("errorInput")
        
    }
    if (email.value == '' || email.value.indexOf("@") == -1 || email.value.indexOf(".") == -1 || (email.value.indexOf(".") - email.value.indexOf("@")) == 1){
        email.classList.add("errorInput")
        event.preventDefault()
    }   else{
        email.classList.remove("errorInput")
    }
} )    

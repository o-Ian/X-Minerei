const nav = document.getElementsByClassName('superior');
const topnav = nav.offsetTop;

window.onscroll = function(){
    topfix;
}

function topfix(){
    if(window.pageYOffset >= topnav){
        nav.classList.add('top-fixed');
    }else{
        nav.classList.remove('top-fixed');
    }
}
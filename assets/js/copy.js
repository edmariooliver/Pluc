function copy_origi(){
    let btn = document.getElementById("btn-cp-or")
    let link =  document.getElementById("complete-link")
    link.select
    document.execCommand('copy')
    btn.innerText = "Pronto"
    link.select

}
function copy_encurt(){
    let btn = document.getElementById("btn-cp-en")
    let link =  document.getElementById("encurt-link")
    link.select
    document.execCommand('copy')
    btn.innerText = "Pronto"
}
function onDown(){
    let btn1 = document.getElementById("btn-cp-en")
    let btn2 = document.getElementById("btn-cp-or")
    btn1.innerText = "Copiar"
    btn2.innerText = "Copiar"

}
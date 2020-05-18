if (
    document.readyState === "complete" ||
    (document.readyState !== "loading" && !document.documentElement.doScroll)
) {
  onLoad()
} else {
  document.addEventListener("DOMContentLoaded", onLoad)
}
var mobileMenuIsOpen=false

function onLoad(){
  fontify("#nav-header-pc ul li")
  fontify("#nav-header-mobile ul li")
  document.querySelector("#menu-expand i").addEventListener('click', openOrCloseMobileNavMenu)
}
function unblacken(){
  let headerAndFooterOpaques = document.getElementsByClassName("blackout")
  for(let i = 0; i < headerAndFooterOpaques.length; i++){
    headerAndFooterOpaques[i].style.opacity = ".7"
    setTimeout(()=>{
      headerAndFooterOpaques[i].style.zIndex = "-1"
    },200)
  }

}
function blackOut(){
  let headerAndFooterOpaques = document.getElementsByClassName("blackout")
  for(let i = 0; i < headerAndFooterOpaques.length; i++){
    headerAndFooterOpaques[i].style.zIndex = "0"
    headerAndFooterOpaques[i].style.opacity = ".7"
  }
}
function closeMobileNavMenu(){
  document.querySelector("#menu-expand i").classList.replace("fa-times", "fa-bars")
  document.getElementById("menu-expand").style.marginRight="16px"
  unblacken()
  document.querySelector("main").style.opacity = "1"
  document.getElementById("nav-header-mobile").style.transform = "translateY(-100%)"
}
function openMobileNavMenu(){
  document.querySelector("#menu-expand i").classList.replace("fa-bars", "fa-times")
  document.getElementById("menu-expand").style.marginRight = "20px"
  blackOut()
  setTimeout(()=>{
    document.getElementById("nav-header-mobile").style.transform = "translateY(0)"
  },100)
}
function openOrCloseMobileNavMenu(){
  if(mobileMenuIsOpen){
    closeMobileNavMenu()
  }
  else {
    openMobileNavMenu()
  }
  mobileMenuIsOpen = !mobileMenuIsOpen
}
function fontify(query){
  let listItems = document.querySelectorAll(query)
  for(let i = 0; i < listItems.length; i++){
    let innerText = listItems[i].innerHTML
    let individualWords = innerText.split(" ")
    let outputString = ""
    for(let j = 0; j < individualWords.length; j++){
      let str = individualWords[j]
      outputString += '<span class="pointed-text">'
      outputString += str.substring(0, 1)
      outputString += "</span>"
      outputString += '<span class="vacer-text">'
      outputString += str.substring(1, str.length)
      outputString += "</span> "
    }
    listItems[i].innerHTML = outputString
  }
}

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
  fontifyAndColorize("h1")
  document.querySelector("#menu-expand i").addEventListener('click', openOrCloseMobileNavMenu)
}
function colorizeParagraphs(){
  let paragraphs = document.querySelectorAll("p")
  for(let i = 0; i < paragraphs.length; i++){
    let paragraphText= paragraphs[i].innerText
    let outputString = ""
    for(let j = 0; j < paragraphText.length; j++){
      let charCode = paragraphText.charCodeAt(j)
      if((charCode > 32 && charCode < 48)||(charCode > 57 && charCode < 65)||(charCode > 90 && charCode < 97)||(charCode > 122 && charCode < 127)){
        outputString += "<span class=\"blue-text\">" + paragraphText.substring(j, j+1) + "</span>"
      }
      else {
        outputString += paragraphText.substring(j, j+1)
      }
      paragraphs[i].innerHTML = outputString
    }
  }
}
function getNextColor(color){
  switch(color){
    case "red": {return "yellow"; break;}
    default: {return "red"; break;}
  }
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
function fontifyAndColorize(query){
  let elements = document.querySelectorAll(query)

  for(let i = 0; i < elements.length; i++){
    let outputString = ""
    let color="red"
    let currentElement = elements[i]
    let currentElementText = currentElement.innerText
    currentElement.innerHTML = currentElement.innerText
    let regexUpperCase = /[A-Z]/
    console.log(currentElementText)

    for(let j = 0; j < currentElementText.length; j++){
      let currentLetter = currentElementText.substring(j, j+1)

      if(currentLetter !== " "){
        let fontClass = regexUpperCase.test(currentLetter) ? "pointed-text-lg" : "vacer-text-lg"
        let colorClass = charIsLetter(currentLetter) ? color + "-text" : "orange-text"
        outputString += "<span class=\""
        outputString += fontClass
        outputString += " "
        outputString += colorClass
        outputString += "\">"
        outputString += currentLetter.toUpperCase()
        outputString += "</span>"
      }
      else {
        outputString += " "
      }

      if(charIsLetter(currentLetter)&&currentLetter!==" "){
        color = getNextColor(color)
      }
    }
    currentElement.innerHTML = outputString
  }
}
function charIsLetter(char){
  let charCode = char.charCodeAt(0)

  if(charCode>=65&&charCode<=90){
    return true
  }
  else if(charCode>=97&&charCode<=122){
    return true
  }
  return false
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

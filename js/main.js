if (
    document.readyState === "complete" ||
    (document.readyState !== "loading" && !document.documentElement.doScroll)
) {
  onLoad()
} else {
  document.addEventListener("DOMContentLoaded", onLoad)
}
var mobileMenuIsOpen=false
var languageDropdownIsOpen = false
var documentBody
var languageExpandVisible
var languageDropdownMenu
var languageSelections = document.querySelectorAll('#language-dropdown-menu ul li')
var currentLanguageSelection

function onLoad(){
  setVariables()
  fontify("#nav-header-pc ul li a")
  fontify("#nav-header-mobile ul li a")
  fontify("h1")
  document.querySelector("#menu-expand i").addEventListener('click', openOrCloseMobileNavMenu)
  let blackouts = document.querySelectorAll(".blackout")
  for(let i = 0; i < blackouts.length; i++){
    blackouts[i].addEventListener('click', openOrCloseMobileNavMenu)
  }
  languageExpandVisible.addEventListener('click', openOrCloseLanguageDropdown)

  for(let i = 0; i < languageSelections.length; i++){
    languageSelections[i].addEventListener('click', changeLanguage)
  }

  window.addEventListener('resize', onResize)

  let hasShownCookieNotice = getCookie("hasShownCookieNotice")
  if (hasShownCookieNotice === "true"){
    document.getElementById("cookie-notice").style.visibility = "hidden"
  }
  else{
    document.querySelector("#cookie-notice button").addEventListener("click", closeCookieNotice)
  }
}
function onResize(){

}
function setVariables(){
  documentBody = document.querySelector("body")
  languageExpandVisible = document.getElementById("lang-expand-visible")
  languageDropdownMenu = document.getElementById("language-dropdown-menu")
}
function getCookie(cookieName){
  let name = cookieName + "="
  let decodedCookie = decodeURIComponent(document.cookie)
  let cookieSplit = decodedCookie.split(";")
  for(let i = 0; i < cookieSplit.length; i++){

    let str = cookieSplit[i].trim()
    if(str.indexOf(name)==0){
      return str.substring(name.length)
    }
    return false
  }

}
function setCookie(cookieName, cookieValue){
  let d = new Date()
  d.setTime(d.getTime() + (30*24*60*60*1000))
  let expires = "expires=" + d.toUTCString()
  let path1 = documentRootPath;
  let path2 = documentRootPath + "/news-item";
  document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/lostacosamigos"
  document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/lostacosamigos/news-item"
}
function closeCookieNotice(){
  let cookieNotice = document.getElementById("cookie-notice")
  cookieNotice.style.visibility = "hidden"
  setCookie("hasShownCookieNotice", "true")
}
function changeLanguage(e){
  let selectedLanguage = e.target.dataset.selectedlanguage
  document.cookie = "documentlanguage=" + selectedLanguage + ";path=/lostacosamigos"
  document.cookie = "documentlanguage=" + selectedLanguage + ";path=/lostacosamigos/news-item"
  let footerFinder = document.getElementsByClassName("news-page-footer")
  if(footerFinder.length>0){
    setTimeout(()=>{
      window.location.href = "http://192.168.1.232:8080/lostacosamigos/news"
    },0)
  }
  else{
    setTimeout(()=>{
      window.location.replace(window.location.href)
    })
  }

}
function openOrCloseLanguageDropdown(e){
  console.log('ffff')
  if(languageDropdownIsOpen){
    closeLanguageDropdown()
  }
  else {
    openLanguageDropdown()
  }
}
function openLanguageDropdown(){
  languageDropdownMenu.style.visibility = "visible"
  languageDropdownMenu.style.height = "auto"
  setTimeout(()=>{
    languageDropdownMenu.removeEventListener('click', openOrCloseLanguageDropdown)
  },0)
  setTimeout(()=>{
    documentBody.addEventListener('click', closeLanguageDropdown)
  },0)
  languageDropdownIsOpen = !languageDropdownIsOpen
}
function closeLanguageDropdown(){
  console.log("closing")
  languageDropdownMenu.style.visibility = "hidden"
  languageDropdownMenu.style.height = "0"
  setTimeout(()=>{
    languageDropdownMenu.addEventListener('click', openOrCloseLanguageDropdown)
  },0)
  setTimeout(()=>{
    documentBody.removeEventListener('click', closeLanguageDropdown)
  },0)
  languageDropdownIsOpen = !languageDropdownIsOpen
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
function charIsUppercase(char){
  let charCode = char.charCodeAt(0)
  if(charCode>=65&&charCode<=90){
    return true
  }
  return false
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
  let elementArray = document.querySelectorAll(query)

  for(let i = 0; i < elementArray.length; i++){
    let outputString = ""
    let currentElement = elementArray[i]
    let currentElementText = currentElement.innerText
    for(let j = 0; j < currentElementText.length; j++){
      let currentLetter = currentElementText.substring(j,j+1)
      if(charIsUppercase(currentLetter)){
        outputString += "<span class=\"pointed-text\">"
        outputString += currentLetter
        outputString += "</span>"
      }
      else {
        outputString += "<span class=\"vacer-text\">"
        outputString += currentLetter.toUpperCase()
        outputString += "</span>"
      }
    }
    elementArray[i].innerHTML = outputString
  }
}

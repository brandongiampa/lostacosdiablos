if (
    document.readyState === "complete" ||
    (document.readyState !== "loading" && !document.documentElement.doScroll)
) {
  onLoad()
} else {
  document.addEventListener("DOMContentLoaded", onLoad)
}

function onLoad(){
  fontify("#nav-header-pc ul li")
  fontify("#nav-header-mobile ul li")
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

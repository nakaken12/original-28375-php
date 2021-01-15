window.addEventListener("load", function(){

  const pullDownButton = document.getElementById("parents")
  const genreLists = document.getElementById("genre-lists")

  pullDownButton.addEventListener("mouseover", function(){
    genreLists.setAttribute("style", "display: block;");
  })

  pullDownButton.addEventListener("mouseout", function(){
    genreLists.setAttribute("style", "display: none;");
  })

});
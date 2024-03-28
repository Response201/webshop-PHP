
const btnContainer = document.getElementById("btnPages");


const btns = btnContainer.getElementsByClassName("btnPages");


for (let i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    let current = document.getElementsByClassName("active_btnPages");


    if (current.length > 0) {
      current[0].className = current[0].className.replace("active_btnPages", "");
    }


    this.className += " active_btnPages";
  });
}
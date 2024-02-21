
var modal = document.getElementById('myModal');

var img = document.querySelectorAll('#myImg');
var modalImg = document.getElementById("img01");
for (var i = 0; i < img.length; i++) {
img[i].onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    modalImg.alt = this.alt;
    
}
}
modal.onclick = function() {
    img01.className += " out";
    setTimeout(function() {
       modal.style.display = "none";
       img01.className = "modal-content";
     }, 400);
    
 }    
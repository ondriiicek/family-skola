var form = document.querySelector('.overlay');
var addButton = document.querySelector('.showInput');
var isThere = false;
addButton.addEventListener('click', function(){
  if( !isThere ){
    form.style.display = "block";
    //form.setAttribute('id','slideFromTopForm');
  }
})
// Height chat div -60px
const cempChatDiv = document.getElementById('cemp-chat-div');
cempChatDiv.classList.add('cemp-height-admin');

// Show or hide user list
const cempList = document.getElementById('cemp-list');
const cempListDisplay = document.getElementById('cemp-list-display');
var listDisplay = true;

cempListDisplay.addEventListener('click', function(){
  if(listDisplay){
    cempListDisplay.innerHTML = 'Mostrar Chats';
    cempList.style.display = 'none';
    listDisplay = false;
  }else {
    cempListDisplay.innerHTML = 'Ocultar Chats';
    cempList.style.display = 'block';
    listDisplay = true;
  }
});

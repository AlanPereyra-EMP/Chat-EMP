// Height chat div -60px
const cempChatDiv = document.getElementById('cemp-chat-div');
cempChatDiv.classList.add('cemp-height-admin');

// Show or hide user list
const cempList = document.getElementById('cemp-list');
const cempListDisplay = document.getElementById('cemp-list-display');
var listDisplay = true;
var cempChatReady = false;

cempListDisplay.addEventListener('click', function(){
  listShow();
});

function listShow(){
  if(listDisplay && cempChatReady){
    cempListDisplay.innerHTML = 'Mostrar Chats';
    cempList.classList.add('cemp-hide-list');
    listDisplay = false;
  }else if(cempChatReady){
    cempListDisplay.innerHTML = 'Ocultar Chats';
    cempList.classList.remove('cemp-hide-list');
    listDisplay = true;
  }
}

// Todo fecth list of chats
function cempGetChatList() {
  let data = new FormData();
  data.append( 'action', 'cemp_get_chat_list' );

  fetch(cempAjax.url, {
    method: 'POST',
    mode: 'same-origin',
    body: data
  })
  .then(res => res.json())
  .then(data => {
    cempList.innerHTML = `${data}`;
  });
}
cempGetChatList();

cempMessages.innerHTML = `
<div class="cemp-loading-div">
<p class="cemp-loading-p">Selecciona un chat para comenzar</p>
</div>`;
cempForm.style.display = 'none';

function cempGetThisChat(max, toId, fromId){
  cempNotificationPermission();
  cempNotification('Mensaje nuevo', 'Este es un mensaje de prueba');
  cempChatReady = true;
  cempMessages.style.display = 'none';
  cempGetMessages(max, toId, fromId);
}

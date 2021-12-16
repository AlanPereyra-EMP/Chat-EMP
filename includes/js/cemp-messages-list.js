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
    cempListDisplay.classList.remove('cemp-hide-list');
    cempList.classList.add('cemp-hide-list');
    listDisplay = false;
  }else if(cempChatReady){
    cempListDisplay.classList.add('cemp-hide-list');
    cempList.classList.remove('cemp-hide-list');
    listDisplay = true;
  }
}

// Todo fecth list of chats
function cempGetChatList() {
  let data = new FormData();
  data.append( 'action', 'cemp_get_chat_list' );

  setInterval(()=>{
    fetch(cempAjax.url, {
      method: 'POST',
      mode: 'same-origin',
      body: data
    })
    .then(res => res.json())
    .then(data => {
      cempList.innerHTML = `${data}`;
    });
  }, 2000);
}
cempGetChatList();

cempMessages.innerHTML = `
<div class="cemp-loading-div">
<p class="cemp-loading-p">Selecciona un chat para comenzar</p>
</div>`;
cempForm.style.display = 'none';

function cempGetThisChat(max, toId, fromId){
  cempNotificationPermission();
  cempChatReady = true;
  cempMessages.style.display = 'none';
  cempGetMessages(max, toId, fromId);
}

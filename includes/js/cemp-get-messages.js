var interval = '';
var currentChat = '';
var chatLoading = false;
var msgRequest = false;

function cempGetMessages(max, toId, fromId){
  clearInterval(interval);

  currentChat = [toId,fromId];

  msgRequest = new FormData();
  msgRequest.append( 'action', 'cemp_get_messages' );
  msgRequest.append( 'max', max );
  msgRequest.append( 'toId', toId );
  msgRequest.append( 'fromId', fromId );

  chatLoading = true;
  interval = setInterval(() => {loadindMsgs()}, 2000);
}

function loadindMsgs(afterSettings) {
  if(!msgRequest){
    return;
  }
  
  if(chatLoading){
    if (!afterSettings) {
      listShow();
    }
    cempRemoveSettings();
    afterSettings = false;
    chatLoading = false;

    cempForm.style.display = 'flex';
    cempMessages.style.display = 'block';
    cempMessages.innerHTML = `
    <div class="cemp-loading-div">
    <p class="cemp-loading-p">Cargando...</p>
    </div>`;
    cempChatName.innerHTML = 'Cargando...';
  }
  fetch(cempAjax.url, {
    method: 'POST',
    mode: 'same-origin',
    body: msgRequest
  })
  .then(res => res.json())
  .then(data => {
    isChatBottom();
    cempMessages.innerHTML = data.chat;
    cempChatName.innerHTML = data.chat_name;
    scrollDownChats();
  })
}

var interval = '';
var currentChat = '';
function cempGetMessages(max, toId, fromId){
  clearInterval(interval);

  currentChat = [toId,fromId];

  msgRequest = new FormData();
  msgRequest.append( 'action', 'cemp_get_messages' );
  msgRequest.append( 'max', max );
  msgRequest.append( 'toId', toId );
  msgRequest.append( 'fromId', fromId );

  interval = setInterval(loadindMsgs(), 2000);
}

function loadindMsgs(afterSettings) {
  var chatLoading = true;
  if(chatLoading){
    if (!afterSettings) {
      listShow();
    }
    cempRemoveSettings();
    afterSettings = false;
    cempForm.style.display = 'flex';
    cempMessages.style.display = 'block';
    cempMessages.innerHTML = `
    <div class="cemp-loading-div">
    <p class="cemp-loading-p">Cargando...</p>
    </div>`;
    cempChatName.innerHTML = 'Cargando...';
    chatLoading = false;
  }
  fetch(cempAjax.url, {
    method: 'POST',
    mode: 'same-origin',
    body: msgRequest,
  })
  .then(res => res.json())
  .then(data => {
    isChatBottom();
    cempMessages.innerHTML = data.chat;
    cempChatName.innerHTML = data.chat_name;
    scrollDownChats();
  })
}

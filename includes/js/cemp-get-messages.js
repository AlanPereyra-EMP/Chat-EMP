var interval = '';
var currentChat = '';
function cempGetMessages(max, chat){
  clearInterval(interval);
  currentChat = chat;

  msgRequest = new FormData();
  msgRequest.append( 'action', 'cemp_get_messages' );
  msgRequest.append( 'max', max );
  msgRequest.append( 'chat', chat );

  var chatLoading = true;
  interval = setInterval(()=>{
    if(chatLoading){
      listShow();
      cempForm.style.display = 'flex';
      cempMessages.style.display = 'block';
      cempMessages.innerHTML = `
      <div class="cemp-loading-div">
      <p class="cemp-loading-p">Cargando...</p>
      </div>`;
      chatLoading = false;
    }
    fetch(cempAjax.url, {
      method: 'POST',
      mode: 'same-origin',
      body: msgRequest,
    })
    .then(res => res.json())
    .then(data => {
      console.log(chat);
      isChatBottom();
      cempMessages.innerHTML = data;
      scrollDownChats();
    })
  }, 2000);


}

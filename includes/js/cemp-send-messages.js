function cempSendMessages(){
  cempForm.to.value = currentChat;
  chattingWith = cempForm.to.value;

  msg = new FormData(cempForm);
  msg.append( 'action', 'cemp_send_messages' );
  msg.append( 'chat', currentChat );
  messageBar.value = '';

  fetch(cempAjax.url, {
    method: 'POST',
    mode: 'same-origin',
    body: msg
  })
    .then(res => res.json())
    .then(data => {
      cempNotification('Tenés un mensaje nuevo', data.messages)
    });
}

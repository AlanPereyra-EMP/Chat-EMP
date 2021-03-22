function cempSendMessages(){
  cempForm.to.value = currentChat;
  chattingWith = cempForm.to.value;
  console.log(currentChat);

  msg = new FormData(cempForm);
  msg.append( 'action', 'cemp_send_messages' );
  messageBar.value = '';

  fetch(cempAjax.url, {
    method: 'POST',
    mode: 'same-origin',
    body: msg
  })
    .then(res => res.json())
    .then(data => {
      console.log(data);
      // TODO: Add notifications
    });
}

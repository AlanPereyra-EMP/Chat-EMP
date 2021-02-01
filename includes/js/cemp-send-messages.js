function cempSendMessages(id){
  msg = new FormData(cempForm);
  msg.append( 'action', 'cemp_send_messages' );

  fetch(cempAjax.url, {
    method: 'POST',
    mode: 'same-origin',
    body: msg
  })
    .then(res => res.json())
    .then(data => {
      isChatBottom();
      messageBar.value = '';
      cempMessages.innerHTML += `
        <div class="${data.class}">
          <span class="left">
            <img src="${data.img}" />
            ${data.user}
          </span>
          <p>${data.message}</p>
          <span class="rigth">${data.date}</span>
        </div>`;
      scrollDownChats();
    });
}

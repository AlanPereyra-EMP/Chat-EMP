function cempGetMessages(){
  msgRequest = new FormData();
  msgRequest.append( 'action', 'cemp_get_messages' );

  fetch(cempAjax.url, {
    method: 'POST',
    mode: 'same-origin',
    body: msgRequest,
  })
    .then(res => res.json())
    .then(data => {
      isChatBottom();
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
    })
}
cempGetMessages();

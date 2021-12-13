// Scroll down chats
const cempMessages = document.getElementById('cemp-messages');
const newMessagesDiv = document.getElementById('new-messages-count');
var isBottom = false;

function isChatBottom(){
  if(cempMessages.scrollTop + 100 > (cempMessages.scrollHeight-cempMessages.clientHeight)){
    isBottom = true;
  }else{
    isBottom = false;
  }
}
newMessagesDiv.innerHTML = `<i class="fa fa-arrow-down"></i>`;
function scrollDownChats(){
  if(isBottom){
    cempMessages.scrollTo(0, cempMessages.scrollHeight);
    resetMessagesCount();
  }else{
    newMessagesDiv.classList.remove('cemp-d-none');
  }
}
function resetMessagesCount(){
  isChatBottom();
  if(isBottom){
    newMessagesDiv.classList.add('cemp-d-none');
  }
}
cempMessages.addEventListener('scroll', function (){
  isChatBottom();
  if(isBottom){
    resetMessagesCount();
  }
});
newMessagesDiv.addEventListener('click', function (){
  isBottom = true;
  scrollDownChats();
});

//  Remaining characteres
const messageBar = document.getElementById('message-bar');
const remainCharDiv = document.getElementById('remain-char');
const cempForm = document.getElementById('cemp-form');

messageBar.addEventListener('keypress', function(e){
  var charLength = messageBar.value.length;
  var remainChar = 240 - charLength;

  if(e.key == 'Enter'){
    e.preventDefault();
    cempSendMessages();
    remainChar = 240;
  }

  remainCharDiv.innerHTML = `Carácteres restantes ${remainChar}`;
});

// Message form prevent default
cempForm.addEventListener('submit', function(e){
  e.preventDefault();
  cempSendMessages();
});

// Add fade in animation class
window.onload = function(){
  var fempFadeIn = document.getElementById('cemp-div');
  fempFadeIn.classList.add("cemp-faded");
  fempFadeIn.classList.remove("femp-d-none");
}

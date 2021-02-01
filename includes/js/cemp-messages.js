// Scroll down chats
const cempMessages = document.getElementById('cemp-messages');
const newMessagesDiv = document.getElementById('new-messages-count');
var isBottom = false;
var newMessagesCount = 0;

function isChatBottom(){
  if(cempMessages.scrollTop + 100 > (cempMessages.scrollHeight-cempMessages.clientHeight)){
    isBottom = true;
  }else{
    isBottom = false;
  }
}
function scrollDownChats(){
  if(isBottom){
    cempMessages.scrollTo(0, cempMessages.scrollHeight);
    resetMessagesCount();
  }else{
    newMessagesCount++;
    newMessagesDiv.classList.remove('cemp-d-none');
    newMessagesDiv.innerHTML = newMessagesCount;
  }
}
function resetMessagesCount(){
  isChatBottom();
  if(isBottom){
    newMessagesCount = 0;
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

messageBar.addEventListener('input', function(){
  var charLength = messageBar.value.length;
  var remainChar = 240 - charLength;
  remainCharDiv.innerHTML = `Carácteres restantes ${remainChar}`;
});

// Message form prevent default
cempForm.addEventListener('submit', function(e){
  e.preventDefault();
  cempGetMessages();
  cempSendMessages(cempUserId);
});

// Add fade in animation class
window.onload = function(){
  var fempFadeIn = document.getElementById('cemp-div');
  fempFadeIn.classList.add("cemp-faded");
  fempFadeIn.classList.remove("femp-d-none");
}

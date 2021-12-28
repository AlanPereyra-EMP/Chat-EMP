var chatSettings = document.getElementById('chat-settings');
const cempChatName = document.getElementById('cemp-chat-name');
var cempSettingsDisplay = false;
var afterSettings = false;

function cempRemoveSettings(){
  if(cempSettingsDisplay){
    chatSettings.classList.remove('show');
    cempSettingsDisplay = false;
    afterSettings = true;
    loadindMsgs(afterSettings);
    interval = setInterval(() => {loadindMsgs()}, 1000);
    return;
  }
}

function cempShowSettings(){
  if(cempSettingsDisplay){
    cempRemoveSettings();
    return;
  }

  clearInterval(interval);
  cempChatName.innerHTML = 'Configuración';
  afterSettings = false;
  cempSettingsDisplay = true;
  chatSettings.classList.add('show');
}

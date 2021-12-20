var chatSettings = document.getElementById('chat-settings');
var cempSettingsDisplay = false;

function cempRemoveSettings(){
  if(cempSettingsDisplay){
    chatSettings.classList.remove('show');
    cempSettingsDisplay = false;
    console.log('asd');
    return;
  }
}

function cempShowSettings(){
  if(cempSettingsDisplay){
    cempRemoveSettings();
    return;
  }

  cempSettingsDisplay = true;
  console.log('asd');
  chatSettings.classList.add('show');
}

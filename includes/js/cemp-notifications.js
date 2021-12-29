function cempNotificationPermission(){
  if(!Notification){
    console.log("Este navegador no soporta notificaciones.");
    return;
  }else{
    if(checkNotificationPromise()){
      Notification.requestPermission()
      .then((permission) => {
        handlePermission(permission);
      })
    }else{
      Notification.requestPermission(function(permission){
        handlePermission(permission);
      });
    }
  }
  function handlePermission(permission){
    console.log(permission);
  }
}
function checkNotificationPromise(){
  try{
    Notification.requestPermission().then();
  }catch(e){
    return false;
  }
  return true;
}
cempNotificationPermission()

var notiSound = new Audio(cempAudio.notification);
function cempNotification(msg, body){
  new Notification(msg,
    {icon: cempFav,
     body: body
    });
  notiSound.play();
}

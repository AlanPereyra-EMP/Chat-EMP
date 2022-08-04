function cempNotificationPermission(){
  // Let's check if the browser supports notifications
  if(!Notification){
    console.log("Este navegador no soporta notificaciones.");
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

var notiSound = new Audio(cempAudio.notification);
function cempNotification(msg, body){
  new Notification(msg, {icon: 'https://empralidad.com.ar/wp-content/uploads/2020/07/Isotipo-v3-fondo-blanco.png', body: body});
  notiSound.play();
}

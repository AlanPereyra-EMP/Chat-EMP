function cempNotificationPermission(){
  // function to actually ask the permissions
  function handlePermission(permission){
    console.log(permission);
  }
  // Let's check if the browser supports notifications
  if(!('Notification' in window)){
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
}
function checkNotificationPromise(){
  try{
    Notification.requestPermission().then();
  }catch(e){
    return false;
  }
  return true;
}

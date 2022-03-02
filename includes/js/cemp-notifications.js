function cempNotificationPermission(){
  if(!('Notification' in window)){
    alert("Este navegador no soporta las notificaciones");
    return;
  }else if(Notification.permission === "granted"){
    Notification.requestPermission(function(permission){
      console.log(permission);
    });
  }else if(Notification.permission !== 'denied'){
    Notification.requestPermission()
    .then((permission) => {
      console.log(permission);
    })
  }
}
cempNotificationPermission();

if ('serviceWorker' in navigator) {
  window.addEventListener('load', function() {
    navigator.serviceWorker.register('/sw.js').then(function(registration) {
      // Registration was successful
      console.log('ServiceWorker registration successful with scope: ', registration.scope);
    }, function(err) {
      // registration failed :(
      console.log('ServiceWorker registration failed: ', err);
    });
  });
}

var notiSound = new Audio(cempAudio.notification);
function cempNotification(msg, body){
  var options = {
    icon: cempFav,
    body: body
  }
  var n = new Notification(msg, options);
  setTimeout(n.close.bind(n), 5000);
  notiSound.play();
}

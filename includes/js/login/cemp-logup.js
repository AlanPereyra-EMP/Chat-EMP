function cempLogUp() {
  var date = getFullDate();
  var pass = '';
  var termsPoli = '';

  if(cempPass != 'false'){
    pass = `
    <label>
      El permiso de acceso es un código que te dará el admin del sitio.
      Para obtenerlo contacta al administrador.
    </label>
    <input name="access" type="text" placeholder="Permiso de acceso" required/>`;
  }
  if(cempTerms != 'false' && cempPoli != 'false'){
    var terms = cempTerms;
    var poli = cempPoli;
    termsPoli = `
    <label>
      Registrandote estás aceptando los <a href="${terms}">Terminos y condiciones</a>
      y las <a href="${poli}">Políticas de privacidad</a>
    </label>`;
  }

  cempLoginH2.innerHTML = '<h2>Registrarse</h2>';
  cempLoginForm.innerHTML = `
    <label id="login-error"></label>
    <input name="email" type="text" placeholder="Email" required/>
    <input name="log" type="text" placeholder="Usuario" required/>
    <input name="pwd" type="text" placeholder="Contraseña" required/>
    ${pass}
    <input name="date" type="hidden" value="${date}"/>
    <button class="success" onclick="fetchLogup()">Registrarse</button>
    <button onclick="cempLogIn()">Ingresar</button>
    ${termsPoli}`;

}
function fetchLogup(){
  error = document.getElementById('login-error');
  error.innerHTML = '';
  if(cempPass != 'false'){
    if(cempLoginForm.access.value != cempPass){
      error.innerHTML = 'El permiso de acceso no coincide';
      return;
    }
  }
  if(cempLoginForm.log.value.length < 3||cempLoginForm.pwd.value.length < 3||cempLoginForm.email.value.length < 10){
    return
  }

  var logupForm = new FormData(cempLoginForm);
  logupForm.append( 'action', 'cemp_logup_user' );

  fetch(cempAjax.url, {
    method: 'POST',
    mode: 'same-origin',
    body: logupForm,
  })
  .then(res => res.json())
  .then(data => {
    if(data.is_registered && data.problem == 'user'){
      error.innerHTML = 'El nombre usuario ya está registrado';
    }else if(data.is_registered && data.problem == 'email'){
      error.innerHTML = 'El email ya está siendo usado por un usuario';
    }else{
      location.reload();
    }
  })
}

function getFullDate() {
  var newDate = new Date();
  var date = ('0'+newDate.getDate()).slice(-2)+'/';
  date += ('0'+(newDate.getMonth()+1)).slice(-2)+'/';
  date += ('0'+newDate.getFullYear()).slice(-2)+' ';
  date += ('0'+newDate.getHours()).slice(-2)+':';
  date += ('0'+newDate.getMinutes()).slice(-2);
  return date;
}

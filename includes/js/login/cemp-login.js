const cempConfig = document.getElementById('cemp-config-page');
cempConfig.classList.remove('cemp-d-none');
cempConfig.innerHTML = '<div id="cemp-login"></div>';

const cempLogin = document.getElementById('cemp-login');

cempLogin.innerHTML += `
<h2 id="cemp-login-h2"></h2>
<form id="login-form"></form>`;

const cempLoginH2 = document.getElementById('cemp-login-h2');
var cempLoginForm = document.getElementById('login-form');
cempLoginForm.addEventListener('submit', function(e){
  e.preventDefault();
});

function cempLogIn() {
  cempLoginH2.innerHTML = 'Ingresar';
  cempLoginForm.innerHTML = `
    <label id="login-error"></label>
    <input type="text" minlength="3" size="20" name="log" placeholder="Usuario" required/>
    <input type="password" minlength="3" size="20" name="pwd" placeholder="Contraseña" required/>
    <input class="success" type="submit" value="Ingresar" onclick="fetchLogin()"/>
    <p class="change-form">¿No tienes cuenta? <a href="#" onclick="cempLogUp();">Registrarse</a></p>`;
}
cempLogIn();

function fetchLogin(){
  if(cempLoginForm.log.value.length < 3||cempLoginForm.pwd.value.length < 3){
    return
  }

  var loginForm = new FormData(cempLoginForm);
  loginForm.append( 'action', 'cemp_login_user' );

  fetch(cempAjax.url, {
    method: 'POST',
    mode: 'same-origin',
    body: loginForm,
  })
  .then(res => res.json())
  .then(data => {
    if(data.loggedin){
      location.reload();
    }else{
      error = document.getElementById('login-error');
      error.innerHTML = 'El usuario o contraseña son erroneos';
    }
  })
}

var cempUpdatesForm = document.getElementById('cemp-user-data');
var updateTerms = document.getElementById('cemp-update-terms');
var updatePoli = document.getElementById('cemp-update-poli');
var error = document.getElementById('login-error');

updateTerms.href = cempTerms;
updatePoli.href = cempPoli;

cempUpdatesForm.addEventListener('submit', function(e){
  e.preventDefault();
});


function cempUpdateUser(){
  var updatesForm = new FormData(cempUpdatesForm);
  updatesForm.append( 'action', 'cemp_update_user' );

  var pwd = document.getElementById('cemp-pwd');
  var pwdConfirm = document.getElementById('cemp-pwd-confirm');
  var pwdOld = document.getElementById('cemp-pwd-old');

  pwd.classList.remove('error');
  pwdConfirm.classList.remove('error');
  pwdOld.classList.remove('error');
  error.innerHTML = '';

  fetch(cempAjax.url, {
    method: 'POST',
    mode: 'same-origin',
    body: updatesForm
  })
    .then(res => res.json())
    .then(data => {
      if(data.status == 'success'){
        location.reload();
      }else if(data.problem == 'pass'){
        error.innerHTML = 'Las contraseñas no coinciden';
        pwd.classList.add('error');
        pwdConfirm.classList.add('error');
      }else if(data.problem == 'old_pass'){
        error.innerHTML = 'Tu contraseña actual no es correcta';
        pwdOld.classList.add('error');
      }else if(data.problem == 'empty'){
        error.innerHTML = 'No hay nada que actualizar';
        pwd.classList.add('error');
        pwdConfirm.classList.add('error');
      }else if (data.problem == 'update'){
        error.innerHTML = 'Hubo un error interno, contactá al administrador';
      }
    });
}

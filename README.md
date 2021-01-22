# Chat-EMP
Chat-EMP es un plugin para WordPress que añade un chat a una página en concreto a través de un shortcode. Un administrador podrá entrar desde esta misma página para ver y responder los mensajes enviados desde la web, por usuarios autorizados, en tiempo real.

## Funcionamiento
Primero se accede a la url en la que se encuentra el shortcode (el contenido que tenga esta página queda deshabilitado y se mostrará en pantalla completa el chat)

### Ingresar
Luego el plugin comprueba si este usuario accedió a la web. Si no lo hizo carga la pantalla de acceso, en esta pantalla de acceso habrán dos opciones, en la primera se ingresa con usuario y contraseña, y en la segunda el usuario puede registrarse.

Si el usuario decide registrarse, el plugin puede pedirle o no (a criterio del administrador) una contraseña para habilitar solo a usuarios que posean dicha contraseña a registrarse y por ende iniciar un chat con el administrador.

### Acceso como administrador
Una vez haya accedido el plugin comprobará si es un administrador, en el caso de serlo le dará una lista de acceso a todos los chats. En esta lista el administrador verá notificaciones en tiempo real de los mensajes que le envíen los usuarios desde la web.

### Acceso como usuario (no-admin)
En el caso de no ser admin, se verificará si tiene un chat previo con el administrador, si lo tiene accede a el, sino crea un nuevo chat con el admin y luego accede a el.

### Mensajes
Una accedió el usuario, puede mandarle mensajes al admin. En el caso de que el admin no esté mirando el chat añadirá una notificación a la lista de mensajes. Luego el admin podrá responder los mensajes al usuario y en el caso de que el usuario no esté en linea este recibirá un email en su correo el cual le avisará que su mensaje ha sido respondido.

## Shortcode
El shortcode es una tan simple como el nombre del plugin y opcionalmente se puede añadir una contraseña para que solo los usuarios que la posean puedan registrarse.

> [Chat-EMP pass="password"]

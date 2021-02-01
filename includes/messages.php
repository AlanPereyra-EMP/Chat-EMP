<?php
add_action('wp_ajax_nopriv_cemp_get_messages', 'cemp_get_messages');
add_action('wp_ajax_cemp_get_messages', 'cemp_get_messages');
add_action('wp_ajax_nopriv_cemp_send_messages', 'cemp_send_messages');
add_action('wp_ajax_cemp_send_messages', 'cemp_send_messages');

function cemp_get_messages(){
  $msg_quantity = 5;
  $message_list = array(
    'class' => 'receive',
    'user' => 'Nombre Completo',
    'message' => 'Texto de prueba',
    'date' => '31/01/21',
    'img' => 'http://localhost/wordpress/wp-content/uploads/2020/10/hiker-1149877_1280-600x600.jpg'
  );
  echo json_encode($message_list);
  die();
}
function cemp_send_messages(){
  $msg = $_POST['msg'];

  $msg_send = array(
    'class' => 'send',
    'user' => 'Nombre Completo',
    'message' => $msg,
    'date' => '31/01/21',
    'img' => 'http://localhost/wordpress/wp-content/uploads/2020/10/hiker-1149877_1280-600x600.jpg'
  );

  echo json_encode($msg_send);
  die();
}
?>

<?php
add_action('wp_ajax_nopriv_cemp_get_messages', 'cemp_get_messages');
add_action('wp_ajax_cemp_get_messages', 'cemp_get_messages');
add_action('wp_ajax_nopriv_cemp_send_messages', 'cemp_send_messages');
add_action('wp_ajax_cemp_send_messages', 'cemp_send_messages');


date_default_timezone_set('America/Argentina/Buenos_Aires');
function cemp_get_messages(){
  $chat_id = $_POST['chat'];
  $max = $_POST['max'];

  global $wpdb;

  $table_msgs = $wpdb->prefix .'cemp_msgs';
  $table_usrs = $wpdb->prefix .'cemp_usrs';

  $messages = $wpdb->get_results(
    "SELECT * FROM $table_msgs, $table_usrs WHERE `to_id` = $chat_id GROUP BY `id_m` ORDER BY `id_m` DESC"
  );
  $msg_numb = $wpdb->get_var(
    "SELECT COUNT(*) FROM $table_msgs WHERE `to_id` = $chat_id"
  );

  if($max <= $msg_numb){
    $msg_numb = $max;
  }
  for($i = $msg_numb-1; $i >= 0; $i--){
    $user_id = $messages[$i]->id_u;
    $to_id = $messages[$i]->to_id;
    $from_id = $messages[$i]->from_id;
    $user_data = get_userdata($from_id);
    $img = get_avatar_url($from_id);

    if($from_id == get_current_user_id()){
      $chat_class = 'send';
    }else{
      $chat_class = 'receive';
    }

    $chat .= '
    <div class="'.$chat_class.'">
      <span class="left">
        <img src="'.$img.'" />
        '.$user_data->user_login.'
      </span>
      <p>'.$messages[$i]->message.'</p>
      <span class="rigth">'.$messages[$i]->time.'</span>
    </div>';
  }

  echo json_encode($chat);
  die();
}
function cemp_send_messages(){
  $msg = $_POST['msg'];
  $user_id = get_current_user_id();
  $to_id = $_POST['to'];
  $to_id = intval($to_id);
  $now = date("d/m/Y H:i");

  global $wpdb;

  $table_msgs = $wpdb->prefix .'cemp_msgs';

  $data = array(
    'from_id' => $user_id,
    'to_id' => $to_id,
    'message' => $msg,
    'time' => $now
  );

  $format = array(
    '%d','%d','%s','%s'
  );

  $wpdb->insert($table_msgs,$data,$format);

  echo json_encode($data);
  die();
}
?>

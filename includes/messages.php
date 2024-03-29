<?php
add_action('wp_ajax_nopriv_cemp_get_messages', 'cemp_get_messages');
add_action('wp_ajax_cemp_get_messages', 'cemp_get_messages');
add_action('wp_ajax_nopriv_cemp_send_messages', 'cemp_send_messages');
add_action('wp_ajax_cemp_send_messages', 'cemp_send_messages');


date_default_timezone_set('America/Argentina/Buenos_Aires');
function cemp_get_messages(){
  $to_id = $_POST['toId'];
  $from_id = $_POST['fromId'];
  $max = $_POST['max'];
  $id = get_current_user_id();

  if($id != $to_id && $id != $from_id){
    die();
  }

  global $wpdb;

  $table_msgs = $wpdb->prefix .'cemp_msgs';
  $table_usrs = $wpdb->prefix .'cemp_usrs';

  $messages = $wpdb->get_results(
    "SELECT * FROM $table_msgs, $table_usrs
    WHERE (`to_id` = $to_id OR `from_id` = $to_id) AND (`to_id` = $from_id OR `from_id` = $from_id)
    GROUP BY `id_m`
    ORDER BY `id_m` DESC"
  );
  $msg_numb = $wpdb->get_var(
    "SELECT COUNT(*) FROM $table_msgs
    WHERE (`to_id` = $to_id OR `from_id` = $to_id)  AND (`to_id` = $from_id OR `from_id` = $from_id)"
  );

  if($max <= $msg_numb){
    $msg_numb = $max;
  }
  for($i = $msg_numb-1; $i >= 0; $i--){
    $from_id_for = $messages[$i]->from_id;
    $user_data = get_userdata($from_id_for);
    $img = get_avatar_url($from_id_for);

    if($from_id_for == get_current_user_id()){
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

  if($id == $from_id){
    $chat_name = get_userdata($to_id);
    $chat_name = $chat_name->user_login;
  }else{
    $chat_name = get_userdata($from_id);
    $chat_name = $chat_name->user_login;
  }

  echo json_encode(array('chat' => $chat, 'chat_name' => $chat_name));
  die();
}
function cemp_send_messages(){
  global $wpdb;

  $msg = $_POST['msg'];
  $chat_ids = $_POST['chat'];

  $chat_ids = explode(',', $chat_ids);
  $user_id = get_current_user_id();

  if($chat_ids[0] == $user_id){
    $to_id = $chat_ids[1];
    $from_id = $chat_ids[0];
  }else{
    $to_id = $chat_ids[0];
    $from_id = $chat_ids[1];
  }
  $to_id = intval($to_id);
  $from_id = intval($from_id);

  if($user_id != $to_id && $user_id != $from_id){
    die();
  }

  $now = date("d/m/Y H:i");

  $data = array(
    'from_id' => $user_id,
    'to_id' => $to_id,
    'message' => $msg,
    'time' => $now
  );

  // Prevents to send empty messages
  if($msg == ''){
    echo json_encode($data);
    die();
  }

  $format = array(
    '%d','%d','%s','%s'
  );

  $table_msgs = $wpdb->prefix .'cemp_msgs';

  $wpdb->insert($table_msgs,$data,$format);

  echo json_encode($data);
  die();
}
?>

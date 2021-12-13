<?php
add_action('wp_ajax_nopriv_cemp_get_chat_list', 'cemp_get_chat_list');
add_action('wp_ajax_cemp_get_chat_list', 'cemp_get_chat_list');

function has_user_chat($admins){
  global $wpdb;

  $table_chats = $wpdb->prefix.'cemp_chats';

  $user_id = get_current_user_id();

  $user_has_chat = $wpdb->get_results(
    "SELECT * FROM $table_chats WHERE EXISTS (SELECT 1 FROM $table_chats WHERE user_id1 = $user_id OR user_id2 = $user_id)"
  );

  $now = date("d/m/Y H:i");

  $cemp_admins = explode('|', $admins);
  $admins_count = count($cemp_admins);

  if(!$user_has_chat){
    for($i = 0; $i < $admins_count; $i++){
      $data = array(
        'user_id1' => $user_id,
        'user_id2' => $cemp_admins[$i],
        'reg_c' => $now
      );

      $format = array(
        '%d','%d','%s'
      );

      $wpdb->insert($table_chats,$data,$format);
    }
  }

}
function cemp_get_chat_list(){
  global $wpdb;

  $table_chats = $wpdb->prefix .'cemp_chats';
  $table_usrs = $wpdb->prefix .'cemp_usrs';
  $table_msgs = $wpdb->prefix .'cemp_msgs';

  $user_id = get_current_user_id();

  $user_list = $wpdb->get_results(
    "SELECT * FROM $table_chats, $table_usrs WHERE (`user_id1` = $user_id OR `user_id2` = $user_id) AND (`user_id1` != `user_id2`) GROUP BY `id_c`"
  );

  $count = $user_list;
  $chats_number = count($count);

  for($i = 0; $i < $chats_number; $i++){
    if($user_list[$i]->user_id1==$user_id){
      $id_u = $user_list[$i]->user_id2;
    }else{
      $id_u = $user_list[$i]->user_id1;
    }
    $user_data = get_userdata($id_u);
    $user_name = $user_data->user_login;
    $img_src = get_avatar_url($id_u);
    $img = '<img src="'.$img_src.'"/>';
    $chats .= '<li onclick="cempGetThisChat(20,'.$user_list[$i]->user_id1.','.$user_list[$i]->user_id2.')">'.$img.$user_name.'</li>';
  }

  $chat_list = '<ul>'.$chats.'</ul>';

  echo json_encode($chat_list);
  die();
}

?>

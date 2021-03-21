<?php
function register_users(){
  global $wpdb;

  $table_usrs = $wpdb->prefix.'cemp_usrs';

  $user_id = get_current_user_id();
  $user_data = get_userdata($user_id);
  $user_name = $user_data->user_login;
  $user_email = $user_data->user_email;

  $user_exists = $wpdb->get_results(
    "
    SELECT name FROM $table_usrs WHERE EXISTS (SELECT 1 FROM $table_usrs WHERE id_u = '$user_id')
    "
  );

  if(!$user_exists){
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    $time = date("d/m/Y H:i");

    $data = array(
      'id_u' => $user_id,
      'name' => $user_name,
      'email' => $user_email,
      'reg_u' => $time
    );

    $format = array(
      '%d','%s','%s','%s'
    );

    $wpdb->insert($table_usrs,$data,$format);
  }
}

?>

<?php
add_action('wp_ajax_nopriv_cemp_login_user', 'cemp_login_user');
add_action('wp_ajax_cemp_login_user', 'cemp_login_user');
add_action('wp_ajax_nopriv_cemp_logup_user', 'cemp_logup_user');
add_action('wp_ajax_cemp_logup_user', 'cemp_logup_user');

function cemp_login_user(){

  $info = array();
  $info['user_login'] = $_POST['log'];
  $info['user_password'] = $_POST['pwd'];
  $info['remember'] = true;

  $user_signon = wp_signon( $info, false );
  if ( is_wp_error($user_signon) ){
    echo json_encode(array('loggedin'=>false, 'message'=>__('Hubo un problema')));
  } else {
    echo json_encode(array('loggedin'=>true, 'message'=>__('Correcto')));
  }

  die();
}

function cemp_check_password($access){
  global $wpdb;

  $table_settings = $wpdb->prefix.'cemp_settings';

  $settings = $wpdb->get_results(
    "SELECT * FROM  $table_settings
    ORDER BY `id_s` DESC
    LIMIT 1"
  );

  $server_access = $settings[0]->access;

  if($server_access == $access){
    return true;
  }else{
    return false;
  }
}
function cemp_logup_user(){

  $user_name = $_POST['log'];
  $user_email = $_POST['email'];
  $password = $_POST['pwd'];
  $user_date = $_POST['date'];
  $access = $_POST['access'];

  $user_id = username_exists( $user_name );
  $email_id = email_exists( $user_email );

  if(!cemp_check_password($access)){
    echo json_encode(array('problem' => 'access'));
    die();
  }

  if ( !$user_id && !$email_id ) {
    $user_id = wp_create_user( $user_name, $password, $user_email );
  } else if ($email_id){
    echo json_encode(array('loggedup'=>false, 'is_registered'=>true, 'problem' => 'email'));
    die();
  } else if ($user_id){
    echo json_encode(array('loggedup'=>false, 'is_registered'=>true, 'problem' => 'user'));
    die();
  }

    $userdata = array(
      'user_pass'             => $password,
      'user_login'            => $user_name,
      'user_email'            => $user_email,
      'user_registered'       => $user_date,
      'show_admin_bar_front'  => false,
      'role'                  => 'suscriber'
  );

  $user_id = wp_insert_user( $userdata ) ;

  // On success.
  if ( ! is_wp_error( $user_id ) ) {
    echo json_encode(array('loggedup'=>true, 'is_registered'=>false, 'problem' => false));
    die();
  }

}
?>

<?php
add_action('wp_ajax_nopriv_cemp_update_user', 'cemp_update_user');
add_action('wp_ajax_cemp_update_user', 'cemp_update_user');

function cemp_update_user(){

  $new_pass = $_POST['pwd'];
  $confirm_pass = $_POST['pwd-confirm'];
  $old_pass = $_POST['pwd-old'];

  if($new_pass != $confirm_pass){
    echo json_encode(array('status' => 'fail', 'problem' => 'pass'));
    die();
  }

  $current_user = wp_get_current_user();
  $user = $current_user->user_login;
  $user_pass = $current_user->data->user_pass;
  $user_id = $current_user->ID;

  if (!($user && wp_check_password( $old_pass, $user_pass, $user_ID ))) {
    echo json_encode(array('status' => 'fail', 'problem' => 'old_pass'));
    die();
  }

  if($new_pass != ''){
    $update_pass = wp_update_user( array( 'ID' => $user_id, 'user_pass' => $new_pass ) );
  } else {
    echo json_encode(array('status' => 'fail', 'problem' => 'empty'));
    die();
  }

  if(!is_wp_error($update_pass)){
    echo json_encode(array('status' => 'success'));
    die();
  }else{
    echo json_encode(array('status' => 'fail', 'problem' => 'update'));
    die();
  }
}
?>

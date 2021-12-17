<?php
function cemp_save_settings($access, $mode){
  global $wpdb;

  $table_settings = $wpdb->prefix.'cemp_settings';

  $settings = $wpdb->get_results(
    "SELECT * FROM  $table_settings
    ORDER BY `id_s` DESC
    LIMIT 1"
  );

  $actual_access = $settings[0]->access;
  $actual_mode = $settings[0]->mode;

  if($access != $actual_access || $mode != $actual_mode){

    $data = array(
      'access' => $access,
      'mode' => $mode
    );

    $format = array(
      '%s','%s'
    );

    $wpdb->insert($table_settings,$data,$format);
  }
}
?>

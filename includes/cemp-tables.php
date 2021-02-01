<?php
$cemp_db_version = '1.0';

function cemp_DB() {
	global $wpdb;
	global $cemp_db_version;


	$charset_collate = $wpdb->get_charset_collate();

	// Users
	$table_users = $wpdb->prefix . 'cemp_users';
  $sql = "CREATE TABLE $table_users (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    name varchar(60) NOT NULL,
		email varchar(50),
		pass varchar(50),
    time varchar(50),
    PRIMARY KEY  (id)
  ) $charset_collate;";

	// Chats
	$table_chats = $wpdb->prefix . 'cemp_chats';
	$sql = "CREATE TABLE $table_chats (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
		user_id1 int NOT NULL,
    user_id2 int NOT NULL,
    time varchar(50),
    PRIMARY KEY  (id)
  ) $charset_collate;";

	// Messages
	$table_messages = $wpdb->prefix . 'cemp_messages';
	$sql = "CREATE TABLE $table_messages (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		user_id int NOT NULL,
		chat_id int NOT NULL,
		time varchar(50),
		PRIMARY KEY  (id)
	) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  add_option( 'cemp_db_version', $cemp_db_version );
}
register_activation_hook( __FILE__, 'cemp_DB' );


// function cemp_db_check() {
// 	global $wpdb;
// 	global $cemp_db_version;
//
// 	$query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_name ) );
//   if ( (! $wpdb->get_var( $query ) == $table_name)||($cemp_db_version !== get_option('cemp_db_version'))) {
//     cemp_DB();
//   }
// }
// add_action( 'plugins_loaded', 'cemp_db_check' );
?>

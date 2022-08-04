<?php
$users_query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_users ) );
$chats_query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_chats ) );
$messages_query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $table_messages ) );

$user_table_exist = $wpdb->get_var( $users_query ) == $table_users;
$chats_table_exist = $wpdb->get_var( $chats_query ) == $table_chats;
$messages_table_exist = $wpdb->get_var( $messages_query ) == $table_messages;

$cemp_db_version = '1.1';

function cemp_DB() {
	global $wpdb;
	global $cemp_db_version;

	$charset_collate = $wpdb->get_charset_collate();

	// Users
	$table_users = $wpdb->prefix . 'cemp_usrs';
  $sql = "CREATE TABLE $table_users (
    id_u int NOT NULL,
    name varchar(60) NOT NULL,
		email varchar(50),
    reg_u varchar(50),
    PRIMARY KEY  (id_u)
  ) $charset_collate;";

	// Chats
	$table_chats = $wpdb->prefix . 'cemp_chats';
	$sql .= "CREATE TABLE $table_chats (
    id_c int NOT NULL AUTO_INCREMENT,
		user_id1 int NOT NULL,
    user_id2 int NOT NULL,
    reg_c varchar(50),
    PRIMARY KEY  (id_c),
		FOREIGN KEY (`user_id1`) REFERENCES `$table_users`(`id_u`) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY (`user_id2`) REFERENCES `$table_users`(`id_u`) ON DELETE CASCADE ON UPDATE CASCADE

  ) $charset_collate;";

	// Messages
	$table_messages = $wpdb->prefix . 'cemp_msgs';
	$sql .= "CREATE TABLE $table_messages (
		id_m int NOT NULL AUTO_INCREMENT,
		from_id int NOT NULL,
		to_id int NOT NULL,
		message varchar(240),
		time varchar(50),
		PRIMARY KEY  (id_m),
		FOREIGN KEY (`to_id`) REFERENCES `$table_chats`(`user_id1`) ON DELETE CASCADE ON UPDATE CASCADE,
		FOREIGN KEY (`from_id`) REFERENCES `$table_users`(`id_u`) ON DELETE CASCADE ON UPDATE CASCADE
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

  add_option( 'cemp_db_version', $cemp_db_version );
}
register_activation_hook( __FILE__, 'cemp_DB' );


function cemp_db_check() {
	global $wpdb;
	global $cemp_db_version;

  if (!$user_table_exist||!$chats_table_exist||!$messages_table_exist||$cemp_db_version !== get_option('cemp_db_version')) {
    cemp_DB();
  }
}
add_action( 'plugins_loaded', 'cemp_db_check' );
?>

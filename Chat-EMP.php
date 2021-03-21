<?php
/*
Plugin Name: Chat EMP
Plugin URI: https://empralidad.com.ar/chat-emp
Description: Chat EMP es un plugin para WordPress que añade un sistema de mensajería mediante un shortcode.
Author: Empralidad
Author URI: https://empralidad.com.ar/
Text Domain: cemp
License: Attribution-NonCommercial-NoDerivatives 3.0 IGO
License URI: https://creativecommons.org/licenses/by-nc-nd/3.0/igo/legalcode
Version: 0.1.1
*/
if ( ! defined( 'ABSPATH' ) ){
	exit;
}


require_once plugin_dir_path(__FILE__).'/includes/index.php';
require_once plugin_dir_path(__FILE__).'/includes/login.php';
require_once plugin_dir_path(__FILE__).'/includes/cemp-tables.php';
require_once plugin_dir_path(__FILE__).'/includes/messages.php';
require_once plugin_dir_path(__FILE__).'/includes/chats.php';
require_once plugin_dir_path(__FILE__).'/includes/users.php';
require_once plugin_dir_path(__FILE__).'/shortcode/shortcode.php';
?>

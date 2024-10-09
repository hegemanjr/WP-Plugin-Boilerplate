<?php
/**
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Plugin Name:       WP Plugin Boilerplate
 * Plugin URI:        https://608.software
 * Version:           1.0.0
 * Author:            Jeff Hegeman
 * Author URI:        https://hegeman.me
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp_plugin_boilerplate
 *
 * @wordpress-plugin
 * @link              https://hegeman.me
 * @since             1.0.0
 * @package           Wp_plugin_boilerplate
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Include the main plugin class.
require_once plugin_dir_path( __FILE__ ) . 'class/' . basename( __FILE__ );

// Initialize the plugin.
WP_Plugin_Boilerplate::get_instance();

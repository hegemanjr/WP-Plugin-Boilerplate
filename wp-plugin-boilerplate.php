<?php
/**
 * @link              https://hegeman.me
 * @since             1.0.0
 * @package           Wp_plugin_boilerplate
 *
 * @wordpress-plugin
 * Plugin Name:       WP Plugin Boilerplate
 * Plugin URI:        https://608.software
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Jeff Hegeman
 * Author URI:        https://hegeman.me
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp_plugin_boilerplate
 */

class WP_Plugin_Boilerplate {
//    public $required_plugin = 'hello.php';// See documentation for is_plugin_active()

    function __construct() {
        add_action('init', array($this, 'action_init'));
    }

    public function action_init() {
        add_action('admin_notices', array($this, 'action_admin_notices'));
        add_shortcode( "wp_plugin_boilerplate", array($this, 'add_shortcode'));
        register_activation_hook( __FILE__, array($this, 'activate_plugin'));
        register_deactivation_hook( __FILE__, array($this, 'deactivate_plugin'));
    }

    function action_admin_notices() {
        // check if $required_plugin is installed and active
        if (isset($this->required_plugin) && $this->required_plugin != '' && !$this->required_plugin_is_active()) {
            ?>
            <div class="notice notice-error">
                <p><strong>WP Plugin Boilerplate</strong>: 'Hello Dolly' plugin is required. Please ensure it is installed and active.</p>
            </div>
            <?php
        }
    }

    private function required_plugin_is_active(){
            return is_plugin_active( $this->required_plugin );
    }

    function add_shortcode( $atts ) {
        $a = shortcode_atts( array(
            'foo' => 'something',
            'bar' => 'something else',
        ), $atts );

        return "foo = {$a['foo']}";
    }

    function activate_plugin() {
        // Do stuff
    }

    function deactivate_plugin() {
        // Do stuff
    }
}
new WP_Plugin_Boilerplate();






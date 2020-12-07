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
	//public $required_plugins = array('hello.php');// See documentation for is_plugin_active()
	protected $required_plugins_active = false;

    function __construct() {
        add_action('init', array($this, 'action_init'));
    }

    public function action_init() {
		$this->required_plugins_active();
		add_action('admin_notices', array($this, 'action_admin_notices'));
		register_activation_hook( __FILE__, array($this, 'activation_hook'));
		register_deactivation_hook( __FILE__, array($this, 'deactivation_hook'));
		add_shortcode( "wp_plugin_boilerplate", array($this, 'add_shortcode'));
	    	if($this->required_plugins_active === true){
			// Do things that depend on required plugins
			
		}
    }

    function action_admin_notices() {
		// check if required plugins are installed and active
		if (!$this->required_plugins_active) {
		?>
		<div class="notice notice-error">
                <p><strong>WP Plugin Boilerplate</strong>: 'Hello Dolly' plugin is required. Please ensure it is installed and active.</p>
		</div>
		<?php
		// Deactivate plugin because it is missing required plugin(s)
		$this->deactivate_plugin();
		}
    }

    function add_shortcode( $atts ) {
        $a = shortcode_atts( array(
            'foo' => 'something',
            'bar' => 'something else',
        ), $atts );

        return "foo = {$a['foo']}";
    }

	private function required_plugins_active(){
		foreach ($this->required_plugins as $required_plugin){
			if($required_plugin != '' && !is_plugin_active($required_plugin)){
				$this->required_plugins_active = false;
				return false;
			}
		}
		$this->required_plugins_active = true;
		return true;
	}

	function activation_hook() {
		// Do stuff
	}

	function deactivation_hook() {
		// Do stuff
	}

	private function deactivate_plugin() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
}
new WP_Plugin_Boilerplate();






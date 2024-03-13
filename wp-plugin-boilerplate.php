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
	/**
	 * Plugin name
	 * @var string
	 */
	private $plugin_name = 'WP Plugin Boilerplate';
	/**
	 * Text domain for translation support
	 * @var string
	 */
	private $text_domain = 'wp_plugin_boilerplate';
	/**
	 * List of required plugins. See documentation for is_plugin_active() https://developer.wordpress.org/reference/functions/is_plugin_active/
	 * @var array
	 * @example array('hello.php') If 'Hello Dolly' were required
	 */
	private $required_plugins = array();
	/**
	 * An empty array with implementation example. This is used for required plugins by default, but can be used for other admin notices. https://developer.wordpress.org/reference/hooks/admin_notices/
	 * @var array
	 * @example array( array('class'=>'notice notice-error', 'message'=>'An error has occurred.') ) If you wanted to display to the user that an error has occurred.
	 */
	private $admin_notices = array();
	/**
	 * Will be set by $this->required_plugins_active()
	 * @var null
	 */
	private $required_plugins_active = null;
	/**
	 * If true, the plugin will deactivate itself when requirements are not met. If false, admin notices will be displayed, and plugin will remain active.
	 * @var bool
	 */
	private $auto_deactivate_sans_requirements = true;

	/**
	 * Constructor. Place actions, filters, and hooks here
	 */
	function __construct() {
		add_action('init', array($this, 'action_init'));// Run code, and/or call other functions when init action is fired
		$this->required_plugins_active();// Call function to check requirements
		add_action('admin_notices', array($this, 'action_admin_notices'));// Run code, and/or call other functions when admin_notices action is fired
		add_action( 'network_admin_notices', array( $this, 'action_admin_notices' ) );// Run code, and/or call other functions when network_admin_notices action is fired
		register_activation_hook(__FILE__, array($this, 'activation_hook'));// Run code, and/or call other functions when register_activation_hook is fired
		register_deactivation_hook(__FILE__, array($this, 'deactivation_hook'));// Run code, and/or call other functions when register_deactivation_hook is fired
		add_shortcode("wp_plugin_boilerplate", array($this, 'add_shortcode'));// Add shortcode

		if ($this->required_plugins_active === true) {
			// Do things that depend on required plugins

		}
	}

	/**
	 * Run code, and/or call other functions when init action is fired
	 * @return void
	 */
	public function action_init() {
	}

	/**
	 * Run code, and/or call other functions when admin_notices action is fired
	 * @return void
	 */
	function action_admin_notices() {
		// Display any admin notices
		foreach ($this->admin_notices as $admin_notice) {
			$message = __(
				'<strong>' . $this->plugin_name . '</strong>: ' . esc_html($admin_notice['message']),
				$this->text_domain
			);

			printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($admin_notice['class']), $message);
		}
	}

	/**
	 * Add shortcode
	 * @param $atts
	 * @return string
	 */
	function add_shortcode($atts) {
		$a = shortcode_atts(array(
			'foo' => 'something',
			'bar' => 'something else',
		), $atts);

		return "foo = {$a['foo']}";
	}

	/**
	 * @return bool|null
	 */
	private function required_plugins_active() {
		// Check for required plugins if we haven't already
		if ($this->required_plugins_active === null) {
			if (!empty($this->required_plugins)) {
				// Make sure is_plugin_active() function is available
				if (!function_exists('is_plugin_active')) {
					include_once(ABSPATH . 'wp-admin/includes/plugin.php');
				}

				foreach ($this->required_plugins as $required_plugin) {
					if ($required_plugin != '' && !is_plugin_active($required_plugin)) {
						$this->admin_notices[] = array(
							'class' => 'notice notice-error',
							'message' => 'The plugin ' . $required_plugin . ' is required, but not found.'
						);
						$this->required_plugins_active = false;
					}
				}

				// If $this->required_plugins_active is still null, set to true
				if ($this->required_plugins_active === null) {
					$this->required_plugins_active = true;
				}
			} else {
				$this->required_plugins_active = true;
			}
		}

		// Deactivate plugin if requirements not met and auto deactivate is true
		if ($this->auto_deactivate_sans_requirements && !$this->required_plugins_active) {
			// Inform user that the plugin has been deactivated
			$this->admin_notices[] = array(
				'class' => 'notice notice-error',
				'message' => 'Plugin has been disabled due to missing requirements!'
			);
			// Deactivate plugin because it is missing required plugin(s)
			$this->deactivate_plugin();
		}

		return $this->required_plugins_active;
	}

	/**
	 * Run code, and/or call other functions when register_activation_hook is fired
	 * @return void
	 */
	function activation_hook() {
		// Kill activation if requirements not met and auto deactivate is true
		if ($this->auto_deactivate_sans_requirements && !$this->required_plugins_active) {
			$message = '';

			foreach ($this->admin_notices as $admin_notice) {
				$message .= __(esc_html($admin_notice['message']), $this->text_domain) . '<br>';
			}

			die('<strong>' . $this->plugin_name . '</strong>: <br>' . $message);
		}
	}

	/**
	 * Run code, and/or call other functions when register_deactivation_hook is fired
	 * @return void
	 */
	function deactivation_hook() {
		// Do stuff
	}

	/**
	 * @return void
	 */
	private function deactivate_plugin() {
		deactivate_plugins(plugin_basename(__FILE__));
	}
}

new WP_Plugin_Boilerplate();

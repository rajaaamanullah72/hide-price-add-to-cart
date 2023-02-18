<?php

/**
 * Hide price and add to cart main class.
 *
 * - Add files of plugins.
 * - Load Text domain
 *
 * @package hide-price-add-to-cart\includes
 *
 */

defined('ABSPATH') || exit;

/**
 * AM_Hide_Price_Main class.
 */
class AM_Hide_Price_Main {

	/**
	 * Setup class.
	 */
	public function __construct() {
		add_action('wp_loaded', array($this, 'load_text_domain'));
		add_action('init', array($this, 'add_files'));
	}

	/**
	 * Load text domain.
	 */
	public function load_text_domain() {
		if (function_exists('load_plugin_textdomain')) {
			load_plugin_textdomain('aman-hide-price', false, dirname(plugin_basename(__FILE__)) . '/languages/');
		}
	}

	/**
	 * Add files of plugin.
	 */
	public function add_files() {
		if (is_admin()) {
			require_once AM_HIDE_PRICE_PLUGIN_DIR . 'includes/class-am-hide-price-admin.php';
		}

		require_once AM_HIDE_PRICE_PLUGIN_DIR . 'includes/class-am-hide-price.php';
	}
}

new AM_Hide_Price_Main();

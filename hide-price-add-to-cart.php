<?php
/**
 * Plugin Name: WooCommerce hide price and add to cart
 * Plugin URI: https://www.upwork.com/freelancers/~016b702b983b9e346c
 * Description: Allows the merchant to hide price and add to cart for specific use roles.
 * Version: 1.0.0
 * Author: Raja Aman Ullah
 * Author URI: https://www.upwork.com/freelancers/~016b702b983b9e346c
 * Text Domain: aman-hide-price
 * Domain Path: /languages/
 * Requires at least: 5.3
 * Requires PHP: 7.0
 *
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'AM_HIDE_PRICE_URL' ) ) {
	define( 'AM_HIDE_PRICE_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'AM_HIDE_PRICE_PLUGIN_DIR' ) ) {
	define( 'AM_HIDE_PRICE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

require_once AM_HIDE_PRICE_PLUGIN_DIR . 'includes/class-am-hide-price-main.php';

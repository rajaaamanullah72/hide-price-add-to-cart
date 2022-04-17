<?php
/**
 * Hide price and add to cart admin class.
 *
 * - add submenu and settings.
 * - deals with admin configuration of plugin
 *
 * @package hide-price-add-to-cart\includes
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * AM_Hide_Price_Main class.
 *
 */
class AM_Hide_Price_Admin {

	/**
	 * Setup class.
	 */
	public function __construct() {
		 add_action( 'admin_menu', array( $this, 'add_submenu' ) );
		add_action( 'admin_init', array( $this, 'add_setting_files' ) );

		// Enqueue Scripts.
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 100 );

		// Add AJAX Hooks
		add_action( 'wp_ajax_aman_search_products', array( $this, 'search_products' ) );
	}

	public function search_products() {

		$nonce = isset( $_POST['nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['nonce'] ) ) : 0;

		if ( isset( $_POST['nonce'] ) && ! wp_verify_nonce( $nonce, 'aman-ajax-nonce' ) ) {
			die( esc_html__( 'Failed Ajax security check!', 'aman-hide-price' ) );
		}

		$s = isset( $_POST['q'] ) ? sanitize_text_field( wp_unslash( $_POST['q'] ) ) : '';

		$args = array(
			'post_type'   => array( 'product' ),
			'post_status' => 'publish',
			'numberposts' => 50,
			's'           => $s,
		);

		$products   = get_posts( $args );
		$data_array = array();

		if ( ! empty( $products ) ) {

			foreach ( $products as $product ) {

				$title        = ( mb_strlen( $product->post_title ) > 50 ) ? mb_substr( $product->post_title, 0, 49 ) . '...' : $product->post_title;
				$data_array[] = array( $product->ID, $title ); // array( Post ID, Post Title )
			}
		}

		wp_send_json( $data_array );
		die();
	}

	/**
	 * Add submenu is WooCommerce.
	 */
	public function admin_enqueue_scripts() {

		wp_enqueue_style( 'select2', plugins_url( 'assets/css/select2.css', WC_PLUGIN_FILE ), array(), '5.7.2' );
		wp_enqueue_script( 'select2', plugins_url( 'assets/js/select2/select2.min.js', WC_PLUGIN_FILE ), array( 'jquery' ), '4.0.3', true );

		wp_enqueue_script( 'aman-admin-js', AM_HIDE_PRICE_URL . 'assets/js/admin.js', array( 'jquery' ), '1.0.0', true );

		$data = array(
			'admin_url' => admin_url( 'admin-ajax.php' ),
			'nonce'     => wp_create_nonce( 'aman-ajax-nonce' ),

		);
		wp_localize_script( 'aman-admin-js', 'aman_php_vars', $data );
	}

	/**
	 * Add submenu is WooCommerce.
	 */
	public function add_submenu() {
		add_submenu_page(
			'woocommerce',
			__( 'Hide Price and Add to Cart', 'aman-hide-price' ),
			__( 'Hide Price and ATC', 'aman-hide-price' ),
			'manage_woocommerce',
			'hide-price-add-to-cart',
			array( $this, 'add_settings' ),
			20
		);
	}

	public function add_settings() {
		require_once AM_HIDE_PRICE_PLUGIN_DIR . 'includes/admin/settings/settings.php';
	}

	/**
	 * Add files of plugin.
	 */
	public function add_setting_files() {
		require_once AM_HIDE_PRICE_PLUGIN_DIR . 'includes/admin/settings/hide-price.php';
	}
}

new AM_Hide_Price_Admin();

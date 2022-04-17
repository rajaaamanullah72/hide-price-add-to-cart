<?php
/**
 * Hide price and add to cart.
 *
 * - Hide Price hooks and actions.
 * - Replace add to cart hooks and actions
 *
 * @package hide-price-add-to-cart\includes
 *
 */

defined( 'ABSPATH' ) || exit;

/**
 * AM_Hide_Price class.
 */
class AM_Hide_Price {

	/**
	 * Setup class.
	 */
	public function __construct() {

		if ( 'yes' == get_option( 'aman_enable_hide_price' ) ) {
			add_filter( 'woocommerce_get_price_html', array( $this, 'replace_price_html' ), 100, 2 );
		}

		if ( 'yes' == get_option( 'aman_enable_replace_atc' ) ) {

			add_action( 'woocommerce_loop_add_to_cart_link', array( $this, 'replace_archive_add_to_cart' ), 100, 2 );
			add_action( 'woocommerce_simple_add_to_cart', array( $this, 'replace_simple_add_to_cart' ), 1 );
			add_action( 'woocommerce_variable_add_to_cart', array( $this, 'replace_variable_add_to_cart' ), 1 );
			add_action( 'woocommerce_grouped_add_to_cart', array( $this, 'replace_grouped_add_to_cart' ), 1 );
			add_action( 'woocommerce_external_add_to_cart', array( $this, 'replace_external_add_to_cart' ), 1 );
		}
	}

	/**
	 * Replace price HTML.
	 */
	public function replace_price_html( $html, $product ) {

		if ( ! $this->is_user_role_applicable() ) {
			return $html;
		}

		$product_id = $product->is_type( 'variation' ) ? $product->get_parent_id() : $product->get_id();
		$products   = get_option( 'aman_hide_price_products' );
		$categories = get_option( 'aman_hide_price_categories' );

		$replace_price_text = get_option( 'aman_replace_price_text' );

		if ( in_array( $product_id, (array) $products ) ) {

			return $replace_price_text;

		} elseif ( ! empty( $categories ) && has_term( $categories, 'product_cat', $product_id ) ) {

			return $replace_price_text;
		}

		return $html;
	}

	/**
	 * Replace archive add to cart.
	 */
	public function replace_archive_add_to_cart( $link, $product ) {

		if ( ! $this->is_user_role_applicable() ) {
			return $html;
		}

		$product_id = $product->is_type( 'variation' ) ? $product->get_parent_id() : $product->get_id();
		$products   = get_option( 'aman_hide_price_products' );
		$categories = get_option( 'aman_hide_price_categories' );

		$replace_add_to_cart_text = get_option( 'aman_replace_add_to_cart_text' );

		if ( in_array( $product_id, (array) $products ) ) {

			return $replace_add_to_cart_text;

		} elseif ( ! empty( $categories ) && has_term( $categories, 'product_cat', $product_id ) ) {

			return $replace_add_to_cart_text;
		}

		return $link;
	}

	/**
	 * Replace simple add to cart.
	 */
	public function replace_simple_add_to_cart() {

		if ( ! $this->is_user_role_applicable() ) {
			return $html;
		}

		if ( $this->is_replace_add_to_cart( $product ) ) {
			remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
			add_action( 'woocommerce_simple_add_to_cart', array( $this, 'replace_add_to_cart_text' ), 30 );
		}
	}

	/**
	 * Replace variable add to cart.
	 */
	public function replace_variable_add_to_cart() {

		if ( ! $this->is_user_role_applicable() ) {
			return $html;
		}

		remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
		add_action( 'woocommerce_single_variation', array( $this, 'replace_add_to_cart_text' ), 30 );
	}

	/**
	 * Replace external add to cart.
	 */
	public function replace_external_add_to_cart() {

		if ( ! $this->is_user_role_applicable() ) {
			return $html;
		}

		remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );
		add_action( 'woocommerce_external_add_to_cart', array( $this, 'replace_add_to_cart_text' ), 30 );
	}

	/**
	 * Replace grouped add to cart.
	 */
	public function replace_grouped_add_to_cart() {

		if ( ! $this->is_user_role_applicable() ) {
			return $html;
		}

		remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
		add_action( 'woocommerce_grouped_add_to_cart', array( $this, 'replace_add_to_cart_text' ), 30 );
	}

	/**
	 * return replace add to cart text.
	 */
	public function replace_add_to_cart_text() {
		return get_option( 'aman_replace_add_to_cart_text' );
	}

	/**
	 * Is product applicable to replace add to cart button.
	 */
	public function is_user_role_applicable() {

		$setting_roles = get_option( 'aman_user_roles' );

		if ( empty( $setting_roles ) ) {
			return true;
		}

		$user_roles = is_user_logged_in() ? wp_get_current_user()->roles : array( 'guest' );

		if ( array_intersect( $user_roles, $setting_roles ) ) {
			return true;
		}
	}

	/**
	 * Is product applicable to replace add to cart button.
	 */
	public function is_replace_add_to_cart( $product ) {

		$product_id = $product->is_type( 'variation' ) ? $product->get_parent_id() : $product->get_id();

		$products   = get_option( 'aman_hide_price_products' );
		$categories = get_option( 'aman_hide_price_categories' );

		if ( in_array( $product_id, (array) $products ) ) {

			return $replace_add_to_cart_text;

		} elseif ( ! empty( $categories ) && has_term( $categories, 'product_cat', $product_id ) ) {

			return $replace_add_to_cart_text;
		}
	}
}

new AM_Hide_Price();

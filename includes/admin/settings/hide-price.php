<?php

/**
 * Settings for hide price and add to cart.
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.

}

add_settings_section('aman-general-sec', esc_html__('Hide Price and Add to Cart Settings', 'aman-hide-price'), '', 'aman_general_setting_section');

add_settings_field('aman_enable_hide_price', esc_html__('Enable Hide Price', 'aman-hide-price'), 'aman_enable_hide_price_callback', 'aman_general_setting_section', 'aman-general-sec', array(
	esc_html__('Enable hide price functionality.', 'aman-hide-price')
));

register_setting('aman_general_setting_fields', 'aman_enable_hide_price');

add_settings_field('aman_enable_replace_atc', esc_html__('Enable Hide Add to Cart', 'aman-hide-price'), 'aman_enable_replace_atc_callback', 'aman_general_setting_section', 'aman-general-sec', array(
	esc_html__('Enable hide add to cart functionality.', 'aman-hide-price')
));

register_setting('aman_general_setting_fields', 'aman_enable_replace_atc');

add_settings_field('aman_replace_price_text', esc_html__('Replace price text', 'aman-hide-price'), 'aman_replace_price_text_callback', 'aman_general_setting_section', 'aman-general-sec', array(
	esc_html__('Text to replace price.', 'aman-hide-price')
));

register_setting('aman_general_setting_fields', 'aman_replace_price_text');

add_settings_field('aman_replace_add_to_cart_text', esc_html__('Replace add to cart text ', 'aman-hide-price'), 'aman_replace_add_to_cart_text_callback', 'aman_general_setting_section', 'aman-general-sec', array(
	esc_html__('Text to replace add to cart button.', 'aman-hide-price')
));

register_setting('aman_general_setting_fields', 'aman_replace_add_to_cart_text');

add_settings_field('aman_hide_price_products', esc_html__('Select Products', 'aman-hide-price'), 'aman_hide_price_products_callback', 'aman_general_setting_section', 'aman-general-sec', array(
	esc_html__('Select products.', 'aman-hide-price')
));

register_setting('aman_general_setting_fields', 'aman_hide_price_products');

add_settings_field('aman_hide_price_categories', esc_html__('Select Categories', 'aman-hide-price'), 'aman_hide_price_categories_callback', 'aman_general_setting_section', 'aman-general-sec', array(
	esc_html__('Select Categories.', 'aman-hide-price')
));

register_setting('aman_general_setting_fields', 'aman_hide_price_categories');

add_settings_field('aman_user_roles', esc_html__('Select User Roles', 'aman-hide-price'), 'aman_user_roles_callback', 'aman_general_setting_section', 'aman-general-sec', array(
	esc_html__('Select User Roles.', 'aman-hide-price')
));

register_setting('aman_general_setting_fields', 'aman_user_roles');

function aman_enable_hide_price_callback($args) {
?>
	<input type="checkbox" name="aman_enable_hide_price" id="aman_enable_hide_price" value="yes" <?php echo checked('yes', esc_attr(get_option('aman_enable_hide_price'))); ?> />
	<p class="description afreg_additional_fields_section_title"> <?php echo wp_kses_post($args[0]); ?> </p>

<?php
}

function aman_enable_replace_atc_callback($args) {
?>
	<input type="checkbox" name="aman_enable_replace_atc" id="aman_enable_replace_atc" value="yes" <?php echo checked('yes', esc_attr(get_option('aman_enable_replace_atc'))); ?> />
	<p class="description afreg_additional_fields_section_title"> <?php echo wp_kses_post($args[0]); ?> </p>
<?php
}

function aman_replace_price_text_callback($args) {
	$value = get_option('aman_replace_price_text');
?>
	<input type="text" min="1" name="aman_replace_price_text" id="aman_replace_price_text" value="<?php echo esc_attr($value); ?>" />
	<p class="description afreg_additional_fields_section_title"> <?php echo wp_kses_post($args[0]); ?> </p>
<?php
}

function aman_replace_add_to_cart_text_callback($args) {
	$value = get_option('aman_replace_add_to_cart_text');
?>
	<input type="text" min="1" name="aman_replace_add_to_cart_text" id="aman_replace_add_to_cart_text" value="<?php echo esc_attr($value); ?>" />
	<p class="description afreg_additional_fields_section_title"> <?php echo wp_kses_post($args[0]); ?> </p>
<?php
}

function aman_hide_price_products_callback($args) {
	$aman_products = get_option('aman_hide_price_products');
?>
	<select name="aman_hide_price_products[]" data-placeholder="<?php esc_html_e('Select products', 'addify_wum'); ?>" style="width: 95%" class="aman_hide_price_products" multiple>
		<?php
		foreach ((array) $aman_products as $product_id) :

			$product = wc_get_product($product_id);

			if (!is_object($product)) {
				continue;
			}
		?>
			<option value="<?php echo intval($product_id); ?>" selected><?php echo esc_html($product->get_name()); ?></option>
		<?php
		endforeach;
		?>
	</select>
	<p class="description afreg_additional_fields_section_title"> <?php echo wp_kses_post($args[0]); ?> </p>
<?php
}

function aman_hide_price_categories_callback($args) {
	$value = (array) get_option('aman_hide_price_categories');

	$aman_categories = get_terms(array(
		'taxonomy' => 'product_cat',
		'fields' => 'ids',
	));
?>
	<select name="aman_hide_price_categories[]" data-placeholder="<?php esc_html_e('Select Categories', 'addify_wum'); ?>" style="width: 95%" class="aman_hide_price_categories" multiple>
		<?php
		foreach ((array) $aman_categories as $category_id) :

			$category = get_term($category_id, 'product_cat');

			if (!is_a($category, 'WP_Term')) {
				continue;
			}

		?>
			<option value="<?php echo intval($category_id); ?>" <?php echo in_array($category_id, $value) ? 'selected' : ''; ?>><?php echo esc_html($category->name); ?></option>
		<?php
		endforeach;
		?>
	</select>
	<p class="description afreg_additional_fields_section_title"> <?php echo wp_kses_post($args[0]); ?> </p>
<?php
}

/**
 * User roles.
 *
 * @param array $args arguments.
 */
function aman_user_roles_callback($args = array()) {

	$values = (array) get_option('aman_user_roles');
?>
	<div class="all_cats">
		<ul>
			<?php
			global $wp_roles;
			$roles          = $wp_roles->get_names();
			$roles['guest'] = __('Guest', 'aman-hide-price');

			foreach ($roles as $key => $value) {
			?>
				<li class="par_cat">
					<input type="checkbox" class="parent" name="aman_user_roles[]" id="" value="<?php echo esc_attr($key); ?>" <?php echo in_array((string) $key, $values, true) ? 'checked' : ''; ?> />
					<?php echo esc_attr($value); ?>
				</li>
			<?php
			}
			?>
		</ul>
	</div>
	<p class="description afreg_additional_fields_section_title"> <?php echo wp_kses_post($args[0]); ?> </p>
<?php
}

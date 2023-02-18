<?php

defined('ABSPATH') || exit;

$_nonce = isset($_POST['aman_nonce_field']) ? sanitize_text_field(wp_unslash($_POST['aman_nonce_field'])) : 0;

if (isset($_POST['aman_nonce_field']) && !wp_verify_nonce($_nonce, 'aman_nonce_action')) {
	die('Failed Security Check');
}

if (isset($_GET['tab'])) {
	$active_tab = sanitize_text_field(wp_unslash($_GET['tab']));
} else {
	$active_tab = 'general';
}

?>
<div class="aman-settings">
	<div class="wrap woocommerce">
		<h2><?php echo esc_html__('Hide Price and Add to Cart Settings', 'aman-hide-price'); ?></h2>
		<?php settings_errors(); ?>
		<h2 class="nav-tab-wrapper">
			<a href="?page=hide-price-add-to-cart" class="nav-tab <?php echo esc_attr($active_tab) === 'general' ? 'nav-tab-active' : ''; ?>"><?php echo esc_html__('General', 'aman-hide-price'); ?>
			</a>
		</h2>
	</div>
	<form method="post" action="options.php" class="aman_options_form">
		<?php

		if ('general' === $active_tab) {

			settings_fields('aman_general_setting_fields');
			do_settings_sections('aman_general_setting_section');
		}
		submit_button();
		?>
	</form>
</div>
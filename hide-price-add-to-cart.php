<?php

defined("ABSPATH") | exit;

class AM_Hide_Price_Main
{

    public function __construct()
    {
        add_action('wp_loaded', array($this, 'load_text_domain'));
        add_action('init', array($this, 'add_files'));
    }

    public function load_text_domain()
    {
        if (function_exists('load_plugin_textdomain')) {
            load_plugin_textdomain('aman-hide-price', false, dirname(plugin_basename(__FILE__)) . '/languages/');
        }
    }

    public function add_files()
    {
        if (is_admin()) {
            require_once AM_HIDE_PRICE_PLUGIN_DIR . 'includes/class-am-hide-price-admin.php';
        } else {
            require_once AM_HIDE_PRICE_PLUGIN_DIR . 'includes/class-am-hide-price-front.php';
        }

        require_once AM_HIDE_PRICE_PLUGIN_DIR . 'includes/class-am-hide-price.php';
    }
}
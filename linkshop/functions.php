<?php
/**
 * LinkShop functions and definitions
 *
 * @package LinkShop
 */

if ( ! defined( 'LINKSHOP_VERSION' ) ) {
    define( 'LINKSHOP_VERSION', '1.0.0' );
}

if ( ! defined( 'LINKSHOP_PATH' ) ) {
    define( 'LINKSHOP_PATH', trailingslashit( get_template_directory() ) );
}

if ( ! defined( 'LINKSHOP_URI' ) ) {
    define( 'LINKSHOP_URI', trailingslashit( get_template_directory_uri() ) );
}

// Load theme files.
require_once LINKSHOP_PATH . 'inc/setup.php';
require_once LINKSHOP_PATH . 'inc/customizer.php';
require_once LINKSHOP_PATH . 'inc/woocommerce-setup.php';
require_once LINKSHOP_PATH . 'inc/sms.php';
require_once LINKSHOP_PATH . 'inc/license.php';
require_once LINKSHOP_PATH . 'inc/analytics.php';
require_once LINKSHOP_PATH . 'inc/owner-dashboard.php';
require_once LINKSHOP_PATH . 'inc/frontend-store-settings.php';

/**
 * Enqueue scripts and styles.
 */
function linkshop_enqueue_assets() {
    $main_style    = LINKSHOP_PATH . 'assets/css/main.css';
    $account_style = LINKSHOP_PATH . 'assets/css/account-dashboard.css';
    $main_js       = LINKSHOP_PATH . 'assets/js/main.js';

    wp_enqueue_style( 'linkshop-main', LINKSHOP_URI . 'assets/css/main.css', array(), filemtime( $main_style ) );

    if ( is_account_page() ) {
        wp_enqueue_style( 'linkshop-account', LINKSHOP_URI . 'assets/css/account-dashboard.css', array( 'linkshop-main' ), filemtime( $account_style ) );
    }

    wp_enqueue_script( 'linkshop-main', LINKSHOP_URI . 'assets/js/main.js', array( 'jquery' ), filemtime( $main_js ), true );

    $store_settings = linkshop_get_store_settings();
    $accent_color   = isset( $store_settings['accent_color'] ) ? $store_settings['accent_color'] : '#2a7ae4';

    $custom_css = ':root{--ls-primary-color:' . esc_attr( $accent_color ) . ';}';
    wp_add_inline_style( 'linkshop-main', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'linkshop_enqueue_assets' );

/**
 * Load textdomain.
 */
function linkshop_load_textdomain() {
    load_theme_textdomain( 'linkshop', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'linkshop_load_textdomain' );


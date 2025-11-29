<?php
/**
 * WooCommerce related tweaks.
 *
 * @package LinkShop
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Declare WooCommerce features.
 */
function linkshop_woocommerce_support() {
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 450,
        'single_image_width'    => 800,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 1,
            'max_rows'        => 6,
            'default_columns' => 3,
            'min_columns'     => 2,
            'max_columns'     => 4,
        ),
    ) );

    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'linkshop_woocommerce_support' );

/**
 * Content wrappers.
 */
function linkshop_wc_wrapper_start() {
    echo '<div class="container content-area">';
}
add_action( 'woocommerce_before_main_content', 'linkshop_wc_wrapper_start', 10 );

function linkshop_wc_wrapper_end() {
    echo '</div>';
}
add_action( 'woocommerce_after_main_content', 'linkshop_wc_wrapper_end', 10 );

/**
 * Layout helpers.
 */
function linkshop_wc_body_class( $classes ) {
    $classes[] = 'linkshop-woocommerce';
    return $classes;
}
add_filter( 'body_class', 'linkshop_wc_body_class' );


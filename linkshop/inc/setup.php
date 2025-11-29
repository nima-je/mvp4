<?php
/**
 * Theme setup hooks.
 *
 * @package LinkShop
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function linkshop_setup_theme() {
    load_theme_textdomain( 'linkshop', get_template_directory() . '/languages' );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo', array(
        'height'      => 120,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ) );

    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
    add_theme_support( 'woocommerce' );

    register_nav_menus(
        array(
            'primary' => __( 'منوی اصلی', 'linkshop' ),
            'footer'  => __( 'منوی فوتر', 'linkshop' ),
        )
    );
}
add_action( 'after_setup_theme', 'linkshop_setup_theme' );

function linkshop_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'linkshop_content_width', 1200 );
}
add_action( 'after_setup_theme', 'linkshop_content_width', 0 );


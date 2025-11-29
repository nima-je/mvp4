<?php
/**
 * Customizer settings.
 *
 * @package LinkShop
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function linkshop_customize_register( $wp_customize ) {
    $wp_customize->add_setting(
        'linkshop_accent_color',
        array(
            'default'           => '#2a7ae4',
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'refresh',
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'linkshop_accent_color',
            array(
                'label'   => __( 'رنگ اصلی فروشگاه', 'linkshop' ),
                'section' => 'colors',
            )
        )
    );
}
add_action( 'customize_register', 'linkshop_customize_register' );

function linkshop_customizer_css() {
    $settings = function_exists( 'linkshop_get_store_settings' ) ? linkshop_get_store_settings() : array();
    $accent   = isset( $settings['accent_color'] ) ? $settings['accent_color'] : get_theme_mod( 'linkshop_accent_color', '#2a7ae4' );
    echo '<style id="linkshop-customizer-colors">:root{--ls-primary-color:' . esc_attr( $accent ) . ';}</style>';
}
add_action( 'wp_head', 'linkshop_customizer_css', 20 );


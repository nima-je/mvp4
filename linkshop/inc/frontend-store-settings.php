<?php
/**
 * Front-end store settings.
 *
 * @package LinkShop
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function linkshop_get_store_settings_option_name() {
    return 'linkshop_store_settings';
}

function linkshop_get_store_settings() {
    $defaults = array(
        'store_name'     => get_bloginfo( 'name' ),
        'primary_color'  => get_theme_mod( 'linkshop_primary_color', '#2a7ae4' ),
        'phone'          => '',
        'logo_id'        => get_theme_mod( 'custom_logo', 0 ),
    );

    $settings = get_option( linkshop_get_store_settings_option_name(), array() );

    if ( isset( $settings['accent_color'] ) && empty( $settings['primary_color'] ) ) {
        $settings['primary_color'] = $settings['accent_color'];
    }

    return wp_parse_args( $settings, $defaults );
}

function linkshop_get_store_name() {
    $settings   = linkshop_get_store_settings();
    $store_name = isset( $settings['store_name'] ) ? trim( $settings['store_name'] ) : '';

    return $store_name ? $store_name : get_bloginfo( 'name' );
}

function linkshop_get_store_phone() {
    $settings = linkshop_get_store_settings();
    return isset( $settings['phone'] ) ? $settings['phone'] : '';
}

function linkshop_get_store_logo_id() {
    $settings = linkshop_get_store_settings();
    if ( ! empty( $settings['logo_id'] ) ) {
        return absint( $settings['logo_id'] );
    }

    $custom_logo = get_theme_mod( 'custom_logo', 0 );
    return $custom_logo ? absint( $custom_logo ) : 0;
}

function linkshop_get_primary_color() {
    $settings = linkshop_get_store_settings();
    return isset( $settings['primary_color'] ) && $settings['primary_color'] ? $settings['primary_color'] : '#2a7ae4';
}

function linkshop_save_store_settings() {
    if ( empty( $_POST['linkshop_store_settings_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['linkshop_store_settings_nonce'] ), 'linkshop_store_settings_action' ) ) {
        return;
    }

    if ( ! current_user_can( 'manage_woocommerce' ) && ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $settings = linkshop_get_store_settings();

    if ( isset( $_POST['store_name'] ) ) {
        $settings['store_name'] = sanitize_text_field( wp_unslash( $_POST['store_name'] ) );
    }

    if ( isset( $_POST['primary_color'] ) ) {
        $sanitized_color = sanitize_hex_color( wp_unslash( $_POST['primary_color'] ) );
        $settings['primary_color'] = $sanitized_color ? $sanitized_color : '#2a7ae4';
        set_theme_mod( 'linkshop_primary_color', $settings['primary_color'] );
    }

    if ( isset( $_POST['phone'] ) ) {
        $settings['phone'] = sanitize_text_field( wp_unslash( $_POST['phone'] ) );
    }

    if ( isset( $_POST['logo_id'] ) ) {
        $settings['logo_id'] = absint( $_POST['logo_id'] );
        if ( $settings['logo_id'] ) {
            set_theme_mod( 'custom_logo', $settings['logo_id'] );
        }
    }

    update_option( linkshop_get_store_settings_option_name(), $settings );

    add_settings_error( 'linkshop_store_settings', 'saved', __( 'تنظیمات ذخیره شد.', 'linkshop' ), 'updated' );
}
add_action( 'init', 'linkshop_save_store_settings' );

function linkshop_store_settings_shortcode() {
    if ( ! current_user_can( 'manage_woocommerce' ) && ! current_user_can( 'manage_options' ) ) {
        return '<p>' . esc_html__( 'شما به این بخش دسترسی ندارید.', 'linkshop' ) . '</p>';
    }

    wp_enqueue_media();

    ob_start();
    $settings = linkshop_get_store_settings();
    $template = locate_template( 'templates/store-settings-form.php' );
    if ( $template ) {
        include $template;
    }
    return ob_get_clean();
}
add_shortcode( 'linkshop_store_settings', 'linkshop_store_settings_shortcode' );


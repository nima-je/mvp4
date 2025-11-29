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
        'store_name'   => get_bloginfo( 'name' ),
        'accent_color' => get_theme_mod( 'linkshop_accent_color', '#2a7ae4' ),
        'phone'        => '',
        'logo_id'      => get_theme_mod( 'custom_logo', 0 ),
    );

    $settings = get_option( linkshop_get_store_settings_option_name(), array() );

    return wp_parse_args( $settings, $defaults );
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
        update_option( 'blogname', $settings['store_name'] );
    }

    if ( isset( $_POST['accent_color'] ) ) {
        $settings['accent_color'] = sanitize_hex_color( wp_unslash( $_POST['accent_color'] ) );
        if ( ! $settings['accent_color'] ) {
            $settings['accent_color'] = '#2a7ae4';
        }
        set_theme_mod( 'linkshop_accent_color', $settings['accent_color'] );
    }

    if ( isset( $_POST['phone'] ) ) {
        $settings['phone'] = sanitize_text_field( wp_unslash( $_POST['phone'] ) );
    }

    if ( ! empty( $_FILES['store_logo']['name'] ) ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $file_id = media_handle_upload( 'store_logo', 0 );
        if ( ! is_wp_error( $file_id ) ) {
            $settings['logo_id'] = $file_id;
            set_theme_mod( 'custom_logo', $file_id );
        }
    } elseif ( isset( $_POST['logo_id'] ) ) {
        $settings['logo_id'] = absint( $_POST['logo_id'] );
        set_theme_mod( 'custom_logo', $settings['logo_id'] );
    }

    update_option( linkshop_get_store_settings_option_name(), $settings );

    add_settings_error( 'linkshop_store_settings', 'saved', __( 'تنظیمات ذخیره شد.', 'linkshop' ), 'updated' );
}
add_action( 'init', 'linkshop_save_store_settings' );

function linkshop_store_settings_shortcode() {
    if ( ! current_user_can( 'manage_woocommerce' ) && ! current_user_can( 'manage_options' ) ) {
        return '<p>' . esc_html__( 'شما به این بخش دسترسی ندارید.', 'linkshop' ) . '</p>';
    }

    ob_start();
    $settings = linkshop_get_store_settings();
    $template = locate_template( 'templates/store-settings-form.php' );
    if ( $template ) {
        include $template;
    }
    return ob_get_clean();
}
add_shortcode( 'linkshop_store_settings', 'linkshop_store_settings_shortcode' );


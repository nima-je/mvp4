<?php
/**
 * License handling.
 *
 * @package LinkShop
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function linkshop_get_license_option_name() {
    return 'linkshop_license_data';
}

function linkshop_get_license_status() {
    $data = get_option( linkshop_get_license_option_name(), array() );
    $defaults = array(
        'key'          => '',
        'status'       => 'inactive',
        'last_check'   => 0,
        'message'      => '',
        'endpoint'     => apply_filters( 'linkshop_license_endpoint', 'https://license.linkshop.test/check' ),
    );

    return wp_parse_args( $data, $defaults );
}

function linkshop_activate_license( $key ) {
    $endpoint = apply_filters( 'linkshop_license_endpoint', 'https://license.linkshop.test/check' );

    $response = wp_remote_post( $endpoint, array(
        'timeout' => 10,
        'body'    => array(
            'license_key' => $key,
            'site_url'    => home_url(),
        ),
    ) );

    $status  = 'invalid';
    $message = '';

    if ( is_wp_error( $response ) ) {
        $message = __( 'خطا در ارتباط با سرور لایسنس.', 'linkshop' );
    } else {
        $body = json_decode( wp_remote_retrieve_body( $response ), true );
        if ( isset( $body['status'] ) ) {
            $status  = sanitize_text_field( $body['status'] );
            $message = sanitize_text_field( $body['message'] ?? '' );
        } else {
            $message = __( 'پاسخ نامعتبر از سرور لایسنس.', 'linkshop' );
        }
    }

    $data = array(
        'key'        => sanitize_text_field( $key ),
        'status'     => $status,
        'last_check' => time(),
        'message'    => $message,
        'endpoint'   => $endpoint,
    );

    update_option( linkshop_get_license_option_name(), $data );

    return $data;
}

function linkshop_handle_license_form() {
    if ( empty( $_POST['linkshop_license_nonce'] ) || ! wp_verify_nonce( wp_unslash( $_POST['linkshop_license_nonce'] ), 'linkshop_activate_license' ) ) {
        return;
    }

    if ( ! current_user_can( 'manage_woocommerce' ) && ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $key = isset( $_POST['linkshop_license_key'] ) ? sanitize_text_field( wp_unslash( $_POST['linkshop_license_key'] ) ) : '';
    if ( $key ) {
        linkshop_activate_license( $key );
        add_settings_error( 'linkshop_license', 'license_saved', __( 'وضعیت لایسنس به‌روزرسانی شد.', 'linkshop' ), 'updated' );
    }
}
add_action( 'init', 'linkshop_handle_license_form' );

function linkshop_license_notice() {
    $license = linkshop_get_license_status();

    if ( empty( $license['key'] ) || 'valid' !== $license['status'] ) {
        echo '<div class="notice notice-warning"><p>' . esc_html__( 'لایسنس قالب فعال نیست. لطفاً از طریق پنل مالک فروشگاه یا مدیریت وردپرس آن را فعال کنید.', 'linkshop' ) . '</p></div>';
    }
}
add_action( 'admin_notices', 'linkshop_license_notice' );


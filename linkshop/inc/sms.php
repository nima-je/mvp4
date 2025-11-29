<?php
/**
 * SMS integration placeholder.
 *
 * @package LinkShop
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function linkshop_send_sms( $event, $data ) {
    $logger = wc_get_logger();
    $message = sprintf( 'SMS Event: %s | Data: %s', $event, wp_json_encode( $data ) );
    $logger->info( $message, array( 'source' => 'linkshop-sms' ) );

    // Example API call (commented out):
    /*
    $response = wp_remote_post( 'https://sms-provider.test/api/send', array(
        'timeout' => 10,
        'body'    => array(
            'phone'   => $data['phone'] ?? '',
            'message' => $data['message'] ?? '',
            'event'   => $event,
            'site'    => home_url(),
        ),
    ) );
    */
}

function linkshop_sms_new_order( $order_id ) {
    $order = wc_get_order( $order_id );
    if ( ! $order ) {
        return;
    }

    $phone   = $order->get_billing_phone();
    $message = sprintf( __( 'سفارش جدید #%d ثبت شد.', 'linkshop' ), $order->get_id() );
    linkshop_send_sms( 'order_created', array(
        'phone'    => $phone,
        'message'  => $message,
        'order_id' => $order->get_id(),
    ) );
}
add_action( 'woocommerce_new_order', 'linkshop_sms_new_order', 15 );

function linkshop_sms_order_status_changed( $order_id, $old_status, $new_status ) {
    $order = wc_get_order( $order_id );
    if ( ! $order ) {
        return;
    }

    $phone   = $order->get_billing_phone();
    $message = sprintf( __( 'وضعیت سفارش #%1$d به %2$s تغییر کرد.', 'linkshop' ), $order->get_id(), wc_get_order_status_name( $new_status ) );
    linkshop_send_sms( 'order_status_changed', array(
        'phone'       => $phone,
        'message'     => $message,
        'order_id'    => $order->get_id(),
        'old_status'  => $old_status,
        'new_status'  => $new_status,
    ) );
}
add_action( 'woocommerce_order_status_changed', 'linkshop_sms_order_status_changed', 10, 3 );

function linkshop_sms_new_customer( $customer_id ) {
    $user = get_userdata( $customer_id );
    if ( ! $user ) {
        return;
    }

    $phone = get_user_meta( $customer_id, 'billing_phone', true );
    linkshop_send_sms( 'user_registered', array(
        'phone'   => $phone,
        'message' => __( 'حساب کاربری شما در فروشگاه ایجاد شد.', 'linkshop' ),
        'user_id' => $customer_id,
    ) );
}
add_action( 'user_register', 'linkshop_sms_new_customer', 15 );

function linkshop_sms_low_stock( $product ) {
    if ( is_numeric( $product ) ) {
        $product = wc_get_product( $product );
    }

    if ( ! $product ) {
        return;
    }

    linkshop_send_sms( 'low_stock', array(
        'product_id' => $product->get_id(),
        'product'    => $product->get_name(),
        'message'    => sprintf( __( 'موجودی محصول %s رو به اتمام است.', 'linkshop' ), $product->get_name() ),
    ) );
}
add_action( 'woocommerce_low_stock', 'linkshop_sms_low_stock' );
add_action( 'woocommerce_no_stock', 'linkshop_sms_low_stock' );


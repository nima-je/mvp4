<?php
/**
 * Lightweight analytics helpers.
 *
 * @package LinkShop
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function linkshop_get_order_stats( $args = array() ) {
    if ( ! function_exists( 'wc_get_orders' ) ) {
        return array(
            'count' => 0,
            'total' => 0,
        );
    }

    $default_args = array(
        'status' => array( 'wc-processing', 'wc-completed', 'wc-on-hold' ),
        'limit'  => -1,
        'return' => 'objects',
    );

    $orders = wc_get_orders( wp_parse_args( $args, $default_args ) );

    $total = 0;
    foreach ( $orders as $order ) {
        $total += (float) $order->get_total();
    }

    return array(
        'count' => count( $orders ),
        'total' => $total,
    );
}

function linkshop_get_kpi_today_sales() {
    $today = current_time( 'Y-m-d' );
    $stats = linkshop_get_order_stats(
        array(
            'date_created' => $today . ' 00:00:00...' . $today . ' 23:59:59',
        )
    );

    return $stats['total'];
}

function linkshop_get_kpi_month_sales() {
    $start = date( 'Y-m-01 00:00:00', current_time( 'timestamp' ) );
    $stats = linkshop_get_order_stats(
        array(
            'date_created' => $start . '...' . current_time( 'mysql' ),
        )
    );

    return $stats['total'];
}

function linkshop_get_kpi_today_orders() {
    $today = current_time( 'Y-m-d' );
    $stats = linkshop_get_order_stats(
        array(
            'date_created' => $today . ' 00:00:00...' . $today . ' 23:59:59',
        )
    );

    return $stats['count'];
}

function linkshop_get_kpi_month_orders() {
    $start = date( 'Y-m-01 00:00:00', current_time( 'timestamp' ) );
    $stats = linkshop_get_order_stats(
        array(
            'date_created' => $start . '...' . current_time( 'mysql' ),
        )
    );

    return $stats['count'];
}

function linkshop_get_kpi_total_customers() {
    $counts = count_users();
    return isset( $counts['avail_roles']['customer'] ) ? (int) $counts['avail_roles']['customer'] : 0;
}

function linkshop_get_kpi_new_customers_30d() {
    $date = gmdate( 'Y-m-d H:i:s', current_time( 'timestamp' ) - ( 30 * DAY_IN_SECONDS ) );
    $query = new WP_User_Query(
        array(
            'role'       => 'customer',
            'date_query' => array(
                array(
                    'after'     => $date,
                    'inclusive' => true,
                ),
            ),
            'fields'     => 'ID',
        )
    );

    return (int) $query->get_total();
}

function linkshop_get_recent_orders( $limit = 5 ) {
    if ( ! function_exists( 'wc_get_orders' ) ) {
        return array();
    }

    return wc_get_orders(
        array(
            'limit'        => $limit,
            'orderby'      => 'date',
            'order'        => 'DESC',
            'status'       => array( 'wc-processing', 'wc-completed', 'wc-on-hold' ),
            'return'       => 'objects',
            'date_created' => '...' . current_time( 'mysql' ),
        )
    );
}

function linkshop_get_low_stock_products( $limit = 5 ) {
    if ( ! function_exists( 'wc_get_products' ) ) {
        return array();
    }

    return wc_get_products(
        array(
            'limit'       => $limit,
            'orderby'     => 'meta_value_num',
            'meta_key'    => '_stock',
            'order'       => 'ASC',
            'stock_status' => array( 'instock', 'outofstock' ),
        )
    );
}

function linkshop_get_best_sellers( $limit = 5 ) {
    if ( ! function_exists( 'wc_get_products' ) ) {
        return array();
    }

    return wc_get_products(
        array(
            'limit'   => $limit,
            'orderby' => 'total_sales',
            'order'   => 'DESC',
        )
    );
}


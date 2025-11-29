<?php
/**
 * Front-end owner dashboard.
 *
 * @package LinkShop
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function linkshop_render_owner_dashboard() {
    if ( ! current_user_can( 'manage_woocommerce' ) && ! current_user_can( 'manage_options' ) ) {
        echo '<p>' . esc_html__( 'شما به این بخش دسترسی ندارید.', 'linkshop' ) . '</p>';
        return;
    }

    $data = array(
        'kpis' => array(
            'today_sales'   => linkshop_get_kpi_today_sales(),
            'month_sales'   => linkshop_get_kpi_month_sales(),
            'today_orders'  => linkshop_get_kpi_today_orders(),
            'month_orders'  => linkshop_get_kpi_month_orders(),
            'total_customers' => linkshop_get_kpi_total_customers(),
            'new_customers' => linkshop_get_kpi_new_customers_30d(),
        ),
        'recent_orders' => linkshop_get_recent_orders( 5 ),
        'low_stock'     => linkshop_get_low_stock_products( 5 ),
        'best_sellers'  => linkshop_get_best_sellers( 5 ),
        'license'       => linkshop_get_license_status(),
    );

    $template = locate_template( 'templates/owner-dashboard.php' );
    if ( $template ) {
        include $template;
    }
}

function linkshop_owner_dashboard_shortcode() {
    ob_start();
    linkshop_render_owner_dashboard();
    return ob_get_clean();
}
add_shortcode( 'linkshop_owner_dashboard', 'linkshop_owner_dashboard_shortcode' );

function linkshop_owner_dashboard_account_block() {
    if ( current_user_can( 'manage_woocommerce' ) || current_user_can( 'manage_options' ) ) {
        echo '<div class="linkshop-owner-account">';
        echo '<h2>' . esc_html__( 'پنل مدیریت فروشگاه', 'linkshop' ) . '</h2>';
        linkshop_render_owner_dashboard();
        echo '</div>';
    }
}
add_action( 'woocommerce_account_dashboard', 'linkshop_owner_dashboard_account_block', 5 );


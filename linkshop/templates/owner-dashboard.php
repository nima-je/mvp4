<?php
/**
 * Owner dashboard template.
 *
 * @var array $data
 */
?>
<section class="ls-owner-dashboard">
    <div class="ls-dashboard-header">
        <h2><?php esc_html_e( 'پنل مدیریت فروشگاه', 'linkshop' ); ?></h2>
        <p><?php esc_html_e( 'مرور سریع عملکرد و وضعیت فروشگاه در یک نگاه.', 'linkshop' ); ?></p>
    </div>

    <div class="ls-kpi-grid">
        <?php $ls_price_cb = function( $amount ) { return function_exists( 'wc_price' ) ? wc_price( $amount ) : esc_html( number_format_i18n( $amount, 0 ) ); }; ?>
        <div class="ls-kpi-card">
            <h3><?php esc_html_e( 'فروش امروز', 'linkshop' ); ?></h3>
            <strong><?php echo $ls_price_cb( $data['kpis']['today_sales'] ); ?></strong>
        </div>
        <div class="ls-kpi-card">
            <h3><?php esc_html_e( 'فروش ماه', 'linkshop' ); ?></h3>
            <strong><?php echo $ls_price_cb( $data['kpis']['month_sales'] ); ?></strong>
        </div>
        <div class="ls-kpi-card">
            <h3><?php esc_html_e( 'سفارشات امروز', 'linkshop' ); ?></h3>
            <strong><?php echo intval( $data['kpis']['today_orders'] ); ?></strong>
        </div>
        <div class="ls-kpi-card">
            <h3><?php esc_html_e( 'سفارشات ماه', 'linkshop' ); ?></h3>
            <strong><?php echo intval( $data['kpis']['month_orders'] ); ?></strong>
        </div>
        <div class="ls-kpi-card">
            <h3><?php esc_html_e( 'مشتریان', 'linkshop' ); ?></h3>
            <strong><?php echo intval( $data['kpis']['total_customers'] ); ?></strong>
        </div>
        <div class="ls-kpi-card">
            <h3><?php esc_html_e( 'مشتریان ۳۰ روز اخیر', 'linkshop' ); ?></h3>
            <strong><?php echo intval( $data['kpis']['new_customers'] ); ?></strong>
        </div>
    </div>

    <div class="ls-dashboard-panels">
        <div class="ls-panel">
            <div class="ls-panel-header">
                <h3><?php esc_html_e( 'سفارشات اخیر', 'linkshop' ); ?></h3>
                <a class="ls-link" href="<?php echo esc_url( admin_url( 'edit.php?post_type=shop_order' ) ); ?>"><?php esc_html_e( 'مدیریت سفارشات', 'linkshop' ); ?></a>
            </div>
            <div class="ls-table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th><?php esc_html_e( 'سفارش', 'linkshop' ); ?></th>
                            <th><?php esc_html_e( 'تاریخ', 'linkshop' ); ?></th>
                            <th><?php esc_html_e( 'مشتری', 'linkshop' ); ?></th>
                            <th><?php esc_html_e( 'مبلغ', 'linkshop' ); ?></th>
                            <th><?php esc_html_e( 'وضعیت', 'linkshop' ); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ( ! empty( $data['recent_orders'] ) ) : ?>
                            <?php foreach ( $data['recent_orders'] as $order ) : ?>
                                <tr>
                                    <td>#<?php echo esc_html( $order->get_id() ); ?></td>
                                    <td><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></td>
                                    <td><?php echo esc_html( $order->get_formatted_billing_full_name() ); ?></td>
                                    <td><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></td>
                                    <td><?php echo esc_html( wc_get_order_status_name( $order->get_status() ) ); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr><td colspan="5"><?php esc_html_e( 'سفارشی یافت نشد.', 'linkshop' ); ?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="ls-panel">
            <div class="ls-panel-header">
                <h3><?php esc_html_e( 'محصولات کم‌موجودی', 'linkshop' ); ?></h3>
                <a class="ls-link" href="<?php echo esc_url( admin_url( 'edit.php?post_type=product' ) ); ?>"><?php esc_html_e( 'مدیریت محصولات', 'linkshop' ); ?></a>
            </div>
            <ul class="ls-list">
                <?php if ( ! empty( $data['low_stock'] ) ) : ?>
                    <?php foreach ( $data['low_stock'] as $product ) : ?>
                        <li>
                            <span><?php echo esc_html( $product->get_name() ); ?></span>
                            <span class="ls-badge ls-badge-warning"><?php echo esc_html( $product->get_stock_quantity() ); ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li><?php esc_html_e( 'محصول کم‌موجودی یافت نشد.', 'linkshop' ); ?></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="ls-panel">
            <div class="ls-panel-header">
                <h3><?php esc_html_e( 'پرفروش‌ترین‌ها', 'linkshop' ); ?></h3>
            </div>
            <ul class="ls-list">
                <?php if ( ! empty( $data['best_sellers'] ) ) : ?>
                    <?php foreach ( $data['best_sellers'] as $product ) : ?>
                        <li>
                            <span><?php echo esc_html( $product->get_name() ); ?></span>
                            <span class="ls-badge"><?php echo intval( $product->get_total_sales() ); ?> <?php esc_html_e( 'فروش', 'linkshop' ); ?></span>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li><?php esc_html_e( 'داده‌ای یافت نشد.', 'linkshop' ); ?></li>
                <?php endif; ?>
            </ul>
        </div>

        <div class="ls-panel">
            <div class="ls-panel-header">
                <h3><?php esc_html_e( 'اقدام‌های سریع', 'linkshop' ); ?></h3>
            </div>
            <ul class="ls-list">
                <li><a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=product' ) ); ?>"><?php esc_html_e( 'افزودن محصول جدید', 'linkshop' ); ?></a></li>
                <li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=shop_order' ) ); ?>"><?php esc_html_e( 'مشاهده همه سفارشات', 'linkshop' ); ?></a></li>
                <li><a href="<?php echo esc_url( admin_url( 'edit.php?post_type=shop_coupon' ) ); ?>"><?php esc_html_e( 'کوپن‌های تخفیف', 'linkshop' ); ?></a></li>
            </ul>
        </div>

        <div class="ls-panel ls-license-panel">
            <div class="ls-panel-header">
                <h3><?php esc_html_e( 'وضعیت لایسنس', 'linkshop' ); ?></h3>
            </div>
            <?php settings_errors( 'linkshop_license' ); ?>
            <p>
                <?php
                if ( 'valid' === $data['license']['status'] ) {
                    esc_html_e( 'لایسنس فعال است.', 'linkshop' );
                } else {
                    echo esc_html( $data['license']['message'] ? $data['license']['message'] : __( 'لایسنس فعال نیست.', 'linkshop' ) );
                }
                ?>
            </p>
            <form method="post" class="ls-license-form">
                <label for="ls-license-key"><?php esc_html_e( 'کلید لایسنس', 'linkshop' ); ?></label>
                <input type="text" id="ls-license-key" name="linkshop_license_key" value="<?php echo esc_attr( $data['license']['key'] ); ?>" />
                <?php wp_nonce_field( 'linkshop_activate_license', 'linkshop_license_nonce' ); ?>
                <button type="submit" class="button button-primary"><?php esc_html_e( 'فعال‌سازی', 'linkshop' ); ?></button>
            </form>
        </div>

        <div class="ls-panel">
            <div class="ls-panel-header">
                <h3><?php esc_html_e( 'تنظیمات فروشگاه', 'linkshop' ); ?></h3>
            </div>
            <?php echo do_shortcode( '[linkshop_store_settings]' ); ?>
        </div>
    </div>
</section>

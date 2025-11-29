<?php
/**
 * Header template
 *
 * @package LinkShop
 */
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
    <div class="container header-inner">
        <div class="site-branding">
            <?php
            $logo_id    = function_exists( 'linkshop_get_store_logo_id' ) ? linkshop_get_store_logo_id() : 0;
            $store_name = function_exists( 'linkshop_get_store_name' ) ? linkshop_get_store_name() : get_bloginfo( 'name' );

            if ( $logo_id ) {
                echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'class' => 'site-logo' ) );
            } elseif ( has_custom_logo() ) {
                the_custom_logo();
            }
            ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title"><?php echo esc_html( $store_name ); ?></a>
            <p class="site-description"><?php bloginfo( 'description' ); ?></p>
        </div>
        <nav class="primary-nav" aria-label="<?php esc_attr_e( 'منوی اصلی', 'linkshop' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'menu primary-menu',
                'container'      => false,
            ) );
            ?>
        </nav>
        <div class="header-actions">
            <button type="button" class="ls-theme-toggle" aria-label="<?php esc_attr_e( 'تغییر حالت نمایش', 'linkshop' ); ?>" onclick="linkshopToggleThemeMode()">
                <span class="ls-theme-toggle__icon" aria-hidden="true">☀️/🌙</span>
            </button>
            <?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
                <a class="header-cart" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
                    <span class="cart-count"><?php echo WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?></span>
                    <?php esc_html_e( 'سبد خرید', 'linkshop' ); ?>
                </a>
            <?php endif; ?>
            <?php if ( is_user_logged_in() ) : ?>
                <a class="header-account" href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>"><?php esc_html_e( 'حساب کاربری', 'linkshop' ); ?></a>
            <?php else : ?>
                <a class="header-account" href="<?php echo esc_url( wp_login_url() ); ?>"><?php esc_html_e( 'ورود / ثبت نام', 'linkshop' ); ?></a>
            <?php endif; ?>
            <?php $store_phone = function_exists( 'linkshop_get_store_phone' ) ? linkshop_get_store_phone() : ''; ?>
            <?php if ( $store_phone ) : ?>
                <a class="header-phone" href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $store_phone ) ); ?>"><?php echo esc_html( $store_phone ); ?></a>
            <?php endif; ?>
        </div>
    </div>
</header>
<main id="content" class="site-content">

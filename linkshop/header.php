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
            <?php if ( has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title"><?php bloginfo( 'name' ); ?></a>
            <?php endif; ?>
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
        </div>
    </div>
</header>
<main id="content" class="site-content">

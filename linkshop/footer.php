<?php
/**
 * Footer template
 *
 * @package LinkShop
 */
?>
</main>
<footer class="site-footer">
    <div class="container footer-inner">
        <div class="footer-brand">
            <h3><?php echo esc_html( function_exists( 'linkshop_get_store_name' ) ? linkshop_get_store_name() : get_bloginfo( 'name' ) ); ?></h3>
            <p><?php bloginfo( 'description' ); ?></p>
        </div>
        <div class="footer-contact">
            <?php $store_phone = function_exists( 'linkshop_get_store_phone' ) ? linkshop_get_store_phone() : ''; ?>
            <?php if ( $store_phone ) : ?>
                <p><?php esc_html_e( 'پشتیبانی تلفنی:', 'linkshop' ); ?> <a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', $store_phone ) ); ?>"><?php echo esc_html( $store_phone ); ?></a></p>
            <?php endif; ?>
        </div>
        <div class="footer-menu">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer',
                'menu_class'     => 'menu footer-menu',
                'container'      => false,
            ) );
            ?>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php echo esc_html( function_exists( 'linkshop_get_store_name' ) ? linkshop_get_store_name() : get_bloginfo( 'name' ) ); ?></p>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>

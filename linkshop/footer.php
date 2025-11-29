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
            <h3><?php bloginfo( 'name' ); ?></h3>
            <p><?php bloginfo( 'description' ); ?></p>
        </div>
        <div class="footer-contact">
            <?php $settings = linkshop_get_store_settings(); ?>
            <?php if ( ! empty( $settings['phone'] ) ) : ?>
                <p><?php esc_html_e( 'پشتیبانی تلفنی:', 'linkshop' ); ?> <a href="tel:<?php echo esc_attr( $settings['phone'] ); ?>"><?php echo esc_html( $settings['phone'] ); ?></a></p>
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
            <p>&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>

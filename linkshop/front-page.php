<?php
/**
 * Front page template
 *
 * @package LinkShop
 */

global $wp_query;
get_header();
?>
<div class="container home-hero">
    <div class="hero-content">
        <h1><?php bloginfo( 'name' ); ?></h1>
        <p><?php bloginfo( 'description' ); ?></p>
        <?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
            <a class="button" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'مشاهده محصولات', 'linkshop' ); ?></a>
        <?php endif; ?>
    </div>
</div>

<div class="container home-products">
    <h2><?php esc_html_e( 'جدیدترین محصولات', 'linkshop' ); ?></h2>
    <?php echo function_exists( 'wc_get_products' ) ? do_shortcode( '[products limit="8" columns="4" orderby="date" order="DESC"]' ) : ''; ?>
</div>
<?php get_footer(); ?>

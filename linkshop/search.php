<?php
/**
 * Search results template
 *
 * @package LinkShop
 */

global $wp_query;
get_header();
?>
<div class="container content-area">
    <header class="page-header">
        <h1 class="page-title"><?php printf( esc_html__( 'نتایج جستجو برای: %s', 'linkshop' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
    </header>

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '">', '</a></h2>' ); ?>
                </header>
                <div class="entry-summary">
                    <?php the_excerpt(); ?>
                </div>
            </article>
        <?php endwhile; ?>
        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e( 'نتیجه‌ای یافت نشد.', 'linkshop' ); ?></p>
    <?php endif; ?>
</div>
<?php get_footer(); ?>

<?php
/**
 * Main template file
 *
 * @package LinkShop
 */

global $wp_query;
get_header();
?>
<div class="container content-area">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                </header>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
        <?php the_posts_pagination(); ?>
    <?php else : ?>
        <p><?php esc_html_e( 'محتوایی یافت نشد.', 'linkshop' ); ?></p>
    <?php endif; ?>
</div>
<?php get_footer(); ?>

<?php
/**
 * Single post template
 *
 * @package LinkShop
 */

global $post;
get_header();
?>
<div class="container content-area">
    <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                <p class="entry-meta"><?php echo esc_html( get_the_date() ); ?></p>
            </header>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
            <?php if ( comments_open() || get_comments_number() ) : ?>
                <?php comments_template(); ?>
            <?php endif; ?>
        </article>
    <?php endwhile; ?>
</div>
<?php get_footer(); ?>

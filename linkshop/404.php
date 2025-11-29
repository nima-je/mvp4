<?php
/**
 * 404 template
 *
 * @package LinkShop
 */

global $wp_query;
get_header();
?>
<div class="container content-area">
    <h1 class="page-title"><?php esc_html_e( 'صفحه مورد نظر یافت نشد.', 'linkshop' ); ?></h1>
    <p><?php esc_html_e( 'به نظر می‌رسد صفحه حذف شده یا جابجا شده است.', 'linkshop' ); ?></p>
    <a class="button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'بازگشت به صفحه اصلی', 'linkshop' ); ?></a>
</div>
<?php get_footer(); ?>

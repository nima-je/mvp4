<?php
/**
 * Store settings form template.
 *
 * @var array $settings
 */
?>
<div class="ls-store-settings">
    <h2><?php esc_html_e( 'تنظیمات فروشگاه', 'linkshop' ); ?></h2>
    <?php settings_errors( 'linkshop_store_settings' ); ?>
    <form method="post">
        <?php wp_nonce_field( 'linkshop_store_settings_action', 'linkshop_store_settings_nonce' ); ?>
        <div class="ls-field">
            <label for="store_name"><?php esc_html_e( 'نام فروشگاه', 'linkshop' ); ?></label>
            <input type="text" id="store_name" name="store_name" value="<?php echo esc_attr( $settings['store_name'] ); ?>" />
        </div>
        <div class="ls-field">
            <label><?php esc_html_e( 'لوگو', 'linkshop' ); ?></label>
            <div class="ls-logo-preview" id="ls-logo-preview">
                <?php if ( ! empty( $settings['logo_id'] ) ) : ?>
                    <?php echo wp_get_attachment_image( $settings['logo_id'], 'medium' ); ?>
                <?php else : ?>
                    <span class="ls-logo-placeholder"><?php esc_html_e( 'لوگویی انتخاب نشده است.', 'linkshop' ); ?></span>
                <?php endif; ?>
            </div>
            <div class="ls-logo-actions">
                <button type="button" class="button ls-logo-picker"><?php esc_html_e( 'انتخاب / بارگذاری لوگو', 'linkshop' ); ?></button>
                <button type="button" class="button button-secondary ls-clear-logo" data-placeholder="<?php esc_attr_e( 'لوگویی انتخاب نشده است.', 'linkshop' ); ?>"><?php esc_html_e( 'حذف لوگو', 'linkshop' ); ?></button>
            </div>
            <input type="hidden" id="logo_id" name="logo_id" value="<?php echo esc_attr( $settings['logo_id'] ); ?>" />
        </div>
        <div class="ls-field">
            <label for="primary_color"><?php esc_html_e( 'رنگ اصلی', 'linkshop' ); ?></label>
            <input type="color" id="primary_color" name="primary_color" value="<?php echo esc_attr( $settings['primary_color'] ); ?>" />
        </div>
        <div class="ls-field">
            <label for="phone"><?php esc_html_e( 'شماره موبایل فروشگاه', 'linkshop' ); ?></label>
            <input type="text" id="phone" name="phone" value="<?php echo esc_attr( $settings['phone'] ); ?>" />
        </div>
        <button type="submit" class="button button-primary"><?php esc_html_e( 'ذخیره تنظیمات', 'linkshop' ); ?></button>
    </form>
</div>

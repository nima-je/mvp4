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
    <form method="post" enctype="multipart/form-data">
        <?php wp_nonce_field( 'linkshop_store_settings_action', 'linkshop_store_settings_nonce' ); ?>
        <div class="ls-field">
            <label for="store_name"><?php esc_html_e( 'نام فروشگاه', 'linkshop' ); ?></label>
            <input type="text" id="store_name" name="store_name" value="<?php echo esc_attr( $settings['store_name'] ); ?>" />
        </div>
        <div class="ls-field">
            <label for="store_logo"><?php esc_html_e( 'لوگو', 'linkshop' ); ?></label>
            <?php if ( ! empty( $settings['logo_id'] ) ) : ?>
                <div class="ls-logo-preview">
                    <?php echo wp_get_attachment_image( $settings['logo_id'], 'medium' ); ?>
                </div>
            <?php endif; ?>
            <input type="file" id="store_logo" name="store_logo" accept="image/*" />
            <input type="hidden" name="logo_id" value="<?php echo esc_attr( $settings['logo_id'] ); ?>" />
        </div>
        <div class="ls-field">
            <label for="accent_color"><?php esc_html_e( 'رنگ اصلی', 'linkshop' ); ?></label>
            <input type="color" id="accent_color" name="accent_color" value="<?php echo esc_attr( $settings['accent_color'] ); ?>" />
        </div>
        <div class="ls-field">
            <label for="phone"><?php esc_html_e( 'شماره موبایل فروشگاه', 'linkshop' ); ?></label>
            <input type="text" id="phone" name="phone" value="<?php echo esc_attr( $settings['phone'] ); ?>" />
        </div>
        <button type="submit" class="button button-primary"><?php esc_html_e( 'ذخیره تنظیمات', 'linkshop' ); ?></button>
    </form>
</div>

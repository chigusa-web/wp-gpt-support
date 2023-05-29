<?php

if (!defined('ABSPATH')) exit;

/**
 * ページ: 設定画面
 */
function page_wp_gpt_support_settings()
{
    // 設定保存
    wp_gpt_support_settings_update();

    if (isset($_POST['settings_submit'])) {
        $api_key = sanitize_text_field($_POST['api_key']);
    } else {
        // マスクして表示
        $api_key = get_api_key_mask();
    }

?>
    <div class="wrap">
        <h1>WP GPT Support 設定</h1>

        <?php settings_errors('wp_gpt_support_options'); ?>

        <form method="post">
            <?php wp_nonce_field('wp_gpt_support_settings', 'wp_gpt_support_settings_nonce'); ?>

            <table class="form-table">
                <tr valign="top">
                    <th scope="row">ChatGPT API Key</th>
                    <td><input type="text" name="api_key" value="<?php echo esc_attr($api_key); ?>" /></td>
                </tr>
            </table>

            <input type="submit" name="settings_submit" class="button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />
        </form>
    </div>
<?php
}

/**
 * 設定保存
 */
function wp_gpt_support_settings_update()
{

    // 権限
    if (!current_user_can('manage_options')) {
        return;
    }

    if (!isset($_POST['settings_submit'])) {
        return;
    }

    // CSRF
    if (!check_admin_referer('wp_gpt_support_settings', 'wp_gpt_support_settings_nonce')) {
        return;
    }

    $api_key = sanitize_text_field($_POST['api_key']);

    if ($api_key != get_api_key_mask()) {
        update_option('wp_gpt_support_settings_api_key', $api_key);
    }

    echo '<div class="updated"><p>保存しました</p></div>';
}

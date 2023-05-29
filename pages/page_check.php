<?php

if (!defined('ABSPATH')) exit;

/**
 * ページ: チェック画面
 */
function page_wp_gpt_support_check()
{
    // 指示文
    $direction = '以下の文章に、誤字・脱字があれば教えて';
?>
    <div class="wrap">
        <h1>WP GPT Support</h1>

        <form action="#" method="post" id="form_gpt_support">

            <?php wp_nonce_field('wp_gpt_support_check', 'wp_gpt_support_check_nonce'); ?>

            <table class="form-table">

                <tr valign="top">
                    <th scope="row"><label for="">記事ID</label></th>
                    <td><input type="number" name="post_id" value="" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">指示文</th>
                    <td><textarea name="direction" rows="5" cols="50"><?php echo esc_textarea($direction); ?></textarea></td>
                </tr>
            </table>

            <input type="submit" id="gpt_support_submit" class="button-primary" value="GPTチェック" />

        </form>

        <table class='gpt-table'>
            <thead>
                <tr>
                    <th>記事</th>
                    <th>ChatGPT</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td id="post_contents"></td>
                    <td id="gpt_message"></td>
                </tr>
            </tbody>
        </table>

    </div>
<?php
}

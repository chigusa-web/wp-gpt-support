<?php

if (!defined('ABSPATH')) exit;

/**
 * JS: チェック画面
 */
add_action(
    'admin_footer-gpt-support_page_wp_gpt_support_check',
    function () {
?>
    <script>
        jQuery(document).ready(function($) {

            $('#form_gpt_support').submit(function(event) {

                event.preventDefault();

                const postData = this;

                $('#post_contents').text('');
                $('#gpt_message').text('');

                // 非同期で処理を呼び出し
                const fd = new FormData(postData);
                fd.append('action', 'wp_gpt_support_check');

                $.ajax({
                    type: "POST",
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    dataType: 'json',
                    data: fd,
                    processData: false,
                    contentType: false,
                }).done(function(data, textStatus, jqXHR) {

                    // 結果を反映
                    $('#post_contents').text(data['post_contents']);
                    $('#gpt_message').text(data['gpt_message']);

                }).fail(function(data, status, error) {

                    alert(error);
                });

                return false;
            });

        });
    </script>
<?php
    }
);

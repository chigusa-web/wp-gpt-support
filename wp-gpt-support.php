<?php

/**
 * Plugin Name:       WP GPT Support
 * Description:       ChatGPTサポート
 * Version:           1.0.0
 * Author:            Chigusa
 * Author URI:        https://chigusa-web.com/
 * License:           MIT
 */

if (!defined('ABSPATH')) exit;

// バージョン
define('GPT_SUPPORT_VERSION', '1.0.0');

// 設定
require_once(plugin_dir_path(__FILE__) . 'options.php');

// メニュー
require_once(plugin_dir_path(__FILE__) . 'menus.php');

// チェック画面
require_once(plugin_dir_path(__FILE__) . 'pages/page_check.php');
require_once(plugin_dir_path(__FILE__) . 'js/js_check.php');
require_once(plugin_dir_path(__FILE__) . 'ajax/gpt_support_check.php');

// 設定画面
require_once(plugin_dir_path(__FILE__) . 'pages/page_settings.php');

/**
 * CSSの読み込み
 */
function wp_gpt_support_styles()
{
    wp_enqueue_style(
        'wp_gpt_support_styles',
        plugin_dir_url(__FILE__) . 'css/styles.css',
        array(),
        GPT_SUPPORT_VERSION
    );
}
add_action('admin_enqueue_scripts', 'wp_gpt_support_styles');

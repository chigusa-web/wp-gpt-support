<?php

if (!defined('ABSPATH')) exit;

/**
 * 管理画面にメニューを追加
 */
add_action('admin_menu', 'wpdocs_register_wp_gpt_support');
function wpdocs_register_wp_gpt_support()
{
    add_menu_page(
        'GPT Support',
        'GPT Support',
        // 権限
        'manage_options',
        'wp_gpt_support',
        'page_wp_gpt_support',
        // アイコン
        'dashicons-editor-spellcheck',
        // メニュー位置
        999
    );

    // チェック画面
    add_submenu_page(
        'wp_gpt_support',
        'チェック',
        'チェック',
        'manage_options',
        'wp_gpt_support_check',
        'page_wp_gpt_support_check'
    );

    // 設定画面
    add_submenu_page(
        'wp_gpt_support',
        '設定',
        '設定',
        'manage_options',
        'wp_gpt_support_settings',
        'page_wp_gpt_support_settings'
    );

    // トップレベルのメニューを削除
    remove_submenu_page('wp_gpt_support', 'wp_gpt_support');
}

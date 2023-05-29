<?php

if (!defined('ABSPATH')) exit;

/**
 * APIキーの取得
 */
function get_api_key()
{
    return get_option('wp_gpt_support_settings_api_key');
}

/**
 * APIキーの取得(マスク)
 */
function get_api_key_mask()
{
    $key = get_option('wp_gpt_support_settings_api_key');
    if (empty($key)) {
        return "";
    } else {
        $first = substr($key, 0, 5);
        return $first . '*******';
    }
}

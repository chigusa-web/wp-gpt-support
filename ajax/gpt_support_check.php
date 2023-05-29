<?php

if (!defined('ABSPATH')) exit;

/**
 * Ajax: ChatGPT チェック
 */
add_action('wp_ajax_wp_gpt_support_check', 'ajax_wp_gpt_support_check');
function ajax_wp_gpt_support_check()
{

    // 権限
    if (!current_user_can('manage_options')) {
        return;
    }

    // CSRF
    check_ajax_referer('wp_gpt_support_check', 'wp_gpt_support_check_nonce');

    $post_id = $_POST['post_id'];
    $direction = $_POST['direction'];

    // 記事取得
    $page = get_post($post_id);
    $contents = strip_tags($page->post_content);
    $contents = preg_replace('/(\n)+/us', '$1', $contents);

    if (empty($contents)) {
        echo wp_json_encode([
            'post_contents' =>  'コンテンツがありません',
        ]);
        wp_die();
    }

    try {
        // ChatGPTに問い合わせ

        $gpt_role = 'あなたはブログの編集者です。';
        $to_send = $direction . '\n\n' . $contents;

        $response = chat_gpt($gpt_role, $to_send);

        if (isset($response->error)) {
            echo wp_json_encode([
                'post_contents' => $contents,
                'gpt_message' => $response->error->message
            ]);
            die();
        }

        $message = $response->choices[0]->message->content;

        echo wp_json_encode([
            'post_contents' => $contents,
            'gpt_message' => $message,
        ]);

        die();
    } catch (Exception $e) {
        echo wp_json_encode([
            'post_contents' => $contents,
            'gpt_message' => $e->getMessage()
        ]);
        die();
    }
}

/**
 * ChatGPT API
 */
function chat_gpt($system, $user)
{
    // ChatGPT APIのエンドポイントURL
    $url = "https://api.openai.com/v1/chat/completions";

    // APIキー
    $api_key = get_api_key();
    if (empty($api_key)) {
        throw new Exception('No API key');
    }

    // ヘッダー
    $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer $api_key"
    );

    // パラメータ
    $data = array(
        "model" => "gpt-3.5-turbo",
        "messages" => [
            [
                "role" => "system",
                "content" => $system
            ],
            [
                "role" => "user",
                "content" => $user
            ]
        ]
    );

    // cURLセッションの初期化
    $ch = curl_init();

    // cURLオプションの設定
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // タイムアウトを設定
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);

    // リクエストの送信
    $response = curl_exec($ch);

    // エラーを取得
    $error_no = curl_errno($ch);
    $errors = curl_error($ch);

    // cURLセッションの終了
    curl_close($ch);

    if ($error_no !== 0) {
        throw new Exception($errors);
    }

    return json_decode($response);
}

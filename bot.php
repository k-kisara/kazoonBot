<?php

// Load libraries
require __DIR__ . '/vendor/autoload.php';

/**
 * Key / Token を読み込む
 * 変数の中身は、それぞれ対応するものを入れてください。
 */
// Make an alias "Client" instead of "mpyw\Cowitter\Client"
use mpyw\Cowitter\Client;

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

// Consumer Key
$consumer_key = getenv('TWITTER_API_KEY');
// Consumer Secret
$consumer_secret = getenv('TWITTER_API_SECRET');
// Access Token
$access_token = getenv('TWITTER_ACCESS_TOKEN');
// Access Token Secret
$access_token_secret = getenv('TWITTER_ACCESS_TOKEN_SECRET');
// User ID
$user_id = getenv('TWITTER_USER_ID');
// Retweet List ID
// $retweet_list_id = getenv('TWITTER_RETWEET_LIST_ID');

try {

     // Twitterの認証を通す
     $client = new Client([
         $consumer_key, $consumer_secret, $access_token, $access_token_secret,
     ]);

     // APIに接続し、ツイートを投稿する
     $status = $client->post('statuses/update', [
        'status' => 'みみぺんブログのBot！' ,
     ]);

     // 投稿したツイートのURLを表示する
     echo "URL: https://twitter.com/{$status->user->screen_name}/status/{$status->id_str}\n";
} catch (\RuntimeException $e) {
    // エラーが起きたら、その内容を表示する
    echo "Error: {$e->getMessage()}\n";
}
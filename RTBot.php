<?php
// Load libraries
require __DIR__ . '/vendor/autoload.php';

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
// Retweet count
$retweet_count = 0;

$client = new Client([
  $consumer_key, $consumer_secret, $access_token, $access_token_secret,
]);

try {

  // get list ID (Retweet list)
  $lists = $client->get('lists/list', [
    'user_id' => $user_id,
  ]);

  $retweet_list_id = $lists[0]->id_str;

  echo $list[0]->name;

  $response = $client->get('lists/statuses', [
    'list_id' => $retweet_list_id,
    'count' => 100,
    'tweet_mode' => 'extended'
  ]);

  foreach ($response as $tweet) {
    echo "{$tweet->full_text}\n";
    if (strpos($tweet->full_text, 'みみぺん') !== false) {
      $status = $client->post("statuses/retweet/$tweet->id_str", []);
      echo "Retweet: https://twitter.com/{$status->user->screen_name}/status/{$status->id_str}\n";
      $retweet_count++;
    }

    if ($retweet_count === 16) {
      echo "Retweet count reached upper limit.\n";
      break;
    }
  }

} catch (\RuntimeException $e) {

  // Jump here if an errors has occurred
  echo "Error: {$e->getMessage()}\n";

}

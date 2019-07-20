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

$client = new Client([
  $consumer_key, $consumer_secret, $access_token, $access_token_secret,
]);

try {

  // get list ID (Retweet list)
  $lists = $client->get('lists/list', [
    'user_id' => $user_id,
  ]);

  $retweet_list_id = $lists[0]->id_str;

  $response = $client->get('lists/statuses', [
    'list_id' => $retweet_list_id,
    'count' => 25,
  ]);

  foreach ($response as $tweet) {
    if(strpos($tweet->text, 'みみぺん') !== false) {
      // TODO: リツイートする
      $status = $client->post("statuses/retweet/$tweet->id_str", []);
      echo "Retweet: $status->text";
    }
  }

} catch (\RuntimeException $e) {

  // Jump here if an errors has occurred
  echo "Error: {$e->getMessage()}\n";

}

/**
 * TODO
 * 0. Get credencials and rewrite .env
 * 1. First cron
 *   1. Find users who follow this account(@kazoonBot) and retweet my fix tweet
 *   2. If some users are find by 1., add them to "Retweet List"
 *   3. Compore users in followers of this bot and the List
 *   4. (If some users unfollow this bot, remove them from the List)
 * 2. Second cron
 *   1. Monitor tweets in the List. If a sentence which includes "みみぺん" is
 *      tweeted, retweet it.
 */

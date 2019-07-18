<?php

require __DIR__ . '/vendor/autoload.php';

use mpyw\Cowitter\Client;

$dotenv = Dotenv\Dotenv::create(__DIR__);
$dotenv->load();

$consumer_key = getenv('TWITTER_API_KEY');
$consumer_secret = getenv('TWITTER_API_SECRET');
$access_token = getenv('TWITTER_ACCESS_TOKEN');
$access_token_secret = getenv('TWITTER_ACCESS_TOKEN_SECRET');
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

  // get users who Retweeted fixed tweet(1)
  $retweeted_users = $client->get('statuses/retweeters/ids', [
    'id' => '1151671141796216832',
  ]);

  $retweeted_users_ids = $retweeted_users->ids;

  // get followers(2)
  $followers = $client->get('followers/ids', [
    'user_id' => $user_id,
  ]);

  $followers_ids = $followers->ids;

  // push member into Retweet list who matches (1) and (2)
  foreach ($retweeted_users_ids as $r_id) {
    if (in_array($r_id, $followers_ids)) {
      $create_status = $client->post('lists/members/create', [
        'list_id' => $retweet_list_id,
        'user_id' => $r_id,
      ]);
      echo "Created: {$create_status->user->name}\n";
    }
  }

  // get Retweet list members
  $retweet_list_members = $client->get('list/members', [
    'list_id' => $retweet_list_id,
  ]);

  $retweet_list_users = $retweet_list_members->users;

  // Listメンバーがフォローを外していたら、リストから削除する
  foreach ($retweet_list_users as $user) {
    if (!in_array($user->id, $followers_ids) || !in_array($user_id, $retweeted_users_ids)) {
      $destroyed_status = $client->post('lists/members/destroy', [
        'list_id' => $retweet_list_id,
        'user_id' => $user->id,
      ]);
      echo "Destroyed: {$destroyed_status->user->name}\n";
    }
  }

} catch (\RuntimeException $e) {

  // Jump here if an errors has occurred
  echo "Error: {$e->getMessage()}\n";

}

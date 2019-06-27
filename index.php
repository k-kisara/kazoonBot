<?php
// OAuth Script Import
require('TwistOAuth.phar');

$dotenv = new DotEnv\DotEnv('./.env');
$dotenv->load();

// Consumer Key
$consumer_key = getenv('TWITTER_API_KEY');
// Consumer Secret
$consumer_secret = getenv('TWITTER_API_SECRET');
// Access Token
$access_token = getenv('TWITTER_ACCESS_TOKEN');
// Access Token Secret
$access_token_secret = getenv('TWITTER_ACCESS_TOKEN_SECRET');

$connection = new TwistOAuth(
  $consumer_key, $consumer_secret, $access_token, $access_token_secret
);

/**
 * TODO
 * 0. Get credencials and rewrite .env
 * 1. First cron
 *   1. Find users who follow this account(@kazoonBot) and retweet my fix tweet
 *   2. If some users are find by 1., add them to "Retweet List"
 *   3. Compore users in followers of this bot and the List
 *   4. (If some users unfollow this bot, remove them from the List)
 * 2. Second cron
 *   1. Monitor tweets in the List. If a sentence which includes "RT" is
 *      tweeted, retweet it.
 */
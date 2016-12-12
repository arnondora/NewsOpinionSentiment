<?php

use Abraham\TwitterOAuth\TwitterOAuth;
use AYLIEN\TextAPI;

//Twitter Helper Functions
function searchTweet ($query)
{
  $connection = new TwitterOAuth(env('TWITTER_CONSUMER_KEY',null), env('TWITTER_CONSUMER_SECRET',null), env('TWITTER_ACCESS_TOKEN',null), env('TWITTER_TOKEN_SECRET',null));
  $content = $connection->get("account/verify_credentials");

  $query = array(
    "q" => $query,
    "count" => 100,
    "result_type" => "mixed"
  );

  return $connection->get('search/tweets', $query);
}

function extractText ($tweets)
{
  $tweetsText = array();

  foreach ($tweets->statuses as $result)
  {
    array_push($tweetsText,$result->text);
  }

  return $tweetsText;
}

//AYLIEN API
function getTextAnalyticConnector ()
{
  return new TextAPI("0733feb6", "e47db1a59b51d0fd49576f609cf544a1");
}

//AYLIEN Sentiment API
function getSentimentScore ($text)
{
  $textapi = getTextAnalyticConnector();
  $sentiment = $textapi->Sentiment(array('text' => $text));
  var_dump($sentiment->polarity);
  var_dump($sentiment->polarity_confidence);
}

//AYLIEN Hashtag Analysis
function getHashtags ($url)
{
  $textapi = getTextAnalyticConnector();
  return $textapi->Hashtags(array('url' => $url));
}
?>

<?php
ini_set( 'display_errors', 1 );
ini_set('error_reporting', E_ALL);

require 'vender/TwistOAuth-master/build/TwistOAuth.phar';

$consumer_key = '6OTBeMZDiN4Sh9HHIv1BVW5cn';
$consumer_secret = 'wggPRikuqES4odsmRZw78dQCEvVML105lYf6hUo9O7fBgtC0ef';
$access_token = '936442582132858880-fZ1rE9Lt3s9t2Cb9RwLwZ6yuSxGcG8g';
$access_token_secret = 'RSoP9lY10mTTSTFaNvnq60aO5YFvFMiixeN6wrRozEIFF';

$connection = new TwistOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);


function h($str){
    return htmlspecialchars($str, ENT_QUOTES, 'utf-8');
}

$q = h($_GET['q']);
// $q = 'サンマルクカフェ 人形町店 OR サンマルクカフェ 小伝馬町駅前店 OR サンドウィッチパーラーまつむら 人形町本店 OR デリフランス 日本橋 OR サンドッグイン 神戸屋 馬喰横山駅店 OR ドイツパンの店 タンネ OR サブウェイ 日本橋兜町店 OR 室町ボンクール本店 OR Signifiant Signifie 日本橋タカシマヤ店 OR サンドイッチハウス メルヘン 髙島屋日本橋店';

// キーワードによるツイート検索
$tweets_params = ['q' => $q ,'count' => '10'];
$tweets = $connection->get('search/tweets', $tweets_params)->statuses;

// var_dump($tweets);
echo json_encode($tweets, true);
// var_dump($tweets);

// echo "end";
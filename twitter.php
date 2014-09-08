<?php

require_once("twitteroauth.php"); //twitteroauth.phpのパス。同一ディレクトリにOAuth.phpも設置する
require_once("Curl.class.php");

$Curl = new Curl();

$Available_Room = json_decode($Curl->GetAvailableRoom());

// Consumer keyの値
$consumer_key = "aa4l2kTzNrGWKJjXIz2XI9vSK";
// Consumer secretの値
$consumer_secret = "677oNtWD24HsIxJLLYuVsoImrWxLaz7nTbKeUKBhofxZzrBlCn";
// Access Tokenの値
$access_token = "2791583394-sxUUyWvMMF5WeMmfARiX1uYtvuZcve0hz3jLXuJ";
// Access Token Secretの値
$access_token_secret = "JZ5gghLrHzBh6cdx3bDCx5hGvukGY7lKRfkcnkVNJV30S";
// OAuthオブジェクト生成
$to = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);

$time = date( "H時i分", time() );

$announce = $time."現在の部室の空き状況をお知らせします。";

//投稿
$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));


foreach ($Available_Room as $key => $val) {
	$message = $time."現在、".$val->period."限の".$val->room."室が空いています\n ";
	//投稿
	$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
}


// レスポンスを表示する場合は下記コメントアウトを外す
//header("Content-Type: application/xml");
//echo $req;

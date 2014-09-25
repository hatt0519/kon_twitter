<?php

require_once("twitteroauth.php"); //twitteroauth.phpのパス。同一ディレクトリにOAuth.phpも設置する
require_once("Curl.class.php");

$Curl = new Curl();

$Available_Room = json_decode($Curl->GetAvailableRoom());
$holiday_checker = json_decode($Curl->GetholidayChecker());
$ban_checker = json_decode($Curl->GetbanChecker());

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

$today = new DateTime();

$time = $today->format("H時i分");
//$time = "08時45分";
if($ban_checker->ban_flg == 1){
	$ban = "お姉ちゃん、残念だけど今日は部室の使用禁止なんだ。。。";
	$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$ban));
}else{	

	if($time == "08時45分"){

		if(empty($holiday_checker)){
			$greeting = "お姉ちゃん!!今日休日日程だから気をつけてね!!1限と3限以外開始時刻が違うよ!!";
		}else{
			$greeting = "お姉ちゃんおはよう!!今日も一日がんばろうね!!";
		}
		$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$greeting));
	}

	if (!empty($Available_Room)){
		$announce = "お姉ちゃん！！".$time."現在の部室の空き状況を教えるね！！";
	}else{
		$announce = $time."お姉ちゃん！！残念だけど今空いている部室はないよ。。。";
	}

	//投稿
	$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));

	foreach ($Available_Room as $key => $val) {
		if ($time == "12時10分"){
			if($val->period > 2){
				$message = $time."現在、".$val->period."限の".$val->room."室が空いてるよ！！\n予約はこちらからしてね！！http://www.kendai-kon.info/new_input.cgi?id=".$val->id."&week_id=".$val->week_id;
			}
		}elseif($time == "14時30分"){
			if($val->period > 3){
				$message = $time."現在、".$val->period."限の".$val->room."室が空いてるよ！！\n予約はこちらからしてね！！http://www.kendai-kon.info/new_input.cgi?id=".$val->id."&week_id=".$val->week_id;
			}
		}elseif($time == "16時10分"){
			if($val->period > 4){
				$message = $time."現在、".$val->period."限の".$val->room."室が空いてるよ！！\n予約はこちらからしてね！！http://www.kendai-kon.info/new_input.cgi?id=".$val->id."&week_id=".$val->week_id;
			}
		}elseif ($time == "17時50分") {
			if($val->period > 5){
				$message = $time."現在、".$val->period."限の".$val->room."室が空いてるよ！！\n予約はこちらからしてね！！http://www.kendai-kon.info/new_input.cgi?id=".$val->id."&week_id=".$val->week_id;
			}
		}else{
			$message = $time."現在、".$val->period."限の".$val->room."室が空いてるよ！！\n予約はこちらからしてね！！http://www.kendai-kon.info/new_input.cgi?id=".$val->id."&week_id=".$val->week_id;
		}
		$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
	}


	// レスポンスを表示する場合は下記コメントアウトを外す
	//header("Content-Type: application/xml");
	//echo $req;
}

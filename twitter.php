<?php

require_once("twitteroauth.php"); //twitteroauth.phpのパス。同一ディレクトリにOAuth.phpも設置する
require_once("Curl.class.php");
//require_once("accsess_key.yml"); //各種key
$Curl = new Curl();

$holiday_checker = json_decode($Curl->GetholidayChecker());
$ban_checker = json_decode($Curl->GetbanChecker());
$next_day_schedule = json_decode($Curl->GetNextDay());

//$key_ary = S

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
//$time = "08時00分";

if($ban_checker->ban_flg == 1){
	$ban = "ごめんね、残念だけど今日は部室の使用禁止なんだ。。。";
	$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$ban));
}else{
	$today = new DateTime();
	$time = $today->format("H時i分");
	//$time = "08時00分";	
	$announce = "部員のみなさん！！".$time."現在の部室の空き状況を教えるね！！";
	//投稿
	$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));

	switch($time){
		case "08時00分":
			$Available_Room = json_decode($Curl->GetAvailableRoom());
			if(empty($holiday_checker)){
				$greeting = "部員のみなさん!!今日休日日程だから気をつけてね!!1限と3限以外開始時刻が違うよ!!";
			}else{
				$greeting = "部員のみなさんおはよう!!今日も一日がんばろうね!!";
			}
			$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$greeting));
			break;
		case "12時10分":
			$Available_Room = json_decode($Curl->GetAvailableRoom_12_10());
			break;
		case "14時30分":
			$Available_Room = json_decode($Curl->GetAvailableRoom_14_30());
			break;
		case "16時10分":
			$Available_Room = json_decode($Curl->GetAvailableRoom_16_10());
			break;
		case "17時50分":
			$Available_Room = json_decode($Curl->GetAvailableRoom_17_50());
			break;
	}
	if(!empty($Available_Room)){
		foreach($Available_Room as $key => $val){
			$message = $time."現在、".$val->period."限の".$val->room."室が空いてるよ！！\n予約はこちらからしてね！！http://www.kendai-kon.info/new_input.cgi?id=".$val->id."&week_id=".$val->week_id;
			$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
		}
	}else{
		$message = "ごめんね、".$time."現在、空いてる部室ないんだ。みんな練習がんばってるね！！";
		$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
	}

}
	

	// レスポンスを表示する場合は下記コメントアウトを外す
	//header("Content-Type: application/xml");
	//echo $req;

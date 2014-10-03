<?php
require_once("twitteroauth.php"); //twitteroauth.phpのパス。同一ディレクトリにOAuth.phpも設置する
require_once("Curl.class.php");
//require_once("spyc.php");
//require_once("access_key.yml"); //各種key
$Curl = new Curl();

$holiday_checker = json_decode($Curl->GetholidayChecker());
$ban_checker = json_decode($Curl->GetbanChecker());
$next_day_schedule = json_decode($Curl->GetNextDay());
$weather = json_decode($Curl->GetWeatherOfShizuoka());

$json = file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR."./access_key.json");
$access_key = json_decode($json); //jsonファイルをPHPオブジェクトに変換

//$key_ary = Spyc::YAMLLoad('access_key.yml');

// Consumer keyの値
$consumer_key = $access_key->consumer_key;
// Consumer secretの値
$consumer_secret = $access_key->consumer_secret;
// Access Tokenの値
$access_token = $access_key->access_token;
// Access Token Secretの値
$access_token_secret = $access_key->access_token_secret;
// OAuthオブジェクト生成
$to = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);

if($ban_checker->ban_flg == 1){
	$ban = "ごめんね、残念だけど今日は部室の使用禁止なんだ(´・ω・`)";
	$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$ban));
}else{
	$today = new DateTime();
	$time = $today->format("H時i分");
	//$time = "08時30分";	
	switch($time){
		case "08時30分":
			$Available_Room = json_decode($Curl->GetAvailableRoom());
			if(empty($holiday_checker)){
				$greeting = "軽音のみなさん!!今日は休日日程だから気をつけてね!!1限と3限以外開始時刻が違うよ!!";
			}else{
				$num = mt_rand(1,5);
				switch($num){
					case 1;
						$greeting = "軽音のみなさんおはよう!!今日も一日がんばろうね!!(oﾟ▽ﾟ)o";
						break;
					case 2;
						$greeting = "軽音のみなさんおはよう!!ライブに向けてファイトだよ!!ヽ(*´∀｀)ﾉ";
						break;
					case 3;
						$greeting = "ふああ。。。おは。。。おはようございます。。。Oo｡(｡p ω-｡)zzz";
						break;
					case 4;
						$greeting = "にっこにっこにー!!";
						break;
					case 5;
						$greeting = "練習は進んでいますか?気を引き締めていきましょう!!(｀・ω・´)";
						break;
				}
			}
			$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$greeting));

			$forecast = $weather->forecasts[0]->telop;
			$temperature_min = $weather->forecasts[0]->temperature->min->celsius;
			$temperature_max = $weather->forecasts[0]->temperature->max->celsius;
			$memsage_1 ="ちなみに今日の天気は".$forecast."\n";
			if(isset($temperature_min)){
				$message_2 = "最低気温は".$temperature_min."℃\n";
			}else{
				$message_2 = "最低気温は発表されていなくて\n";
			}
			if(isset($temperature_max)){
				$message_3 = "最高気温は".$temperature_max."℃だよ!!";
			}else{
				$message_3 = "最高気温は発表されていないよ";
			}
			$message = $memsage_1.$message_2.$message_3;
			$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));

			break;
		case "12時10分":
			$announce = "お昼の時間になりました（●´▽｀●）".$time."現在の部室の空き状況を教えるね！！";
			$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
			$Available_Room = json_decode($Curl->GetAvailableRoom_12_10());
			break;
		case "14時30分":
			$Available_Room = json_decode($Curl->GetAvailableRoom_14_30());
			$announce = "こんにちは軽音のみなさん！！".$time."現在の部室の空き状況を教えるね！！";
			$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
			break;
		case "16時10分":
			$Available_Room = json_decode($Curl->GetAvailableRoom_16_10());
			$announce = "こんにちは軽音のみなさん！！".$time."現在の部室の空き状況を教えるね！！";
			$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
			break;
		case "17時50分":
			$Available_Room = json_decode($Curl->GetAvailableRoom_17_50());
			$announce = "こんばんは軽音のみなさん！！".$time."現在の部室の空き状況を教えるね！！";
			$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
			break;
		case "22時00分";
			$Available_Room = json_decode($Curl->GetNextDay());
			$announce = "こんばんは軽音のみなさん！！明日の部室の空き状況を教えるね！！";
			$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
			break;
	}
	if(!empty($Available_Room)){
		foreach($Available_Room as $key => $val){
			$message = $time."現在、".$val->period."限の".$val->room."室が空いてるよ！！\n予約はこちらからしてね！！http://www.kendai-kon.info/list.cgi?week_id=".$val->week_id;
			$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
			sleep(3);
		}
	}else{
		$message = "ごめんね、".$time."現在、空いてる部室ないんだ。みんな練習がんばってるね！！";
		$req = $to->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
	}
}
//レスポンスを表示する場合は下記コメントアウトを外す
//header("Content-Type: application/xml");
echo $req;
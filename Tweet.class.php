<?php

/* Tweet.class.php
 * Author KazukiHatori
 * Email:moroku0519@gmail.com
 * PHP verion 5.4.30
 */

require_once("twitteroauth.php"); //twitteroauth.phpのパス。同一ディレクトリにOAuth.phpも設置する
require_once('Weather.class.php');

class Tweet extends Weather{

	private $json;
	private $access_key;
	private $consumer_key;
	private $consumer_secret;
	private $access_token;
	private $access_token_secret;
	private $tweet;
	private $req;
	private $time;
	private $announce;
	private $key;
	private $value;
	private $holiday_checker;
	private $num;
	private $message;
	private $weather;
	private $warn;
	private $ban_flg;

	//setter
	public function set_Time($time){ $this->time = $time; }
	public function set_Holiday_Checker($holiday_checker){ $this->holiday_checker = $holiday_checker; }
	public function set_Train($train){ $this->train = $train; }
	//getter
	public function get_Time(){ return $this->time; }
	public function get_Holiday_Checker(){ return $this->holiday_checker; }
	public function get_Train(){ return $this->train; }

	function __construct(){
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
		$this->tweet = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);
	}

	function TweetBan(){
		$announce = "ごめんね、残念だけど部室の使用禁止なんだ(´・ω・`)";
		$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));	
	}

	function WeatherNews($time){
		switch($time){
			case "08時30分":
				$message = "本日の天気予報ヽ(*´∀｀*)ノ";
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
				$weather = $this->MakeWeatherMessageToday();
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$weather));
				$warn = $this->MakeWarnMessage();
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$warn));
				break;
			case "22時30分":
				$message = "明日の天気予報ヽ(*´∀｀*)ノ";
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
				$weather = $this->MakeWeatherMessageNextday();
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$weather));
				break;
		}
		$end = "以上、妹の天気予報でした!";
		$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$end));
	}

	function TweetMorningMessage($holiday_checker){
		if(empty($holiday_checker)){
			$announce = "軽音のみなさん!!今日は休日日程だから気をつけてね!!1限と3限以外開始時刻が違うよ!!";
		}else{
			$num = mt_rand(1,5);
			switch($num){
				case 1;
					$announce = "軽音のみなさんおはよう!!今日も一日がんばろうね!!(oﾟ▽ﾟ)o";
					break;
				case 2;
					$announce = "軽音のみなさんおはよう!!ライブに向けてファイトだよ!!ヽ(*´∀｀)ﾉ";
					break;
				case 3;
					$announce = "ふああ。。。おは。。。おはようございます。。。Oo｡(｡p ω-｡)zzz";
					break;
				case 4;
					$announce = "にっこにっこにー!!";
					break;
				case 5;
					$announce = "練習は進んでいますか?気を引き締めていきましょう!!(｀・ω・´)";
					break;
			}
		}
		$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
	}

	function TweetAvailableRoomToday($time){
		switch ($time) {
			case "08時00分":
				$Available_Room = json_decode($this->GetAvailableRoom());
				break;
			case "12時10分":
				$announce = "お昼の時間になりました（●´▽｀●）".$time."現在の部室の空き状況を教えるね！！";
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
				$Available_Room = json_decode($this->GetAvailableRoom_12_10());
				break;
			case "14時30分":
				$announce = "こんにちは軽音のみなさん！！".$time."現在の部室の空き状況を教えるね！！";
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
				$Available_Room = json_decode($this->GetAvailableRoom_14_30());
				break;
			case "16時10分":
				$announce = "こんにちは軽音のみなさん！！".$time."現在の部室の空き状況を教えるね！！";
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
				$Available_Room = json_decode($this->GetAvailableRoom_16_10());
				break;
			case "17時50分":
				$announce = "こんばんは軽音のみなさん！！".$time."現在の部室の空き状況を教えるね！！";
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
				$Available_Room = json_decode($this->GetAvailableRoom_17_50());
				break;
		}
		if(!empty($Available_Room)){
			foreach($Available_Room as $key => $value){
				$message = $time."現在、".$value->period."限の".$value->room."室が空いてるよ！！\n予約はこちらからしてね！！http://www.kendai-kon.info/list.cgi?week_id=".$value->week_id;
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
				sleep(3);
			}
		}elseif(empty($Available_Room)){
			$message = "ごめんね、".$time."現在、空いてる部室はないんだ。";
			$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
		}
	}

	function TweetAvailableRoomNextDay($time){
		$announce = "こんばんは軽音のみなさん！！明日の部室の空き状況を教えるね！！";
		$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
		$Available_Room = json_decode($this->GetNextDay());
		$ban_flg = json_decode($this->GetbanCheckerNext());
		if($ban_flg->ban_flg == 1){
			$this->TweetBan();
		}elseif(!empty($Available_Room)){
			foreach($Available_Room as $key => $value){
				$message = $time."現在、".$value->period."限の".$value->room."室が空いてるよ！！\n予約はこちらからしてね！！http://www.kendai-kon.info/list.cgi?week_id=".$value->week_id;
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
				sleep(3);
			}
		}elseif(empty($Available_Room)){
			$message = "ごめんね、".$time."現在、空いてる部室はないんだ。";
			$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
		}
	}

	function TweetTrainInfo($train,$time){
		foreach ($train as $key => $value) {
			if($value->name == "東海道本線"){
				$announce = $time."現在、".$value->name."に遅延が発生しています。\n詳しくはhttp://jr-central.co.jp/";
			}
		}
		if(isset($announce)){
			$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
		}
	}

}
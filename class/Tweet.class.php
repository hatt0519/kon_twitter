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
	private $i;
	private $count;
	private $wday;
	private $rt;
	private $sister;

	//setter
	public function set_Time($time){ $this->time = $time; }
	public function set_Holiday_Checker($holiday_checker){ $this->holiday_checker = $holiday_checker; }
	public function set_Train($train){ $this->train = $train; }
	public function set_sister($sister){ $this->sister = $sister; }
	//getter
	public function get_Time(){ return $this->time; }
	public function get_Holiday_Checker(){ return $this->holiday_checker; }
	public function get_Train(){ return $this->train; }
	public function get_sister(){ return $this->sister; }

	function __construct(){
		$json = file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR."../config/access_key.json");
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
		$sister = func_get_arg(0);
		switch ($sister->id) {
			case 1:
				$announce = "ごめんね、残念だけど部室の使用禁止なんだ(´・ω・`)";
				break;
			case 2:
				$announce =  mt_rand() / mt_getrandmax() <= 0.2 ? "ごめんなさい、部室の使用禁止なんです。。。でもこれで私と一緒にいてくれますよね。。。？ねえ、おにいさん。。。" : "おにいさん。。。部室の使用禁止なんです。。。ごめんなさい(´; ω ;｀)";
				break;
			case 3:
				$announce = "ごめんおにいちゃん！！部室が使えないんだ！！(＝ω＝.)\n(*´・∀・)あ!!じゃあさ、じゃあさ、あたしと遊ぼ!!!";
				break;
			case 4:
				$announce = "ごめんなさいおにいさま、部室が使えませんの。。。";
				break;
		}
		$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));	
	}

	function WeatherNews(){
		$time = func_get_arg(0);
		$sister = func_get_arg(1);
		switch($time){
			case "08時30分":
				switch ($sister->id) {
					case 1:
						$message = "本日の天気予報ヽ(*´∀｀*)ノ";
						break;
					case 2:
						$message = "本日の天気予報ですよ( ´艸｀)";
						break;
					case 3:
						$message = "今日の天気だよ！！(*｀･ω･)ゞ";
						break;
					case 4:
						$message = "本日の天気予報ですわ(๑˃́ꇴ˂̀๑)";
						break;
				}
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
				$weather = $this->MakeWeatherMessageToday($sister);
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$weather));
				$warn = $this->MakeWarnMessage($sister);
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$warn));
				break;
			case "22時30分":
				switch ($sister->id) {
					case 1:
						$message = "明日の天気予報ヽ(*´∀｀*)ノ";
						break;
					case 2:
						$message = "明日の天気予報ですよ( ´艸｀)";
						break;
					case 3:
						$message = "明日の天気だよ！！(*｀･ω･)ゞ";
						break;
					case 4:
						$message = "明日の天気予報ですわ(๑˃́ꇴ˂̀๑)";
						break;
				}
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
				$weather = $this->MakeWeatherMessageNextday($sister);
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$weather));
				break;
		}
		switch ($sister->id) {
			case 1:
				$end = "以上、メイの天気予報でした!";
				break;
			case 2:
				$end = mt_rand() / mt_getrandmax() <= 0.2 ? "以上、若菜の天気予報でした。ところでおにいさん、この前相合い傘してた人って。。。誰ですか。。。？" : "以上、若菜の天気予報でした。おにいさん、天気予報はこまめにチェックしなきゃ。。。ですよ？ふふ。";
				break;
			case 3:
				switch($time) {
					case "08時30分":
						$end = "以上、ウタの天気予報でした！ほら！早く起きなよ！！( ｀ ・ ω ・´ )";
						break;
					case "22時30分":
						$end = "以上、ウタの天気予報でした！おにいちゃん、夜更かしはほどほどにね！";
						break;
				}
				break;
			case 4:
				switch($time){
					case "08時30分":
						$end = "以上、リナの天気予報でしたの!!おにいさま、お気を付けていってらっしゃいませ!!";
						break;
					case "22時30分":
						$end = "以上、リナの天気予報でしたの!!";
						break;
				}
				break;
		}
		$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$end));
	}

	function TweetMorningMessage(){
		$holiday_checker = func_get_arg(0);
		$sister = func_get_arg(1);
		if(empty($holiday_checker)){
			switch ($sister->id) {
				case 1:
					$announce = "おにいちゃん!!今日は休日日程だから気をつけてね!!\n2限は10:20から、昼は11:40から開始だよ!!";
					break;				
				case 2:
					$announce = "おにいさん、今日は休日日程だから気をつけてください。\n2限は10:20から、昼は11:40から開始です。あと、休みだからって遅くまで寝てちゃダメですよ〜";
					break;
				case 3:
					$announce = "おにいちゃん!!今日は休日日程だから気をつけなよ!!\n2限は10:20から、昼は11:40から開始なんだからね!!練習終わったら、あたしと遊んでね!!";
					break;
				case 4:
					$announce = "おにいさま!!本日は休日日程ですのでお気をつけてくださいませ\n2限は10:20から、昼は11:40から開始ですわ。";
					break;
			}
		}else{
			$num = mt_rand(1,5);
			switch ($sister->id) {
				case 1:
					switch($num){
						case 1;
							$announce = "おにいちゃんおはよう!!今日も一日がんばろうね!!(oﾟ▽ﾟ)o";
							break;
						case 2;
							$announce = "おにいちゃん、起きてる？ヾ(･∀･`o)";
							break;
						case 3;
							$announce = "ふああ。。。おは。。。おはよう。。。Oo｡(｡p ω-｡)zzz";
							break;
						case 4;
							$announce = "にゃー!!(●ↀωↀ●)✧";
							break;
						case 5;
							$announce = "練習は進んでるかな?気を引き締めていこうね!!(｀・ω・´)";
							break;
					}
					break;
				case 2:
					switch($num){
						case 1;
							$announce = "おにいさんおはようございます!!今日も一日がんばりましょう!!(oﾟ▽ﾟ)o";
							break;
						case 2;
							$announce = "おにいさん、起きてますか。。。？起きないと。。。ふふ、冗談ですよ。";
							break;
						case 3;
							$announce = "おにいさん、おはようございます。部屋に落ちてたこの髪の毛。。。誰のですか。。。？";
							break;
						case 4;
							$announce = "おにいさん、おはようございます。え？最近ずっと視線を感じる？。。。気のせいですよ、きっと。";
							break;
						case 5;
							$announce = "練習は進んでいますか?気を引き締めていきましょう!!(｀・ω・´)";
							break;
					}
					break;
				case 3:
					switch($num){
						case 1;
							$announce = "おにいちゃんおはよう!!今日も一日がんばるよ!!(oﾟ▽ﾟ)o";
							break;
						case 2;
							$announce = "おにいちゃん、起きなきゃダメだよ？";
							break;
						case 3;
							$announce = "おにいちゃん、起きて〜。。。もう!!!起きろーーーー!!!";
							break;
						case 4;
							$announce = "おっはよーーーー!!!";
							break;
						case 5;
							$announce = "練習は進んでる?気を引き締めていかなきゃだね!!(｀・ω・´)";
							break;
					}
					break;
				case 4:
					switch($num){
						case 1;
							$announce = "おにいさまおはようございます。今日も一日がんばりますわよ!!(oﾟ▽ﾟ)o";
							break;
						case 2;
							$announce = "おにいさま、そろそろ起きてくださいですわ。";
							break;
						case 3;
							$announce = "おにいさま、お目覚めのじかんですわよ。。。？";
							break;
						case 4;
							$announce = "お・に・い・さ・ま";
							break;
						case 5;
							$announce = "今日も練習がんばってください、ですわ(｀・ω・´)";
							break;
					}
					break;
			}
		}
		$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
	}

	function TweetAvailableRoomToday(){
		$time = func_get_arg(0);
		$holiday_checker = func_get_arg(1);
		$sister = func_get_arg(2);
		switch ($time) {
			case "08時00分":
				$Available_Room = json_decode($this->GetAvailableRoom());
				break;
			case "12時10分":
				switch ($sister->id) {
					case 1:
						$announce = !empty($holiday_checker) ? "お昼の時間になったよ（●´▽｀●）".$time."現在の部室の空き状況を教えるね！！" : "おにいちゃん、今日は4限が14:20から、5限が15:40から開始だから気をつけてね!!";
						break;
					case 2:
						$announce = !empty($holiday_checker) ? "お昼の時間になりました（●´▽｀●）".$time."現在の部室の空き状況です！！" : "おにいさん、今日は4限が14:20から、5限が15:40から開始なので気をつけてくださいね!!";
						break;
					case 3:
						$announce = !empty($holiday_checker) ? "お昼の時間になったね（●´▽｀●）".$time."現在の部室の空き状況だよ！！" : "おにいちゃん、今日は4限が14:20から、5限が15:40から開始だから気をつけなきゃだね!!";
						break;
					case 4:
						$announce = !empty($holiday_checker) ? "お昼の時間になりましたわ（●´▽｀●）".$time."現在の部室の空き状況ですわ！！" : "おにいさま、本日は4限が14:20から、5限が15:40から開始ですのでお気をつけくださいませ!!";
						break;
				}
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
				$Available_Room = json_decode($this->GetAvailableRoom_12_10());
				break;
			default:
				switch ($sister->id) {
					case 1:
						$announce = !empty($holiday_checker) ? "おにいちゃん！！".$time."現在の部室の空き状況を教えるね！！" : "おにいちゃん、今日は5限が15:40から開始だから気をつけてね!!";
						break;					
					case 2:
						$announce = !empty($holiday_checker) ? "おにいさん、".$time."現在の部室の空き状況です！！" : "おにいさん、今日は5限が15:40から開始なので気をつけてくださいね!!";
						break;
					case 3:
						$announce = !empty($holiday_checker) ? "おにいちゃん、".$time."現在の部室の空き状況だよ！！" : "おにいちゃん、今日は5限が15:40から開始なので気をつけなきゃだね!!";
						break;
					case 4:
						$announce = !empty($holiday_checker) ? "おにいさま、".$time."現在の部室の空き状況ですわ！！" : "おにいさま、本日は5限が15:40から開始ですのでお気をつけくださいませ!!";
						break;
				}
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
				switch ($time) {
					case "14時30分":
						$Available_Room = json_decode($this->GetAvailableRoom_14_30());
						break;
					case "16時10分":
						$Available_Room = json_decode($this->GetAvailableRoom_16_10());
						break;
					case "17時50分":
						$Available_Room = json_decode($this->GetAvailableRoom_17_50());
						break;
				}
		}
		if(!empty($Available_Room)){
			foreach($Available_Room as $key => $value){
				switch ($sister->id) {
					case 1:
						$message = $time."現在、".$value->period."限の".$value->room."室が空いてるよ!!\n予約はこちらからしてね!!http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
						break;					
					case 2:
						$message = $time."現在、".$value->period."限の".$value->room."室が空いてます。\n予約はこちらからお願いしますね。http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
						break;
					case 3:
						$message = $time."現在、".$value->period."限の".$value->room."室が空いてるんだ!!\n予約はこっちだよ!!http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
						break;
					case 4:
						$message = $time."現在、".$value->period."限の".$value->room."室が空いていますわ。\nご予約はこちらですわ。http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
						break;
				}
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
				sleep(3);
			}
		}elseif(empty($Available_Room)){
			switch ($sister->id) {
				case 1:
					$message = "ごめんなさい、".$time."現在、空いてる部室はないんだ。";
					break;
				case 2:
					$message = "ごめんなさい、".$time."現在、空いてる部室はありません。";
					break;
				case 3:
					$message = "ごめんね、".$time."現在、空いてる部室はないんだ。";
					break;
				case 4:
					$message = "ごめんなさいですわ、".$time."現在、空いてる部室はありませんの。";
					break;
			}
			$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
		}
	}

	function TweetAvailableRoomNextDay(){
		$time = func_get_arg(0);
		$holiday_checker = func_get_arg(1);
		$sister = func_get_arg(2);
		switch ($sister->id) {
			case 1:
				$announce = !empty($holiday_checker) ? "おにいちゃん!!明日の部室の空き状況を教えるね!!" : "おにいちゃん!!明日は休日日程だから気をつけてね!!\n2限は10:20から\n昼は11:40から\n4限は14:20から\n5限は15:40から開始だよ!!";
				break;			
			case 2:
				$announce = !empty($holiday_checker) ? "おにいさん、明日の部室の空き状況です。" : "おにいさん、明日は休日日程ですよ〜。\n2限は10:20から\n昼は11:40から\n4限は14:20から\n5限は15:40から開始ですからね!!";				
				break;
			case 3:
				$announce = !empty($holiday_checker) ? "おにいちゃん、明日の部室の空き状況だよ!!" : "おにいちゃん、明日は休日日程だからね!!\n2限は10:20から\n昼は11:40から\n4限は14:20から\n5限は15:40から開始だからね!!";				
				break;
			case 4:
				$announce = !empty($holiday_checker) ? "おにいさま、明日の部室の空き状況ですわ。" : "おにいさま、明日は休日日程ですわ。\n2限は10:20から\n昼は11:40から\n4限は14:20から\n5限は15:40から開始ですわ。";				
				break;
		}
		$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
		$Available_Room = json_decode($this->GetNextDay());
		$ban_flg = json_decode($this->GetbanCheckerNext());
		if($ban_flg->ban_flg == 1){
			$this->TweetBan($sister);
		}elseif(!empty($Available_Room)){
			foreach($Available_Room as $key => $value){
				switch ($sister->id) {
					case 1:
						$message = $time."現在、".$value->period."限の".$value->room."室が空いてるよ!!\n予約はこちらからしてね!!http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
						break;					
					case 2:
						$message = $time."現在、".$value->period."限の".$value->room."室が空いてます。\n予約はこちらからお願いしますね。http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
						break;
					case 3:
						$message = $time."現在、".$value->period."限の".$value->room."室が空いてるんだ!!\n予約はこっちだよ!!http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
						break;
					case 4:
						$message = $time."現在、".$value->period."限の".$value->room."室が空いていますわ。\nご予約はこちらですわ。http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
						break;
				}
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
				sleep(3);
			}
		}elseif(empty($Available_Room)){
			switch ($sister->id) {
				case 1:
					$message = "ごめんなさい、".$time."現在、空いてる部室はないんだ。";
					break;
				case 2:
					$message = "ごめんなさい、".$time."現在、空いてる部室はありません。";
					break;
				case 3:
					$message = "ごめんね、".$time."現在、空いてる部室はないんだ。";
					break;
				case 4:
					$message = "ごめんなさいですわ、".$time."現在、空いてる部室はありませんの。";
					break;
			}
			$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
		}
	}

	function TweetTrainInfo(){
		$train = func_get_arg(0);
		$time = func_get_arg(1);
		$sister = func_get_arg(2);
		foreach ($train as $key => $value) {
			if(preg_match("/東海道本線/", $value->name)){
				switch ($sister->id) {
					case 1:
						$announce = $time."現在、".$value->name."に遅延が発生しているみたい。\n詳しくはhttp://jr-central.co.jp/";
						break;					
					case 2:
						$announce = $time."現在、".$value->name."に遅延が発生しているみたいです。\n詳しくはhttp://jr-central.co.jp/";
						break;
					case 3:
						$announce = $time."現在、".$value->name."に遅延が発生しているみたいだね。\n詳しくはhttp://jr-central.co.jp/";
						break;
					case 4:
						$announce = $time."現在、".$value->name."に遅延が発生しているみたいですわ。\n詳しくはhttp://jr-central.co.jp/";
						break;
				}
			}
		}
		if(isset($announce)) $req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
	}
	function ChangeProfile(){
		$sister = func_get_arg(0);
		switch($sister->id){
			case 1:
				$req = $this->tweet->oAuthRequestImage("https://api.twitter.com/1.1/account/update_profile_image.json",array('image'=>'./images/kon_sister.png'));
				sleep(10);			
				$message = "おにいちゃん、メイだよ。今日は私がサポートするね!!";
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
				break;
			case 2:
				$req = $this->tweet->oAuthRequestImage("https://api.twitter.com/1.1/account/update_profile_image.json",array('image'=>'./images/kon_sister_2.jpg'));
				sleep(10);
				$message = "おにいさん、若菜です。今日は私がお手伝いしますね!!";
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
				break;
			case 3:
				$req = $this->tweet->oAuthRequestImage("https://api.twitter.com/1.1/account/update_profile_image.json",array('image'=>'./images/kon_sister_3.jpg'));
				sleep(10);
				$message = "おにいちゃん、ヤッホー!!うただよ!!今日は私がお手伝いしちゃうよ!!";
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
				break;
			case 4:
				$req = $this->tweet->oAuthRequestImage("https://api.twitter.com/1.1/account/update_profile_image.json",array('image'=>'./images/kon_sister_4.jpg'));
				sleep(10);
				$message = "ごきげんようおにいさま!!本日は私、リナが担当いたします。";
				$req = $this->tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
				break;
		}
	}

}
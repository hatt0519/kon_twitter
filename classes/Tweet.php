<?php

/* Tweet.php
 * 各種つぶやきを行うクラス
 * Author KazukiHatori
 * Email:moroku0519@gmail.com
 * PHP verion 5.4.30
 */

require_once("twitteroauth.php"); //twitteroauth.phpのパス。同一ディレクトリにOAuth.phpも設置する
require_once("Data.php");
require_once("Weather.php");

class Tweet{

    //OAuthオブジェクトを格納するプロパティ
    private static $tweet;

    //APIのURL
    private static $MORNING = 'http://conoha.moroku0519.xyz:4567/available_room.json';
    private static $NOON = 'http://conoha.moroku0519.xyz:4567/available_room_12_10.json';
    private static $THIRD = 'http://conoha.moroku0519.xyz:4567/available_room_14_30.json';
    private static $FORTH = 'http://conoha.moroku0519.xyz:4567/available_room_16_10.json';
    private static $FIFTH = 'http://conoha.moroku0519.xyz:4567/available_room_17_50.json';
    private static $NEXT_DAY = 'http://conoha.moroku0519.xyz:4567/next_day_schedule.json';
    private static $HOLIDAY = 'http://conoha.moroku0519.xyz:4567/holiday_checker.json';
    private static $HOLIDAY_NEXT = 'http://conoha.moroku0519.xyz:4567/holiday_checker_nextday.json';
    private static $BAN_NEXT = 'http://conoha.moroku0519.xyz:4567/ban_checker_next_day.json';
    private static $TRAIN = 'https://rti-giken.jp/fhc/api/train_tetsudo/delay.json';
    private static $WEATHER = 'http://www.drk7.jp/weather/xml/22.xml';

    public function __construct()
    {
        $json = file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR."../config/access_key.json");
        // config取得
        $access_key = json_decode($json); //jsonファイルをPHPオブジェクトに変換
        // Consumer keyの値
        $consumer_key = $access_key->consumer_key;
        // Consumer secretの値
        $consumer_secret = $access_key->consumer_secret;
        // Access Tokenの値
        $access_token = $access_key->access_token;
        // Access Token Secretの値
        $access_token_secret = $access_key->access_token_secret;
        // OAuthオブジェクト生成
        self::$tweet = new TwitterOAuth($consumer_key,$consumer_secret,$access_token,$access_token_secret);
    }

    public function TweetBan($sister) //練習禁止日のつぶやき
    {
        $announce = array(
                       "ごめんね、残念だけど部室の使用禁止なんだ(´・ω・`)",
                        array(
                            "ごめんなさい、部室の使用禁止なんです。。。でもこれで私と一緒にいてくれますよね。。。？ねえ、おにいさん。。。",
                            "おにいさん。。。部室の使用禁止なんです。。。ごめんなさい(´; ω ;｀)"
                            ),
                        "ごめんおにいちゃん！！部室が使えないんだ！！(＝ω＝.)\n(*´・∀・)あ!!じゃあさ、じゃあさ、あたしと遊ぼ!!!",
                        "ごめんなさいおにいさま、部室が使えませんの。。。"
                    );
        if(!is_array($announce[$sister])){
            $sister_announce = $announce[$sister];
        }else{
            $sister_announce = mt_rand() / mt_getrandmax() <= 0.2 ? $announce[$sister][0] : $announce[$sister][1];
            //若菜ちゃんのヤンデレギミック用（およそ20%の確率）
        }
            self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$sister_announce));	
    }

    public function WeatherNews($sister, $time) //天気予報
    {
        $message = array("08時30分" => array(
                                            "本日の天気予報ヽ(*´∀｀*)ノ",
                                            "本日の天気予報ですよ( ´艸｀)",
                                            "今日の天気だよ！！(*｀･ω･)ゞ",
                                            "本日の天気予報ですわ(๑˃́ꇴ˂̀๑)"
                                        ),
                        "22時30分" => array(
                                           "明日の天気予報ヽ(*´∀｀*)ノ",
                                           "明日の天気予報ですよ( ´艸｀)",
                                           "明日の天気だよ！！(*｀･ω･)ゞ",
                                           "明日の天気予報ですわ(๑˃́ꇴ˂̀๑)"
                                        )
                    ); //セリフの拡張性を考えて時間毎に配列の要素としてセリフを格納
        self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message[$time][$sister]));

        $date = ($time == "08時30分") ? "今日" : "明日";
        $weather = Weather::MakeWeatherMessage($sister, $date); //天気予報メッセージの取得
        self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$weather));

        $warn = Weather::MakeWarnMessage($sister); //警報・注意報メッセージの取得
        self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$warn));

        $end = array("08時30分" => array(
                                        "以上、メイの天気予報でした!",
                                        array(
                                            "以上、若菜の天気予報でした。ところでおにいさん、この前相合い傘してた人って。。。誰ですか。。。？",
                                            "以上、若菜の天気予報でした。おにいさん、天気予報はこまめにチェックしなきゃ。。。ですよ？ふふ。"
                                        ),
                                        "以上、ウタの天気予報でした！ほら！早く起きなよ！！( ｀ ・ ω ・´ )",
                                        "以上、リナの天気予報でしたの!!おにいさま、お気を付けていってらっしゃいませ!!"
                                    ),
                    "22時30分" => array(
                                    "以上、メイの天気予報でした!明日もいい1日でありますように",
                                    "以上、若菜の天気予報でした。おにいさん、折りたたみ傘はいつも持ち歩くと便利ですよ。",
                                    "以上、ウタの天気予報でした！おにいちゃん、夜更かしはほどほどにね！",
                                    "以上、リナの天気予報でしたの!!"
                                    )
                    );
        if(!is_array($end[$time][$sister])){
            $sister_end = $end[$time][$sister];
        }else{
            $sister_end = mt_rand() / mt_getrandmax() <= 0.2 ? $end[$time][$sister][0] : $end[$time][$sister][1];
            //若菜ちゃんのヤンデレギミック用（およそ20%の確率）
        }
        self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$sister_end));
    }

    public function TweetMorningMessage($sister) //8時のあいさつ
    {
        $holiday_checker = json_decode(Data::AccessAPI(self::$HOLIDAY)); //休日チェック
        if(empty($holiday_checker)){
            $announce = array(
                            "おにいちゃん!!今日は休日日程だから気をつけてね!!\n2限は10:20から、昼は11:40から開始だよ!!",
                            "おにいさん、今日は休日日程だから気をつけてください。\n2限は10:20から、昼は11:40から開始です。あと、休みだからって遅くまで寝てちゃダメですよ〜",
                            "おにいちゃん!!今日は休日日程だから気をつけなよ!!\n2限は10:20から、昼は11:40から開始なんだからね!!練習終わったら、あたしと遊んでね!!",
                            "おにいさま!!本日は休日日程ですのでお気をつけてくださいませ\n2限は10:20から、昼は11:40から開始ですわ。"
                        );
            self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce[$sister]));
        }else{
            $num = mt_rand(0,4); // 以下、セリフ一人につき5つ
            $announce = array(
                        array(
                                "おにいちゃんおはよう!!今日も一日がんばろうね!!(oﾟ▽ﾟ)o",
                                "おにいちゃん、起きてる？ヾ(･∀･`o)",
                                "ふああ。。。おは。。。おはよう。。。Oo｡(｡p ω-｡)zzz",
                                "にゃー!!(●ↀωↀ●)✧",
                                "練習は進んでるかな?気を引き締めていこうね!!(｀・ω・´)"
                                ),
                            array(
                                "おにいさんおはようございます!!今日も一日がんばりましょう!!(oﾟ▽ﾟ)o",
                                "おにいさん、起きてますか。。。？起きないと。。。ふふ、冗談ですよ。",
                                "おにいさん、おはようございます。部屋に落ちてたこの髪の毛。。。誰のですか。。。？",
                                "おにいさん、おはようございます。え？最近ずっと視線を感じる？。。。気のせいですよ、きっと。",
                                "練習は進んでいますか?気を引き締めていきましょう!!(｀・ω・´)"
                                ),
                            array(
                                "おにいちゃんおはよう!!今日も一日がんばるよ!!(oﾟ▽ﾟ)o",
                                "おにいちゃん、起きなきゃダメだよ？",
                                "おにいちゃん、起きて〜。。。もう!!!起きろーーーー!!!",
                                "おっはよーーーー!!!",
                                "練習は進んでる?気を引き締めていかなきゃだね!!(｀・ω・´)"
                                ),
                            array(
                                "おにいさまおはようございます。今日も一日がんばりますわよ!!(oﾟ▽ﾟ)o",
                                "おにいさま、そろそろ起きてくださいですわ。",
                                "おにいさま、お目覚めのじかんですわよ。。。？",
                                "お・に・い・さ・ま",
                                "今日も練習がんばってください、ですわ(｀・ω・´)"
                                )
                        );
            self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce[$sister][$num]));
            //$sister => 妹の種別,$num => セリフの種別
        }
    }

    public function TweetAvailableRoomToday($sister, $time) //その日の部室の空き状況（メイン機能）
    {
        $holiday_checker = json_decode(Data::AccessAPI(self::$HOLIDAY)); //休日のチェック
        $announce = array(
                        array(
                            "現在の部室の空き状況を教えるね！！",
                            "おにいちゃん、今日は4限が14:20から、5限が15:40から開始だから気をつけてね!!"
                            ),
                        array(
                            "現在の部室の空き状況です！！",
                            "おにいさん、今日は4限が14:20から、5限が15:40から開始なので気をつけてくださいね!!"),
                        array(
                            "現在の部室の空き状況だよ！！",
                            "おにいちゃん、今日は4限が14:20から、5限が15:40から開始だから気をつけなきゃだね!!"),
                        array(
                            "現在の部室の空き状況ですわ！！",
                            "おにいさま、本日は4限が14:20から、5限が15:40から開始ですのでお気をつけくださいませ!!")
                        ); //共通のつぶやき
        switch ($time) {
            //時間毎にアクセスするAPIを分別
            //休日か否かでセリフもチェンジ
            case "08時00分":
                $Available_Room = json_decode(Data::AccessAPI(self::$MORNING));
                break;
            case "12時10分":
                if(!empty($holiday_checker)){
                   switch($sister){
                        case 0:
                            $sister_announce = "お昼の時間になったよ（●´▽｀●）".$time.$announce[0][0];
                            break;
                        case 1:
                            $sister_announce = "お昼の時間になりました（●´▽｀●）".$time.$announce[1][0];
                            break;
                        case 2:
                            $sister_announce = "お昼の時間になったね（●´▽｀●）".$time.$announce[2][0];
                            break;
                        case 3:
                            $sister_announce = "お昼の時間になりましたわ（●´▽｀●）".$time.$announce[3][0];
                            break;
                    }
                }else{
                    $sister_announce = $announce[$sister][1];
                }
                self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$sister_announce));
                $Available_Room = json_decode(Data::AccessAPI(self::$NOON));
                break;
            default:
                switch($sister){
                    case 0:
                        $sister_announce = $time.$announce[0][0];
                        break;
                    case 1:
                        $sister_announce = $time.$announce[1][0];
                        break;
                    case 2:
                        $sister_announce = $time.$announce[2][0];
                        break;
                    case 3:
                        $sister_announce = $time.$announce[3][0];
                        break;
                }
                self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$sister_announce));
                switch ($time) {
                    case "14時30分":
                        $Available_Room = json_decode(Data::AccessAPI(self::$THIRD));
                        break;
                    case "16時10分":
                        $Available_Room = json_decode(Data::AccessAPI(self::$FORTH));
                        break;
                    case "17時50分":
                        $Available_Room = json_decode(Data::AccessAPI(self::$FIFTH));
                        break;
                }
        }
        if(!empty($Available_Room)){ //部室が空いていたとき
            foreach($Available_Room as $value){
                switch ($sister) {
                    case 0:
                        $message = $time."現在、".$value->period."限の".$value->room."室が空いてるよ!!\n予約はこちらからしてね!!http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
                        break;
                    case 1:
                        $message = $time."現在、".$value->period."限の".$value->room."室が空いてます。\n予約はこちらからお願いしますね。http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
                        break;
                    case 2:
                        $message = $time."現在、".$value->period."限の".$value->room."室が空いてるんだ!!\n予約はこっちだよ!!http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
                        break;
                    case 3:
                        $message = $time."現在、".$value->period."限の".$value->room."室が空いていますわ。\nご予約はこちらですわ。http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
                        break;
                }
                self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
                sleep(3);
            }
        }else{ //部室に空きがなかったとき
            switch ($sister) {
                case 0:
                    $message = "ごめんなさい、".$time."現在、空いてる部室はないんだ。"; 
                    break;
                case 1:
                    $message = "ごめんなさい、".$time."現在、空いてる部室はありません。";
                    break;
                case 2:
                    $message = "ごめんね、".$time."現在、空いてる部室はないんだ。";
                    break;
                case 3:
                    $message = "ごめんなさいですわ、".$time."現在、空いてる部室はありませんの。";
                    break;
            }
            self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
        }
    }

    public function TweetAvailableRoomNextDay($sister, $time) //次の日の部室の空き状況
    {
        $announce = array(
                        array(
                            "おにいちゃん!!明日の部室の空き状況を教えるね!!",
                            "おにいちゃん!!明日は休日日程だから気をつけてね!!\n2限は10:20から\n昼は11:40から\n4限は14:20から\n5限は15:40から開始だよ!!"
                            ),
                            array(
                                "おにいさん、明日の部室の空き状況です。",
                                "おにいさん、明日は休日日程ですよ〜。\n2限は10:20から\n昼は11:40から\n4限は14:20から\n5限は15:40から開始ですからね!!"
                                ),
                            array(
                                "おにいちゃん、明日の部室の空き状況だよ!!",
                                "おにいちゃん、明日は休日日程だからね!!\n2限は10:20から\n昼は11:40から\n4限は14:20から\n5限は15:40から開始だからね!!"
                                ),
                            array(
                                "おにいさま、明日の部室の空き状況ですわ。",
                                "おにいさま、明日は休日日程ですわ。\n2限は10:20から\n昼は11:40から\n4限は14:20から\n5限は15:40から開始ですわ。"
                                )
                    ); //共通のつぶやき
        $holiday_checker = json_decode(Data::AccessAPI(self::$HOLIDAY_NEXT)); //休日チェック
        $holiday = !empty($holiday_checker) ? 0 : 1;

        $sister_announce = $announce[$sister][$holiday];

        self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$sister_announce));

        $ban_flg = json_decode(Data::AccessAPI(self::$BAN_NEXT)); //練習禁止日チェック
        $Available_Room = json_decode(Data::AccessAPI(self::$NEXT_DAY));
        if($ban_flg->ban_flg == 1){
            $this->TweetBan($sister); //禁止ならば禁止である旨をつぶやく
        }elseif(!empty($Available_Room)){ //禁止でなく、部室に空きがあるとき
            foreach($Available_Room as $value){
                switch ($sister) {
                    case 0:
                        $message = $time."現在、".$value->period."限の".$value->room."室が空いてるよ!!\n予約はこちらからしてね!!http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
                        break;
                   case 1:
                        $message = $time."現在、".$value->period."限の".$value->room."室が空いてます。\n予約はこちらからお願いしますね。http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
                        break;
                    case 2:
                        $message = $time."現在、".$value->period."限の".$value->room."室が空いてるんだ!!\n予約はこっちだよ!!http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
                        break;
                    case 3:
                        $message = $time."現在、".$value->period."限の".$value->room."室が空いていますわ。\nご予約はこちらですわ。http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
                        break;
                }
                self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
                sleep(3);
            }
        }else{ //部室に空きがないとき
            switch ($sister) {
                case 0:
                    $message = "ごめんなさい、".$time."現在、空いてる部室はないんだ。";
                    break;
                case 1:
                    $message = "ごめんなさい、".$time."現在、空いてる部室はありません。";
                    break;
                case 2:
                    $message = "ごめんね、".$time."現在、空いてる部室はないんだ。";
                    break;
                case 3:
                    $message = "ごめんなさいですわ、".$time."現在、空いてる部室はありませんの。";
                    break;
            }
            self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
        }
    }

    public function TweetTrainInfo($sister) //電車の運行状況をつぶやく
    {
        $train = json_decode(Data::AccessAPI(self::$TRAIN));
        foreach ($train as $value) {
            if(preg_match("/東海道本線/", $value->name)){
                switch ($sister) {
                    case 0:
                        $announce = $time."現在、".$value->name."に遅延が発生しているみたい。\n詳しくはhttp://jr-central.co.jp/";
                        break;
                    case 1:
                        $announce = $time."現在、".$value->name."に遅延が発生しているみたいです。\n詳しくはhttp://jr-central.co.jp/";
                        break;
                    case 2:
                        $announce = $time."現在、".$value->name."に遅延が発生しているみたいだね。\n詳しくはhttp://jr-central.co.jp/";
                        break;
                    case 3:
                        $announce = $time."現在、".$value->name."に遅延が発生しているみたいですわ。\n詳しくはhttp://jr-central.co.jp/";
                        break;
                }
            }
         }
        if(isset($announce)) //特に遅れや運転見合わせがなければスルー
            self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$announce));
    }
    public function ChangeProfile($sister) //妹のプロフィール画像切り替え
    {
        switch($sister){
            case 0:
                $image = './images/kon_sister.png';	
                $message = "おにいちゃん、メイだよ。今日は私がサポートするね!!";
                break;
            case 1:
                $image = './images/kon_sister_2.jpg';
                $message = "おにいさん、若菜です。今日は私がお手伝いしますね!!";
                break;
            case 2:
                $image = './images/kon_sister_3.jpg';
                $message = "おにいちゃん、ヤッホー!!うただよ!!今日は私がお手伝いしちゃうよ!!";
                break;
            case 3:
                $image = './images/kon_sister_4.jpg';
                $message = "ごきげんようおにいさま!!本日は私、リナが担当いたします。";
                break;
        }
        self::$tweet->oAuthRequestImage("https://api.twitter.com/1.1/account/update_profile_image.json",array('image'=>$image));
        sleep(10);
        self::$tweet->OAuthRequest("https://api.twitter.com/1.1/statuses/update.json","POST",array("status"=>$message));
    }
}
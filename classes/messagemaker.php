<?php

namespace Kon;

class MessageMaker extends Api
{
    private $sister;
    private $is_holiday;
    private $is_ban;

    function __construct($sister, $is_holiday, $is_ban)
    {
        $this->sister = $sister;
        $this->is_holiday = $is_holiday;
        $this->is_ban = $is_ban;
    }

    public function default_morning()
    {
        if($this->is_holiday)
        {
            $announce = array(
                            "おにいちゃん!!今日は休日日程だから気をつけてね!!\n2限は10:20から、昼は11:40から開始だよ!!",
                            "おにいさん、今日は休日日程だから気をつけてください。\n2限は10:20から、昼は11:40から開始です。あと、休みだからって遅くまで寝てちゃダメですよ〜",
                            "おにいちゃん!!今日は休日日程だから気をつけなよ!!\n2限は10:20から、昼は11:40から開始なんだからね!!練習終わったら、あたしと遊んでね!!",
                            "おにいさま!!本日は休日日程ですのでお気をつけてくださいませ\n2限は10:20から、昼は11:40から開始ですわ。"
                        );
            return $announce[$this->sister];
        }
        else
        {
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
            return $announce[$this->sister][$num];
            //$sister => 妹の種別,$num => セリフの種別
        }

    }

    public function default_noon()
    {
        $message = array("お昼の時間になったよ（●´▽｀●）",
                         "お昼の時間になりました（●´▽｀●）",
                         "お昼の時間になったね（●´▽｀●）",
                         "お昼の時間になりましたわ（●´▽｀●）");
        return $message[$this->sister];
    }

    public function default_midnight()
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
        $message = $this->is_holiday ? $announce[$this->sister][1] : $announce[$this->sister][0];
        return $message;
    }

    public function default_other($time)
    {
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
        $message = $this->is_holiday ? $announce[$this->sister][1] : $time.$announce[$this->sister][0];
        return $message;
    }

    public function ban()
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
        if(!is_array($announce[$this->sister])){
            $sister_announce = $announce[$this->sister];
        }else{
            $sister_announce = mt_rand() / mt_getrandmax() <= 0.2 ? $announce[$this->sister][0] : $announce[$sister][1];
            //若菜ちゃんのヤンデレギミック用（およそ20%の確率）
        }
        return $sister_announce;
    }

    public function weatherNews($time, $month, $day, $weather_uri, $warning_uri)
    {
        $message = array("08時30分" =>
                            array(
                                array("本日の天気予報ヽ(*´∀｀*)ノ",
                                      "本日の天気予報ですよ( ´艸｀)",
                                      "今日の天気だよ！！(*｀･ω･)ゞ",
                                      "本日の天気予報ですわ(๑˃́ꇴ˂̀๑)"),
                                array("以上、メイの天気予報でした!",
                                      array("以上、若菜の天気予報でした。ところでおにいさん、この前相合い傘してた人って。。。誰ですか。。。？",
                                            "以上、若菜の天気予報でした。おにいさん、天気予報はこまめにチェックしなきゃ。。。ですよ？ふふ。"),
                                      "以上、ウタの天気予報でした！ほら！早く起きなよ！！( ｀ ・ ω ・´ )",
                                      "以上、リナの天気予報でしたの!!おにいさま、お気を付けていってらっしゃいませ!!")
                            ),
                        "22時30分" =>
                            array(
                                array("明日の天気予報ヽ(*´∀｀*)ノ",
                                      "明日の天気予報ですよ( ´艸｀)",
                                      "明日の天気だよ！！(*｀･ω･)ゞ",
                                      "明日の天気予報ですわ(๑˃́ꇴ˂̀๑)"),
                                array("以上、メイの天気予報でした!明日もいい1日でありますように",
                                      array("以上、若菜の天気予報でした。今夜はおにいさんが寝ているところ、ずっと見ていてあげますからね。。。",
                                            "以上、若菜の天気予報でした。おにいさん、折りたたみ傘はいつも持ち歩くと便利ですよ。"),
                                      "以上、ウタの天気予報でした！おにいちゃん、夜更かしはほどほどにね！",
                                      "以上、リナの天気予報でしたの!!")
                            )
                    );
        $begin_message = $message[$time][0];
        $weather = $this->weather($month, $day, $weather_uri);
        $warning = $this->warning($warning_uri);
        if($this->sister == 1)
        {
            $end_message = mt_rand() / mt_getrandmax() <= 0.2 ? $message[$time][1][1][0] : $message[$time][1][1][1];
        }
        else
        {
            $end_message = $message[$time][1][$this->sister];
        }
        $messages = array($begin_message, $weather, $warning, $end_message);

    }

    public function weather($month, $day, $uri) //天気予報のメッセージ作成
    {
        $api_return = simplexml_load_string(self::AccessAPI($uri));
        $weather = $month."月".$day."日"."の県大周辺の天気は".$api_return->pref->area[0]->info[0]->weather."\n";
        $temperature_min = "最高気温は".$api_return->pref->area[0]->info[0]->temperature->range[0]."℃\n";
        $temperature_max = "最低気温は".$api_return->pref->area[0]->info[0]->temperature->range[1]."℃\n";
        $rainfallchance = "降水確率\n";
        $rainfallchance_1 = "06-12時は".$api_return->pref->area[0]->info[0]->rainfallchance->period[1]."%\n";
        $rainfallchance_2 = "12-18時は".$api_return->pref->area[0]->info[0]->rainfallchance->period[2]."%\n";
        $rainfallchance_3 = "18-24時は".$api_return->pref->area[0]->info[0]->rainfallchance->period[3];
        switch ($this->sister) {
            case 0:
                $rainfallchance_3 .= "%です\n";
                break;
            case 1:
                $rainfallchance_3 .= "%ですよ！！ふふ\n";
                break;
            case 2:
                $rainfallchance_3 .= "%だよ！！\n";
                break;
            case 3:
                $rainfallchance_3 .= "%ですわ！！\n";
                break;
        }
        $announce = $weather.$temperature_max.$temperature_min.$rainfallchance.$rainfallchance_1.$rainfallchance_2.$rainfallchance_3;
        return $announce;
    }

    public function warning($uri)
    {
        $warning = simplexml_load_string(self::AccessAPI($uri));
        $message = $warning->channel->item[1]->description;
        if(preg_match('/発表されています/', $warning->channel->item[1]->description)){
            switch ($this->sister) {
                case 0:
                    $message .= "\nみなさん気をつけてください。";
                    break;
                case 1:
                    $message .= "\nおにいさん、気をつけてくださいね。";
                    break;
                case 2:
                    $message .= "\nおにいちゃん、気をつけてね。";
                    break;
                case 3:
                    $message .= "\nおにいさま、お気をつけて。";
                    break;
            }
        }
        return $message;
    }

    public function available_room($time, $uri)
    {
        $available_room = json_decode(self::AccessAPI($uri));
        do
        {
            if($this->is_ban)
            {
                $messages[] = $this->ban();
                break;
            }
            if(empty($available_room))
            {
                $messages[] = $this->no_available_room($time);
                break;
            }
            foreach($available_room as $value)
            {
                switch ($this->sister) {
                    case 0:
                        $messages[] = $time."現在、".$value->period."限の".$value->room."室が空いてるよ!!\n予約はこちらからしてね!!http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
                        break;
                    case 1:
                        $messages[] = $time."現在、".$value->period."限の".$value->room."室が空いてます。\n予約はこちらからお願いしますね。http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
                        break;
                    case 2:
                        $messages[] = $time."現在、".$value->period."限の".$value->room."室が空いてるんだ!!\n予約はこっちだよ!!http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
                        break;
                    case 3:
                        $messages[] = $time."現在、".$value->period."限の".$value->room."室が空いていますわ。\nご予約はこちらですわ。http://www.kendai-kon.info/new_input.cgi?id=".$value->id;
                        break;
                }
            }
        }
        while(false);
        return $messages;
    }

    public function no_available_room($time)
    {
        switch ($this->sister)
        {
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
        return $message;
    }

    public function trainInfo($uri)
    {
        $train = json_decode(self::AccessAPI($uri));
        $message = '';
        foreach ($train as $value) {
            if(preg_match("/東海道本線/", $value->name)){
                switch ($sister) {
                    case 0:
                        $message = $time."現在、".$value->name."に遅延が発生しているみたい。\n詳しくはhttp://jr-central.co.jp/";
                        break;
                    case 1:
                        $message = $time."現在、".$value->name."に遅延が発生しているみたいです。\n詳しくはhttp://jr-central.co.jp/";
                        break;
                    case 2:
                        $message = $time."現在、".$value->name."に遅延が発生しているみたいだね。\n詳しくはhttp://jr-central.co.jp/";
                        break;
                    case 3:
                        $message = $time."現在、".$value->name."に遅延が発生しているみたいですわ。\n詳しくはhttp://jr-central.co.jp/";
                        break;
                }
            }
         }
         return $message;
    }

    public function shift()
    {
        $message = array("おにいちゃん、メイだよ。今日は私がサポートするね!!",
                         "おにいさん、若菜です。今日は私がお手伝いしますね!!",
                         "おにいちゃん、ヤッホー!!うただよ!!今日は私がお手伝いしちゃうよ!!",
                         "ごきげんようおにいさま!!本日は私、リナが担当いたします。");
        return $message[$this->sister];
    }




}

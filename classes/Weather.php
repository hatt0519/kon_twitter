<?php

/* Weather.php
 * 天気予報を取得するクラス
 * Author KazukiHatori
 * Email:moroku0519@gmail.com
 * PHP verion 5.4.30
 */

class Weather{
    private static $WEATHER = 'http://www.drk7.jp/weather/xml/22.xml';
    private static $WARN = 'http://weather.livedoor.com/forecast/rss/warn/22.xml';
    private $sister;

    public static function MakeWeatherMessage($sister, $date) //天気予報のメッセージ作成
    {
        $message = simplexml_load_string(Data::AccessAPI(self::$WEATHER));
        $weather = $date."の県大周辺の天気は".$message->pref->area[0]->info[0]->weather."\n";
        $temperature_min = "最高気温は".$message->pref->area[0]->info[0]->temperature->range[0]."℃\n";
        $temperature_max = "最低気温は".$message->pref->area[0]->info[0]->temperature->range[1]."℃\n";
        $rainfallchance = "降水確率\n";
        $rainfallchance_1 = "06-12時は".$message->pref->area[0]->info[0]->rainfallchance->period[1]."%\n";
        $rainfallchance_2 = "12-18時は".$message->pref->area[0]->info[0]->rainfallchance->period[2]."%\n";
        $rainfallchance_3 = "18-24時は".$message->pref->area[0]->info[0]->rainfallchance->period[3];
        switch ($sister) {
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
	
    public static function MakeWarnMessage($sister) //警報・注意報のメッセージ作成
    {
        $warn = simplexml_load_string(Data::AccessAPI(self::$WARN));
        $message = $warn->channel->item[1]->description;
        if(preg_match('/発表されています/', $warn->channel->item[1]->description)){
            switch ($sister) {
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
}
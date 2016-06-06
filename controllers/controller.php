<?php

namespace Controllers;

use \Kon\Checker;
use \Kon\MessageMaker;
use \Kon\Tweet;

class Controller
{
    const WEATHER_URI = 'http://www.drk7.jp/weather/xml/22.xml';
    const WARNING_URI = 'http://weather.livedoor.com/forecast/rss/warn/22.xml';
    const TRAIN_URI = 'https://rti-giken.jp/fhc/api/train_tetsudo/delay.json';
    public static function run($time, $today, $selected_sister, $sister, $json)
    {
        $ban_checker_uri = 'localhost:4567/checker.json?month='.$today->format('m').'&day='.$today->format('d').'&search_type=ban';
        $holiday_checker_uri = 'localhost:4567/checker.json?month='.$today->format('m').'&day='.$today->format('d').'&search_type=holiday';
        $available_room_uri = 'localhost:4567/available_room.json?month='.$today->format('m').'&day='.$today->format('d');
        $is_ban = Checker::is_ban($ban_checker_uri);
        $is_holiday = Checker::is_holiday($holiday_checker_uri);
        $message = new MessageMaker($selected_sister, $is_holiday, $is_ban);
        $tweet = new Tweet($json);
        switch($time)
        {
            case "07時00分":
                $sister->shiftChange();
                $sister->registSister();
                break;
            case "07時50分":
                $shift_message = $message->shift();
                $tweet->tweetMessage($shift_message);
                $tweet->changeProfile($selected_sister);
                break;
            case "08時30分":
                $weather_message = $message->weatherNews($time, $today->format('m'), $today->format('d'), self::WEATHER_URI, self::WARNING_URI);
                $tweet->tweetMessage($weather_message);
                break;
            case "22時30分":
                $today->modify('+1days');
                $weather_message = $message->weatherNews($time, $today->format('m'), $today->format('d'), self::WEATHER_URI, self::WARNING_URI);
                $tweet->tweetMessage($weather_message);
                break;
            default:
                switch($time)
                {
                    case "08時00分":
                        $default_message_plus = $message->default_morning();
                        $default_message = $message->default_other($time);
                        break;
                    case "12時10分":
                        $default_message_plus = $message->default_noon();
                        $available_room_uri .= '&period=3&search_range=after';
                        $default_message = $message->default_other($time);
                        break;
                    case "14時30分":
                        $available_room_uri .= '&period=4&search_range=after';
                        $default_message = $message->default_other($time);
                        break;
                    case "16時10分":
                        $available_room_uri .= '&period=5&search_range=after';
                        $default_message = $message->default_other($time);
                        break;
                    case "17時50分":
                        $default_message = $message->default_other($time);
                        $available_room_uri .= '&period=6&search_range=after';
                        break;
                    case "22時00分":
                        $today->modify('+1days');
                        $default_message_plus = $message->default_midnight();
                        $available_room_uri = 'localhost:4567/available_room.json?month='.$today->format('m').'&day='.$today->format('d');
                        break;
                    default:
                        break;
                }
                $available_room_message = $message->available_room($time, $available_room_uri);
                if(isset($default_message)) array_unshift($available_room_message, $default_message);
                if(isset($default_message_plus)) array_unshift($available_room_message, $default_message_plus);
                $tweet->tweetMessageArray($available_room_message);
                break;
        }
        if($time != "07時00分")
        {
            $train_info = $message->trainInfo(self::TRAIN_URI);
            if(!empty($train_info)) $tweet->tweetMessage($message);
        }
    }
}

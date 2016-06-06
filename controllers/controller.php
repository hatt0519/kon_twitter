<?php

namespace Controller;

use \Kon\Checker;
use \Kon\MessageMaker;
use \Kon\Tweet;

class Controller
{
    public function run($time, $today, $selected_sister, $sister, $period, $json)
    {
        $month = $today->format('m');
        $day = $today->format('d');
        $weather_uri = 'http://www.drk7.jp/weather/xml/22.xml';
        $train_uri = 'https://rti-giken.jp/fhc/api/train_tetsudo/delay.json';
        $ban_checker_uri = 'localhost:4567/checker.json?month='.$month.'&day='.$day.'&search_type=ban';
        $holiday_checker_uri = 'localhost:4567/checker.json?month='.$month.'&day='.$day.'&search_type=holiday';
        $available_room_uri = 'localhost:4567/available_room.json?month='.$month.'&day='.$day;
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
            case "08時30分": case "22時30分":
                $weather_message = $message->weatherNews($time, $month, $day);
                $tweet->tweetMessage($weather_message);
                break;
            default:
                switch($time)
                {
                    case "08時00分":
                        $default_message_plus = $message->default_morning($holiday_checker->check_holiday());
                        break;
                    case "12時10分":
                        $default_message_plus = $message->default_noon($holiday_checker->check_holiday());
                        break;
                    case "22時00分":
                        $today->modify('+1days');
                        $default_message_plus = $message->default_midnight($holiday_checker->check_holiday());
                        break;
                    default:
                        break;
                }
                $default_message = $message->default_other($time);
                $available_room_message = $message->available_room($time);
                array_unshift($available_room_message, $default_message);
                if(isset($default_message_plus)) { array_unshift($available_room_message, $default_message_plus); };
                $tweet->tweetMessageArray($available_room_message);
                break;
        }
        if($time != "07時00分")
        {
            $message->trainInfo($train_uri);
            $tweet->tweetMessage($message);
        }
    }
}

<?php

/* execute.php
 * 各種コントローラ
 * Author KazukiHatori
 * Email:moroku0519@gmail.com
 * PHP verion 5.4.30
 */

require_once("./classes/Tweet.php");
require_once("./classes/Data.php");
require_once("./classes/Sister.php");

$Tweet = new Tweet();
$Sister = new Sister();

$BAN = 'http://conoha.moroku0519.xyz:4567/ban_checker.json';
$ban_checker = json_decode(Data::AccessAPI($BAN)); //禁止日チェック

$today = new DateTime();
$time = $today->format("H時i分");

$sister = $Sister->getSister();

switch ($time){
    case "07時00分":
        $Sister->shiftChange($sister);
        $Sister->registSister();
        break;
    case "07時50分":
        $Tweet->ChangeProfile($sister);
        break;
    case "08時00分":
        $Tweet->TweetMorningMessage($sister);
        if($ban_checker->ban_flg != 1){
            $Tweet->TweetAvailableRoomToday($sister, $time);
        }else{
            $Tweet->TweetBan($sister);
        }
        break;
    case "08時30分":
        $Tweet->WeatherNews($sister, $time);
        break;
    case "22時00分":
        $Tweet->TweetAvailableRoomNextDay($sister, $time);
        break;
    case "22時30分":
        $Tweet->WeatherNews($sister,$time);
        break;
    default:
        if($ban_checker->ban_flg != 1){
            $Tweet->TweetAvailableRoomToday($sister, $time);
        } //禁止日のときはスルー
        break;
}
$Tweet->TweetTrainInfo($sister); //列車運行状況は共通
echo "つぶやき完了ヾ(*・∀・)/"; //実行通知
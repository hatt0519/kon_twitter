<?php

/* twitter.php
 * Author KazukiHatori
 * Email:moroku0519@gmail.com
 * PHP verion 5.4.30
 */

require_once("Tweet.class.php");
require_once("Curl.class.php");

$Tweet = new Tweet();

$train = json_decode($Tweet->GetTrainInfo());
$ban_checker = json_decode($Tweet->GetbanChecker());

$today = new DateTime();
$time = $today->format("H時i分");
//$time = "22時02分";
$Tweet->set_Time($time);
$Tweet->set_Train($train);
if($ban_checker->ban_flg == 1){
	switch ($Tweet->get_Time()){
		case "08時00分":
			$Tweet->TweetBan();
			$Tweet->WeatherNews($Tweet->get_Time());
			break;
		case "22時00分":
			$Tweet->TweetAvailableRoomNextDay($Tweet->get_Time());
			break;
		case "22時30分":
			$Tweet->WeatherNews($Tweet->get_Time());
			break;
		default:
			break;
	}
}else{
	$holiday_checker = json_decode($Tweet->GetholidayChecker());
	switch ($Tweet->get_Time()){
		case "08時00分":
			$Tweet->set_Holiday_Checker($holiday_checker);
			$Tweet->TweetMorningMessage($holiday_checker);
			$Tweet->TweetAvailableRoomToday($Tweet->get_Time(),$holiday_checker);
			break;
		case "08時30分":
			$Tweet->WeatherNews($Tweet->get_Time());
			break;
		case "22時00分":
			$Tweet->TweetAvailableRoomNextDay($Tweet->get_Time(),$holiday_checker);
			break;
		case "22時30分":
			$Tweet->WeatherNews($Tweet->get_Time());
			break;
		default:
			$Tweet->TweetAvailableRoomToday($Tweet->get_Time(),$holiday_checker);
			break;
	}
}
$Tweet->TweetTrainInfo($Tweet->get_Train(),$Tweet->get_Time());
echo "つぶやき完了ヾ(*・∀・)/";
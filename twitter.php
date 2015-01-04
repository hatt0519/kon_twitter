<?php

/* twitter.php
 * Author KazukiHatori
 * Email:moroku0519@gmail.com
 * PHP verion 5.4.30
 */

require_once("Tweet.class.php");
require_once("Curl.class.php");
require_once("Sister.class.php");

$Tweet = new Tweet();
$Sister = new Sister();

$train = json_decode($Tweet->GetTrainInfo());
$ban_checker = json_decode($Tweet->GetbanChecker());
$today = new DateTime();
//$time = $today->format("H時i分");
$time = "08時00分";

$sister = $Sister->getSister();

$Tweet->set_Time($time);
$Tweet->set_Train($train);
$Tweet->set_sister($sister);
if($ban_checker->ban_flg == 1){
	switch ($Tweet->get_Time()){
		case "07時50分":
			$Tweet->ChangeProfile($Tweet->get_sister());
			break;
		case "08時00分":
			$Tweet->TweetBan($Tweet->get_sister());
			break;
		case "08時30分":
			$Tweet->WeatherNews($Tweet->get_Time(),$Tweet->get_sister());
			break;
		case "22時00分":
			$holiday_checker = json_decode($Tweet->GetholidayCheckerNext());
			$Tweet->TweetAvailableRoomNextDay($Tweet->get_Time(),$holiday_checker,$Tweet->get_sister());
			break;
		case "22時30分":
			$Tweet->WeatherNews($Tweet->get_Time(),$Tweet->get_sister());
			$Sister->shiftChange();
			$Sister->registSister();
			break;
		default:
			break;
	}
}else{
	switch ($Tweet->get_Time()){
		case "07時50分":
			$Tweet->ChangeProfile($Tweet->get_sister());
			break;
		case "08時00分":
			$holiday_checker = json_decode($Tweet->GetholidayChecker());
			$Tweet->set_Holiday_Checker($holiday_checker);
			$Tweet->TweetMorningMessage($holiday_checker,$Tweet->get_sister());
			$Tweet->TweetAvailableRoomToday($Tweet->get_Time(),$holiday_checker,$Tweet->get_sister());
			break;
		case "08時30分":
			$Tweet->WeatherNews($Tweet->get_Time(),$Tweet->get_sister());
			break;
		case "22時00分":
			$holiday_checker = json_decode($Tweet->GetholidayCheckerNext());
			$Tweet->TweetAvailableRoomNextDay($Tweet->get_Time(),$holiday_checker,$Tweet->get_sister());
			break;
		case "22時30分":
			$Tweet->WeatherNews($Tweet->get_Time(),$Tweet->get_sister());
			$Sister->shiftChange();
			$Sister->registSister();
			break;
		default:
			$holiday_checker = json_decode($Tweet->GetholidayChecker());
			$Tweet->TweetAvailableRoomToday($Tweet->get_Time(),$holiday_checker,$Tweet->get_sister());
			break;
	}
}
$Tweet->TweetTrainInfo($Tweet->get_Train(),$Tweet->get_Time(),$Tweet->get_sister());
echo "つぶやき完了ヾ(*・∀・)/";
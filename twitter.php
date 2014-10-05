<?php
require_once("Tweet.class.php");
require_once("Curl.class.php");

$Tweet = new Tweet();

$train = json_decode($Tweet->GetTrainInfo());
$ban_checker = json_decode($Tweet->GetbanChecker());

$today = new DateTime();
$time = $today->format("H時i分");
//$time = "22時30分";
if($ban_checker->ban_flg == 1){
	switch ($time){
		case "08時00分":
			$Tweet->TweetBan();
			$Tweet->WeatherNews($time);
			$Tweet->TweetTrainInfo($train,$time);
			break;
		case "22時00分":
			$Tweet->TweetAvailableRoomNextDay($time);
			$Tweet->TweetTrainInfo($train,$time);
			break;
		case "22時30分":
			$Tweet->WeatherNews($time);
			$Tweet->TweetTrainInfo($train,$time);
			break;
		default:
			break;
	}
}else{
	switch ($time){
		case "08時00分":
			$holiday_checker = json_decode($Tweet->GetholidayChecker());
			$Tweet->TweetMorningMessage($holiday_checker);
			$Tweet->TweetAvailableRoomToday($time);
			$Tweet->TweetTrainInfo($train,$time);
			break;
		case "08時30分":
			$Tweet->WeatherNews($time);
			$Tweet->TweetTrainInfo($train,$time);
			break;
		case "22時00分":
			$Tweet->TweetAvailableRoomNextDay($time);
			$Tweet->TweetTrainInfo($train,$time);
			break;
		case "22時30分":
			$Tweet->WeatherNews($time);
			$Tweet->TweetTrainInfo($train,$time);
			break;
		default:
			$Tweet->TweetAvailableRoomToday($time);
			$Tweet->TweetTrainInfo($train,$time);
			break;
	}
}
<?php

/* Weather.class.php
 * Author KazukiHatori
 * Email:moroku0519@gmail.com
 * PHP verion 5.4.30
 */

require_once("Curl.class.php");

class Weather extends Curl{
	private $weather;
	private $warn;
	private $forecast;
	private $temperature_min;
	private $temperature_max;
	private $rainfallchance;
	private $rainfallchance_1;
	private $rainfallchance_2;
	private $rainfallchance_3;
	private $message;
	private $announce;

	function __construct() {
	 	$this->Curl = new Curl();
    }

	function MakeWeatherMessageToday(){
		$message = simplexml_load_string($this->GetWeatherOfShizuoka());
		$weather = "本日の県大周辺の天気は".$message->pref->area[0]->info[0]->weather."\n";
		$temperature_min = "最高気温は".$message->pref->area[0]->info[0]->temperature->range[0]."℃\n";
		$temperature_max = "最低気温は".$message->pref->area[0]->info[0]->temperature->range[1]."℃\n";
		$rainfallchance = "降水確率\n";
		$rainfallchance_1 = "06-12時は".$message->pref->area[0]->info[0]->rainfallchance->period[1]."%\n";
		$rainfallchance_2 = "12-18時は".$message->pref->area[0]->info[0]->rainfallchance->period[2]."%\n";
		$rainfallchance_3 = "18-24時は".$message->pref->area[0]->info[0]->rainfallchance->period[3]."%です\n";

		$announce = $weather.$temperature_max.$temperature_min.$rainfallchance.$rainfallchance_1.$rainfallchance_2.$rainfallchance_3;
		return $announce;
	}
	function MakeWeatherMessageNextday(){
		$message = simplexml_load_string($this->GetWeatherOfShizuoka());
		$weather = "明日の県大周辺の天気は".$message->pref->area[0]->info[1]->weather."\n";
		$temperature_min = "最高気温は".$message->pref->area[0]->info[1]->temperature->range[0]."℃\n";
		$temperature_max = "最低気温は".$message->pref->area[0]->info[1]->temperature->range[1]."℃\n";
		$rainfallchance = "降水確率\n";
		$rainfallchance_1 = "06-12時は".$message->pref->area[0]->info[1]->rainfallchance->period[1]."%\n";
		$rainfallchance_2 = "12-18時は".$message->pref->area[0]->info[1]->rainfallchance->period[2]."%\n";
		$rainfallchance_3 = "18-24時は".$message->pref->area[0]->info[1]->rainfallchance->period[3]."%です\n";

		$announce = $weather.$temperature_max.$temperature_min.$rainfallchance.$rainfallchance_1.$rainfallchance_2.$rainfallchance_3;
		return $announce;
	}
	function MakeWarnMessage(){
		$warn = simplexml_load_string($this->GetWarnOfShizuoka());
		if(preg_match('/発表されています/', $warn->channel->item[1]->description)){
			$message = $warn->channel->item[1]->description."\nみなさん気をつけてください。";

		}else{
			$message = $warn->channel->item[1]->description;
		}
		return $message;
	}
}

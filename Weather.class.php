<?php

require_once("Curl.class.php");

class Weather extends Curl{
	private $weather;
	private $forecast;
	private $temperature_min;
	private $temperature_max;
	private $message_1;
	private $message_2;
	private $message_3;
	private $message;

	function Weather() {
	 	$this->Curl = new Curl();
    }

	function MakeWeatherMessage(){

		$weather = json_decode($this->GetWeatherOfShizuoka());
		$forecast = $weather->forecasts[0]->telop;
		$temperature_min = $weather->forecasts[0]->temperature->min->celsius;
		$temperature_max = $weather->forecasts[0]->temperature->max->celsius;
		$memsage_1 ="ちなみに今日の天気は".$forecast."\n";
		if(isset($temperature_min)){
			$message_2 = "最低気温は".$temperature_min."℃\n";
		}else{
			$message_2 = "最低気温は発表されていなくて\n";
		}
		if(isset($temperature_max)){
			$message_3 = "最高気温は".$temperature_max."℃だよ!!";
		}else{
			$message_3 = "最高気温は発表されていないよ";
		}
		return $message = $memsage_1.$message_2.$message_3;
	}
}
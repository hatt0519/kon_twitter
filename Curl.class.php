<?php

/* Curl.class.php
 * Author KazukiHatori
 * Email:moroku0519@gmail.com
 * PHP verion 5.4.30
 */

class Curl {

	private $conn;
	private $url;
	private $response;

	function GetAvailableRoom(){

		$conn = curl_init();

		$url = 'http://conoha.moroku0519.xyz:4567/available_room.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}

	function GetAvailableRoom_12_10(){

		$conn = curl_init();

		$url = 'http://conoha.moroku0519.xyz:4567/available_room_12_10.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}

	function GetAvailableRoom_14_30(){

		$conn = curl_init();

		$url = 'http://conoha.moroku0519.xyz:4567/available_room_14_30.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}

	function GetAvailableRoom_16_10(){

		$conn = curl_init();

		$url = 'http://conoha.moroku0519.xyz:4567/available_room_16_10.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}

	function GetAvailableRoom_17_50(){

		$conn = curl_init();

		$url = 'http://conoha.moroku0519.xyz:4567/available_room_17_50.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}
	function GetholidayChecker(){

		$conn = curl_init();

		$url = 'http://conoha.moroku0519.xyz:4567/holiday_checker.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}

	function GetholidayCheckerNext(){

		$conn = curl_init();

		$url = 'http://conoha.moroku0519.xyz:4567/holiday_checker_nextday.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}


	function GetbanChecker(){

		$conn = curl_init();

		$url = 'http://conoha.moroku0519.xyz:4567/ban_checker.json';
		//$url = '192.168.0.7/ban_checker.json';
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}

	function GetNextDay(){

		$conn = curl_init();

		$url = 'http://conoha.moroku0519.xyz:4567/next_day_schedule.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}
	function GetWeatherOfShizuoka(){
		$conn = curl_init();

		$url = 'http://www.drk7.jp/weather/xml/22.xml';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}
	function GetbanCheckerNext(){

		$conn = curl_init();

		$url = 'http://conoha.moroku0519.xyz:4567/ban_checker_next_day.json';
		//$url = '192.168.0.7/ban_checker_next_day.json';
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}
	function GetWarnOfShizuoka(){
		$conn = curl_init();

		$url = 'http://weather.livedoor.com/forecast/rss/warn/22.xml';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}
	function GetTrainInfo(){
		$conn = curl_init();

		$url = 'https://rti-giken.jp/fhc/api/train_tetsudo/delay.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}

}


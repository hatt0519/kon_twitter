<?php

class Curl {

	private $conn;
	private $url;
	private $response;

	function GetAvailableRoom(){

		$conn = curl_init();

		$url = 'http://v157-7-235-60.z1d6.static.cnode.jp/available_room.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}

	function GetAvailableRoom_12_10(){

		$conn = curl_init();

		$url = 'http://v157-7-235-60.z1d6.static.cnode.jp/available_room_12_10.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}

	function GetAvailableRoom_14_30(){

		$conn = curl_init();

		$url = 'http://v157-7-235-60.z1d6.static.cnode.jp/available_room_14_30.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}

	function GetAvailableRoom_16_10(){

		$conn = curl_init();

		$url = 'http://v157-7-235-60.z1d6.static.cnode.jp/available_room_16_10.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}

	function GetAvailableRoom_17_50(){

		$conn = curl_init();

		$url = 'http://v157-7-235-60.z1d6.static.cnode.jp/available_room_17_50.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}
	function GetholidayChecker(){

		$conn = curl_init();

		$url = 'http://v157-7-235-60.z1d6.static.cnode.jp/holiday_checker.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}

	function GetbanChecker(){

		$conn = curl_init();

		$url = 'http://v157-7-235-60.z1d6.static.cnode.jp/ban_checker.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}

	function GetNextDay(){

		$conn = curl_init();

		$url = 'http://v157-7-235-60.z1d6.static.cnode.jp/next_day_schedule.json';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}
	function GetWeatherOfShizuoka(){
		$conn = curl_init();

		$url = 'http://weather.livedoor.com/forecast/webservice/json/v1?city=220010';
		 
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}
	function GetbanCheckerNext(){

		$conn = curl_init();

		//$url = 'http://v157-7-235-60.z1d6.static.cnode.jp/ban_checker_next_day.json';
		$url = '172.20.10.10/ban_checker_next_day.json';
		curl_setopt($conn, CURLOPT_URL, $url);
		curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
		 
		$response = curl_exec($conn);
		 
		curl_close($conn);

		return $response;
	}

}


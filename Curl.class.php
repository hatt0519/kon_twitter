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

}


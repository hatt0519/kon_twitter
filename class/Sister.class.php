<?php

/* Sister.class.php
 * Author KazukiHatori
 * Email:moroku0519@gmail.com
 * PHP verion 5.4.30
 * その日の妹を選出するクラス、DB接続含む（PDOクラス使用）
 */

class Sister {

	private $json;
	private $access_key;
	private $dns;
	private $sister;
	private $dbh;

	function __construct(){
		$json = file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR."../config/access_key.json");
		$access_key = json_decode($json); //jsonファイルをPHPオブジェクトに変換
		$dns = 'mysql:dbname='.$access_key->db_name.';host=127.0.0.1';
		try{
			$this->dbh = new PDO($dns, $access_key->db_user, $access_key->db_password); //PDOオブジェクト生成
		}catch(PDOException $e){
			 print('Error:'.$e->getMessage());
    		die();
		}
	}

	function shiftChange(){
		$sister = $this->getSister();
		$sql = "UPDATE sisters SET shift_flg = 0,pre_shift_flg = 1 WHERE id = ?";
		$sth = $this->dbh->prepare($sql);
		$sth->execute(array($sister->id));
	}

	function confirmPreShift(){
		$sql = "SELECT id FROM sisters WHERE pre_shift_flg = 1";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		$rs = $sth->fetch(PDO::FETCH_OBJ);
		return $rs;
	}

	function registSister(){
		$sister = mt_rand(1,3);
		$pre_shift = $this->confirmPreShift();
		while ($sister == $pre_shift->id){
			$sister = mt_rand(1,3);
		}

		$sql = "UPDATE sisters SET pre_shift_flg = 0 WHERE id = ?";
		$sth = $this->dbh->prepare($sql);
		$sth->execute(array($pre_shift->id));

		$sql = "UPDATE sisters SET shift_flg = 1 WHERE id = ?";
		$sth = $this->dbh->prepare($sql);
		$sth->execute(array($sister));
	}

	function getSister(){
		$sql = "SELECT id FROM sisters WHERE shift_flg = 1";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		$rs = $sth->fetch(PDO::FETCH_OBJ);
		return $rs;
	}
}
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
	private $pre_shift;
	private $dbh;

	public function set_sister($sister){ $this->sister = $sister; }
	public function set_preShift($pre_shift){$this->pre_shift = $pre_shift; }

	public function get_sister(){ return $this->sister; }
	public function get_preShift(){ return $this->pre_shift; }

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

	function chooseSister(){
		$sister = mt_rand(1,4);
		$pre_shift = $this->confirmPreShift();
		/*
		switch ($sister) {
			case 4:
				$sister = mt_rand() / mt_getrandmax() <= 0.1 ? 4 : mt_rand(1,3);
				break;
			default:
				break;
		}
		*/
		while ($sister == $pre_shift->id){
			$sister = mt_rand(1,4);
		}
		$obj = new Sister();
		$obj->set_sister($sister);
		$obj->set_preShift($pre_shift);
		
		return $obj;
	}

	function registSister(){
		$sister = $this->chooseSister();
		$sql_ary = array("UPDATE sisters SET pre_shift_flg = 0 WHERE id = ?","UPDATE sisters SET shift_flg = 1 WHERE id = ?");
		$counter = 0;
		foreach ($sql_ary as $key => $sql) {
			$sth = $this->dbh->prepare($sql);
			$sth->execute($counter == 0 ? array($sister->get_preShift()->id) : array($sister->get_sister()));
			$counter++;
		}
	}

	function getSister(){
		$sql = "SELECT id FROM sisters WHERE shift_flg = 1";
		$sth = $this->dbh->prepare($sql);
		$sth->execute();
		$rs = $sth->fetch(PDO::FETCH_OBJ);
		return $rs;
	}
}
<?php

/* Sister.php
 * Author KazukiHatori
 * Email:moroku0519@gmail.com
 * PHP verion 5.4.30
 * その日の妹を選出するクラス、DB接続含む（PDOクラス使用）
 */

class Sister{

    private static $now_shift;
    private static $pre_shift;
    private static $dbh;

    public function __construct()
    {
        $json = file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR."../config/access_key.json");
        //config取得
        $access_key = json_decode($json); //jsonファイルをPHPオブジェクトに変換
        $dns = 'mysql:dbname='.$access_key->db_name.';host=127.0.0.1';
        try{
            //PDOオブジェクト生成
            self::$dbh = new PDO($dns, $access_key->db_user, $access_key->db_password);
        }catch(PDOException $e){
            print('Error:'.$e->getMessage());
            die();
        }
    }

    public function shiftChange($sister) //現在の妹をシフトから外す
    {
        $sql = "UPDATE sisters SET shift_flg = 0,pre_shift_flg = 1 WHERE id = ?";
        $sth = self::$dbh->prepare($sql);
        $sth->execute(array($sister));
    }

    private static function confirmPreShift() //前回の妹を調べる
    {
        $sql = "SELECT id FROM sisters WHERE pre_shift_flg = 1";
        $sth = self::$dbh->prepare($sql);
        $sth->execute();
        $rs = $sth->fetch(PDO::FETCH_OBJ);
        return $rs->id;
    }

    private static function chooseSister() //次の妹を選出
    {
        $now_sister = mt_rand(0,3);
        $pre_sister = self::confirmPreShift();
        while ($now_sister == $pre_sister){
            $now_sister = mt_rand(0,3);
        }
        self::$now_shift = $now_sister;
        self::$pre_shift = $pre_sister;
    }

    public function registSister() //次の妹を登録
    {
        self::chooseSister();
        $sql_ary = array("UPDATE sisters SET pre_shift_flg = 0 WHERE id = ?",
            "UPDATE sisters SET shift_flg = 1 WHERE id = ?");
        $counter = 0;
        foreach ($sql_ary as $sql) {
            $sth = self::$dbh->prepare($sql);
            $sth->execute(
                $counter == 0 ? array(self::$pre_shift) : array(self::$now_shift)
            );
            $counter++;
        }
    }

    public function getSister() //現在の妹を取得
    {
        $sql = "SELECT id FROM sisters WHERE shift_flg = 1";
        $sth = self::$dbh->prepare($sql);
        $sth->execute();
        $rs = $sth->fetch(PDO::FETCH_OBJ);
        return $rs->id;
    }
}

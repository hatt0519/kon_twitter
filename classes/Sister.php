<?php

/* sister.php
 * Author KazukiHatori
 * Email:moroku0519@gmail.com
 * PHP verion 5.5.34
 * その日の妹を選出するクラス、DB接続含む（PDOクラス使用）
 */

namespace Kon;

class Sister extends DB
{

    private $now_sister;

    public function __construct()
    {
        parent::__construct();
        $this->now_sister = $this->getNowSister();
    }

    public function noticeNowSister(){ return $this->now_sister; }

    public function shiftChange() //現在の妹をシフトから外す
    {
        $sql = "UPDATE sisters SET shift_flg = 0, pre_shift_flg = 1 WHERE id = ?";
        $sth = $this->dbh->prepare($sql);
        $sth->execute(array($this->now_sister));
    }

    private function chooseSister() //次の妹を選出
    {
        $next_sister = mt_rand(0,3);
        while ($next_sister == $this->now_sister){
            $next_sister = mt_rand(0,3);
        }
        return $next_sister;
    }

    public function registSister() //次の妹を登録
    {
        $next_sister = $this->chooseSister();
        $sql_ary = array("UPDATE sisters SET pre_shift_flg = 0 WHERE id = ?",
                         "UPDATE sisters SET shift_flg = 1 WHERE id = ?");
        $counter = 0;
        foreach ($sql_ary as $sql) {
            $sth = $this->dbh->prepare($sql);
            $sth->execute(
                $counter == 0 ? array($this->now_sister) : array($next_sister)
            );
            $counter++;
        }
    }

    private function referencePreSister() //前回の妹を調べる
    {
        $sql = "SELECT id FROM sisters WHERE pre_shift_flg = 1";
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $rs = $sth->fetch(\PDO::FETCH_OBJ);
        return $rs->id;
    }

    private function getNowSister() //現在の妹を取得
    {
        $sql = "SELECT id FROM sisters WHERE shift_flg = 1";
        $sth = $this->dbh->prepare($sql);
        $sth->execute();
        $rs = $sth->fetch(\PDO::FETCH_OBJ);
        return $rs->id;
    }
}

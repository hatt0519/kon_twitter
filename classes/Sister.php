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

    private function chooseNextSister() //次の妹を選出
    {
        $next_sister = mt_rand(0,3);
        while ($next_sister == $this->now_sister){
            $next_sister = mt_rand(0,3);
        }
        return $next_sister;
    }

    public function registSister() //次の妹を登録
    {
        $sql = "UPDATE sisters SET shift_flg = ? WHERE id = ?";
        $sth = $this->dbh->prepare($sql);
        $sth->execute(array(0, $this->now_sister));
        $sth->execute(array(1, $this->chooseNextSister()));
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

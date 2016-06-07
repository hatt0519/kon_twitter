<?php

namespace Kon;

class DB
{
    protected $dbh;
    public function __construct()
    {
        $json = file_get_contents(dirname(__FILE__).DIRECTORY_SEPARATOR."../config/access_key.json");
        //config取得
        $access_key = json_decode($json); //jsonファイルをPHPオブジェクトに変換
        $dns = 'mysql:dbname='.$access_key->db_name.';host=127.0.0.1';
        try
        {
            //PDOオブジェクト生成
            $this->dbh = new \PDO($dns, $access_key->db_user, $access_key->db_password);
        }
        catch(\PDOException $e)
        {
            print('Error:'.$e->getMessage());
            die();
        }
    }
}

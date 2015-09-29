<?php

/* Data.php
 * 各種APIにアクセスするクラス
 * Author KazukiHatori
 * Email:moroku0519@gmail.com
 * PHP verion 5.4.30
 */

class Data{
    public static function AccessAPI($url) //APIのURLを受け取り、その結果を返す
    {

        $conn = curl_init();
         
        curl_setopt($conn, CURLOPT_URL, $url);
        curl_setopt($conn,CURLOPT_RETURNTRANSFER,true);
         
        $response = curl_exec($conn);
         
        curl_close($conn);
        return $response;
    }
}


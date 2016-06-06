<?php

/* api.php
 * 各種APIにアクセスするクラス
 * Author KazukiHatori
 * Email:moroku0519@gmail.com
 * PHP verion 5.4.30
 */

namespace Kon;

class Api
{

    public static function AccessAPI($url)
    {
        $conn = curl_init();

        curl_setopt($conn, CURLOPT_URL, $url);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($conn);

        curl_close($conn);
        return $response;
    }

    public function convertJson($uri)
    {
        return json_decode(self::AccessAPI($uri));
    }
}

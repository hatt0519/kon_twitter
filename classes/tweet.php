<?php

/* tweet.php
 * 各種つぶやきを行うクラス
 * Author KazukiHatori
 * Email:moroku0519@gmail.com
 * PHP verion 5.5.34
 */

namespace Kon;

require_once(__DIR__ . DIRECTORY_SEPARATOR. '../auth/twitteroauth.php');

use \Kon\Uri;

class Tweet
{
    //OAuthオブジェクトを格納するプロパティ
    private $tweet;
    private $uri;

    public function __construct($json)
    {
        // access_keyの値
        $access_key = json_decode($json); //jsonファイルをPHPオブジェクトに変換
        // consumer keyの値
        $consumer_key = $access_key->consumer_key;
        // consumer secretの値
        $consumer_secret = $access_key->consumer_secret;
        // access Tokenの値
        $access_token = $access_key->access_token;
        // access Token Secretの値
        $access_token_secret = $access_key->access_token_secret;
        // OAuthオブジェクト生成
        $this->tweet = new \TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);
    }

    public function tweetMessage($message)
    {
        $this->tweet->OAuthRequest(Uri::UPDATE, "POST", array("status"=>$message));
    }

    public function tweetMessageArray($massages)
    {
        foreach($massages as $message)
        {
            $this->tweetMessage($message);
            sleep(3);
        }
    }

    public function changeProfile($sister) //妹のプロフィール画像切り替え
    {
        $images = array('./images/kon_sister.png',
                       './images/kon_sister_2.jpg',
                       './images/kon_sister_3.jpg',
                       './images/kon_sister_4.jpg');

        $this->tweet->oAuthRequestImage(Uri::UPDATE_PROFILE_IMAGE, array('image' => $images[$sister]));
    }
}

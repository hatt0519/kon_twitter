<?php

/* main.php
 * 各種コントローラ
 * Author KazukiHatori
 * Email:moroku0519@gmail.com
 * PHP verion 5.4.30
 */

require_once __DIR__ . DIRECTORY_SEPARATOR . "vendor/autoload.php";

use \Controllers\Controller;

$json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR. "config/access_key.json");
$today = new DateTime();
$time = $today->format("H時i分");
Controller::run($time, $today, $json);
echo "つぶやき完了ヾ(*・∀・)/"; //実行通知

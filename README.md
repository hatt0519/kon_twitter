kon_twitter
===========
#twitter.php
-コントローラであり、各種クラスのメソッドを実行
-こいつをcronあたりに実行させればツイートされる。

#classes/Curl.php
-APIにアクセスするクラス。

#classes/Weather.php
-気象情報を参照するクラス。

#classes/Twitter.php
-twitterへの各種投稿を行うクラス。

#classes/Sister.php
-妹の切り替えを行うクラス。このクラスだけDB接続を行う。

#config/access_key.json.dist
-これをもとにtwitterAPIを通じて投稿するためのkeyとDB接続情報を管理するaccess_key.jsonを作成する。
-access_key.jsonを作成したらTwitter.php、Sister.phpにて読み込まれる。
-基本的に""の中に各種keyを記入する。


kon_twitter
===========
#twitter.php
-コントローラであり、インスタンス生成を行いツイッターへの投稿を行う。
-こいつをcronあたりに実行させればツイートされる。

クラスはclassディレクトリに配置している
#Curl.class.php
-curlを実行させるクラス。メソッドはAPIから練習表データを受ける処理のみ。

#Weather.class.php
-気象情報を参照するクラス。

#Twitter.class.php
-twitterへの各種投稿を行うクラス。

#Sister.class.php
-妹の切り替えを行うクラス。このクラスだけDB接続を行う。
This software is released under the MIT License, see LICENSE.txt.

#access_key.json.dist
-これをもとにtwitterAPIを通じて投稿するためのkeyを管理するaccess_key.jsonを作成する。
-access_key.jsonを作成したらtwitter.phpにて読み込まれる。
-基本的に""の中に各種keyを記入する。


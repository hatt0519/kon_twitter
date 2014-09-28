kon_twitter
===========
#twitter.php
-botの本体で、実行するとtwitterへの投稿を行う。今のところcronで一定時間ごとに実行させているが他のやり方を検討中。
-機能はtwitterに投稿することのみ。時間によって投稿内容を判別。データ処理はAPI側にまわしている。
#Curl.class.php
-curlを実行させるクラス。メソッドはAPIから練習表データを受ける処理のみ。

#access_key.yml.dist
-これをもとにtwitterAPIを通じて投稿するためのkeyを管理するaccess_key.ymlを作成する。
-access_key.ymlを作成したらtwitter.phpにて読み込まれる。

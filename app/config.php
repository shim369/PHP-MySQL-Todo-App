<?php
//CSRF対策、SESSIONを使った防御
session_start();

//PDOを使ってDBへアクセスするための定数定義
define('DSN', 'mysql:host=localhost;dbname=todo;charset=utf8mb4');
define('DB_USER', 'root');
define('DB_PASS', '');
// 動作環境をローカルから移す時のためにURLを定数にする
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);


//自動でファイルを読み込む
//まだ読み込まれていないclassが使われるとclass名が無名関数の引数に入ってくるのでclass変数で受ける
spl_autoload_register(function ($class) {
  $prefix = 'MyApp\\';

  // ファイル名の先頭に名前空間のMyApp\がついているとファイルの読み込みエラーになるので、ファイル名＝クラス名の先頭に$prefixがついているかどうかで条件分岐
  if(strpos($class, $prefix) === 0) {
    // 引数の$classを使ってファイルを読み込むファイル名を定義。$prefix（名前空間）の文字列の長さ分だけ省いてファイル名とする
    $fileName = sprintf(__DIR__ . '/%s.php', substr($class,strlen($prefix)));
  
    // ファイルが存在するかどうかで条件分岐
    if (file_exists($fileName)) {
      //spl_autoload_registerを使うとファイルを重複して読み込むことはないので、require_onceからrequireに変更する
      require($fileName);
    } else {
      // ファイルが存在しなければエラーメッセージをファイル名つきで表示
      echo 'File not found: ' . $fileName;
      exit;
    }
  }


});
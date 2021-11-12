<?php

// 開発の規模が大きくなるとクラス名が衝突しないように名前空間を設定しておく
namespace MyApp;

class Token
{
  // トークンを作る関数
  public static function create() {
    // セッションにトークンが仕込まれていなかったら、セッションのトークンに推測されにくい文字列をトークンとして設定する
    if (!isset($_SESSION['token'])) {
      $_SESSION['token'] = bin2hex(random_bytes(32));
    }
  }
  
  // tokenをチェックする関数
  public static function validate() {
    // セッションのトークンが空か、もしくはセッションのトークンとフォームが送信された時に一緒に送信されるトークンが一致していなければ、不正な処理になるので、メッセージを出して終了させる
    if (empty($_SESSION['token']) || $_SESSION['token'] !== filter_input(INPUT_POST, 'token')) {
        exit('Invalid post request');
      }
  }
}

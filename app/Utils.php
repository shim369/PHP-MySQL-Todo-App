<?php

// 開発の規模が大きくなるとクラス名が衝突しないように名前空間を設定しておく
namespace MyApp;

class Utils
{
  
/**
 *  XSS対策：エスケープ処理
 *  HTMLに値を埋め込む。文字の中には HTML において特殊な意味を持つものがあり、 それらの本来の値を表示したければ HTML の表現形式に変換してやらなければなりません。 この関数は、これらの変換を行った結果の文字列を返します。
 *  htmlspecialchars関数をh()で省略する書き方
 * 
 * @param string $str 対象の文字列
 * @return string 処理された文字列
 */
  public static function h($str)
  {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
  }
}
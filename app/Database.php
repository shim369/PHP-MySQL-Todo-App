<?php

// 開発の規模が大きくなるとクラス名が衝突しないように名前空間を設定しておく
namespace MyApp;

class Database
{
  //getInstance()が呼ばれるたびにDBに接続されると複数の接続ができてしまって無駄なので、PDOクラスから作られるインスタンスは必ず一つになるようにするために、class変数を作る。外部から呼び出すわけではないのでprivateにする。
  public static $instance;

  public static function getInstance() {
    //エラーになったら例外を投げるtry catch
    try {
        //このクラス変数がセットされていなかった時だけPDOのインスタンスをつくるように条件分岐
        if(!isset(self::$instance)) {
          //PDOのインスタンスを作成
          self::$instance = new \PDO(
            //data source name
            DSN,
            DB_USER,
            DB_PASS,
            [
              //エラー時の例外を投げる
              \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
              // オブジェクト形式で結果を取得するFETCH_OBJにする
              \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
              // 取得したデータの型をSQLで定義した型にあわせて取得する
              \PDO::ATTR_EMULATE_PREPARES => false,
            ]
          );
        }
        return self::$instance;
       //エラー時の例外を$eで受けとる
      } catch (\PDOException $e) {
        //エラー時の例外を表示させる
        echo $e->getMessage();
        exit;
      }
    }
}
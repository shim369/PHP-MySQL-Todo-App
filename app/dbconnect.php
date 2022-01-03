<?php
namespace MyApp;
require_once(__DIR__ . '/config.php');
function connect()
{
    try {
        $pdo = new \PDO(DSN, DB_USER, DB_PASS, [
          \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
          \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ]);
        return $pdo;
      } catch (\PDOException $e) {
        echo '接続失敗です！'. $e->getMessage();
        exit();
    }


}
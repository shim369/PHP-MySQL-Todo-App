<?php
namespace MyApp;
define('DB_USER', 'root');
define('DB_PASS', '');
function connect()
{
    $user = DB_USER;
    $pass = DB_PASS;
    

    $dsn = "mysql:host=localhost;dbname=todo;charset=utf8mb4";

    try {
        $pdo = new \PDO($dsn, $user, $pass, [
          \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
          \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        ]);
        return $pdo;
      } catch (\PDOException $e) {
        echo '接続失敗です！'. $e->getMessage();
        exit();
    }


}
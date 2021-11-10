<?php
//CSRF対策、SESSIONを使った防御
session_start();

//PDOを使ってDBへアクセスするための定数定義
define('DSN', 'mysql:host=localhost;dbname=todo;charset=utf8mb4');
define('DB_USER', 'root');
define('DB_PASS', '');


require_once(__DIR__ . '/functions.php');
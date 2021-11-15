<?php
// 相対パスでrequireすると、想定しない読み込みエラーが起きることがあるので、__DIR__で絶対パスを示すようにする
require_once(__DIR__ . '/app/config.php');

define('FILENAME', 'app/youtube.txt');
$videos = file(FILENAME, FILE_IGNORE_NEW_LINES);
$arrays = array_rand($videos, 1);
$video = $videos[$arrays];
// Database classが出てきたらMyApp\をつけて呼び出してくれる
use MyApp\Database;

use MyApp\Todo;
use MyApp\Utils;

//DBに接続
$pdo = Database::getInstance();

//$pdoを使ってTodoクラスのインスタンスを生成
$todo = new Todo($pdo);
//postで送信されたデータを処理するメソッドをprocessPost()にする
$todo->processPost();
$dones = $todo->doneAll();


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>Done List | PHP Todo App</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
  <div id="app">
    <?php include('header.php') ?>
    <div class="container">
    <main class="main" data-token="<?= Utils::h($_SESSION['token']); ?>">
      <section class="add-list">
            <div class="h2AndBtn">
              <h2 class="clearfix">
              Done List
              </h2>
              <a href="./">Todo List</a>
            </div>
            <ul>
              <?php foreach ($dones as $done) {; ?>
              <li>
                <input type="checkbox" data-id="<?= Utils::h($done->id); ?>" <?= $done->is_done ? 'checked' : ''; ?>>
                <span>
                <?php if ($done->urls) {; ?>
                <a href="<?= Utils::h($done->urls); ?>" target="_blank"><?= Utils::h($done->title); ?></a>
                <?php } else { ; ?>
                <?= Utils::h($done->title); ?>
                <?php }; ?>
                </span>
            
                <span data-id="<?= Utils::h($done->id); ?>" class="delete"><img src="img/batsu.png" alt=""></span>
              </li>
              <?php }; ?>
            </ul>
      </section>
    </main>
    
    
  </div>
  </div>
  <script src="js/menu.js"></script>
  <script> 
  function liRemove() {
  const lis = document.querySelectorAll('li');
    lis.forEach(li => {
      if (li.children[0].checked === false) {
        li.remove();
      }
    });
  }
  </script>
  <script src="js/main.js"></script>
  <script src="js/timerYoutube.js"></script>
</body>
</html>
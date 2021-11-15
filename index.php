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
// Todoを表示するために配列を取得するメソッドをgetAll()にする
$todos = $todo->getAll();
$dones = $todo->doneAll();


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>PHP Todo App</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
  <div id="app">
    <?php include('header.php') ?>
    <div class="container">
    <main class="main" data-token="<?= Utils::h($_SESSION['token']); ?>">
      <section class="add-list">
          <form action="?action=add" method="post">
            <div class="h2AndBtn">
              <h2 class="clearfix">
                Add Todo
              </h2>
                <input type="submit" class="add" value="追加">
                <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
            </div>
            <input type="text" name="title" placeholder="Todo Title">
            <input type="url" name="urls" placeholder="Todo URL">
          </form>
      </section>
      <section class="add-list">
          <form action="?action=purge" method="post">
            <div class="h2AndBtn">
              <h2 class="clearfix">
                Todo List
              </h2>
              <a href="done.php">Done List</a>
            </div>
          </form>

        <ul>
          <?php foreach ($todos as $todo) {; ?>
          <li>
            <input type="checkbox" data-id="<?= Utils::h($todo->id); ?>" <?= $todo->is_done ? 'checked' : ''; ?>>
            <span>
            <?php if ($todo->urls) {; ?>
            <a href="<?= Utils::h($todo->urls); ?>" target="_blank"><?= Utils::h($todo->title); ?></a>
            <?php } else {; ?>
            <?= Utils::h($todo->title); ?>
            <?php }; ?>
            </span>
            
            <span data-id="<?= Utils::h($todo->id); ?>" class="delete"><img src="img/batsu.png" alt=""></span>
          </li>
          <?php }; ?>
        </ul>
      </section>
   
    </main>
    
    <aside class="aside">
        <div class="sideBox">
            <div class="h2AndBtn">
              <h2 class="clearfix">
              Work 25min
              </h2>
            </div>
          <div id="timer">25:00</div>
          <div class="controls">
            <button id="start">Start</button>
            <button id="stop">Stop</button>
            <button id="reset">Reset</button>
          </div>
        </div>

        <div class="sideBox">
            <div class="h2AndBtn">
              <h2 class="clearfix">
              Rest 5min
              </h2>
              <div id="open">
                動画を見る
              </div>
            </div>
          <!--<form action="?action=addYoutube" method="post" class="videoForm">
             <input type="text" placeholder="動画ID" name="youtube">
                <input type="submit" class="addYoutube" value="動画を追加">
                <input type="hidden" name="token" value="<?/*= Utils::h($_SESSION['token']); */?>"> 
          </form>-->
          <div id="mask" class="hidden">
            <section id="modal" class="hidden">
              <div id="youtube_box"></iframe>
              </div>
              <div id="close">
                閉じる
              </div>
            </section>
          </div>
        </div>

        
      </aside>
  </div>
  </div>
  <script src="js/menu.js"></script>
  <script> 
  function liRemove() {
  const lis = document.querySelectorAll('li');
    lis.forEach(li => {
      if (li.children[0].checked) {
        li.remove();
      }
    });
  }
  </script>
  <script src="js/main.js"></script>
  <script src="js/timerYoutube.js"></script>
</body>
</html>
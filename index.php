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
    <header class="header">
      <h1>Todo App</h1>
      <nav class="pc-menu">
        <ul class="dropdown">
          <li><a href="https://github.com/shim369" target="_blank">Github</a></li>
          <li><a href="https://dotinstall.com/home" target="_blank">Dotinstall</a></li>
          <li class="menu__single">
            <a href="">More</a>
            <ul class="menu__second-level">
              <li><a href="https://leetcode.com/" target="_blank">LeetCode</a></li>
              <li><a href="https://jsprimer.net/" target="_blank">JavaScript Primer</a></li>
              <li><a href="https://prog-8.com/dashboard" target="_blank">Progate</a></li>
            </ul>
          </li>
        </ul>
      </nav>
      <div class="sp-menu">
        <span id="open-menu" class="material-icons">menu</span>
      </div> 
    </header>
    <div class="overlay">
      <span id="close-menu" class="material-icons">close</span>
      <nav>
        <ul>
          <li><a href="https://github.com/shim369" target="_blank">Github</a></li>
          <li><a href="https://dotinstall.com/home" target="_blank">Dotinstall</a></li>
          <li><a href="https://leetcode.com/" target="_blank">LeetCode</a></li>
          <li><a href="https://jsprimer.net/" target="_blank">JavaScript Primer</a></li>
          <li><a href="https://prog-8.com/dashboard" target="_blank">Progate</a></li>
        </ul>
      </nav>
    </div>
    <div class="container">
    <main class="main">
      <section class="add-list">
          <form action="?action=add" method="post">
            <div class="h2AndBtn">
              <h2 class="clearfix">
                Add Todo
              </h2>
                <input type="submit" class="add" value="追加">
                <!-- 上で作って仕込んだセッションのトークンの値をフォームに仕込む -->
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
              <div class="purge">一括削除</div>
                <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
            </div>
          </form>

        <ul>
          <?php foreach ($todos as $todo) {; ?>
          <li>
            <form action="?action=toggle" method="post">
              <input type="checkbox" <?= $todo->is_done ? 'checked' : ''; ?>>
              <input type="hidden" name="id" value="<?= Utils::h($todo->id); ?>">
              <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
            </form>
            <span class="<?= $todo->is_done ? 'done' : ''; ?>">
            <?php if ($todo->urls) {; ?>
            <a href="<?= Utils::h($todo->urls); ?>" target="_blank"><?= Utils::h($todo->title); ?></a>
            <?php } else {; ?>
            <?= Utils::h($todo->title); ?>
            <?php }; ?>
            </span>
            
            <form action="?action=delete" method="post" class="delete-form">
            <span class="delete"><img src="img/batsu.png" alt=""></span>
              <input type="hidden" name="id" value="<?= Utils::h($todo->id); ?>">
              <input type="hidden" name="token" value="<?= Utils::h($_SESSION['token']); ?>">
            </form>
          </li>
          <?php }; ?>
        </ul>
      </section>
    </main>
    
    <aside class="aside">
        <div class="timerbox">
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
        <div class="timerbox">
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
  <script src="js/main.js"></script>
  <script src="js/timerYoutube.js"></script>
</body>
</html>
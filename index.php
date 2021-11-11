<?php
// 相対パスでrequireすると、想定しない読み込みエラーが起きることがあるので、__DIR__で絶対パスを示すようにする
require_once(__DIR__ . '/app/config.php');

//CSRF。 トークンを作ってセッションに仕込む
createToken();

// 動作環境をローカルから移す時のためにURLを定数にする
// define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
define('SITE_URL', 'http://localhost/todo/');

$pdo = getPdoInstance();


// formが送信された時にデータを追加したいので、サーバー変数を調べてREQUEST_METHODがPOSTであれば、データを追加する
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // フォーム送信時に送られたトークンとセッションのトークンが一致するか調べる
  validateToken();
  // フォーム送信時に送られたクエリ文字列を取得する
  $action = filter_input(INPUT_GET, 'action');
  //actionの値によって処理を振り分ける
  switch ($action) {
    case 'add':
      addTodo($pdo);
      break;
    case 'toggle':
      toggleTodo($pdo);
      break;
    case 'delete':
      deleteTodo($pdo);
      break;
    default:
      exit;
  }

//二重投稿を防ぐために、リダイレクト処理を追加
  header('Location: ' . SITE_URL);
  exit;
}
//DBにアクセスしデータを取得する関数の実行
$todos = getTodos($pdo);

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
            <a href="">Learn</a>
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
    <div class="wrap">
    <main class="main">
      <section class="add-list">
        <form action="?action=add" method="post">
        <h2 class="clearfix">
          Todoを追加しよう！
          <input type="submit" value="追加">
        </h2>
          <input type="text" name="title" placeholder="Todo Title">
          <input type="url" name="urls" placeholder="Todo URL">
          <!-- 上で作って仕込んだセッションのトークンの値をフォームに仕込む -->
          <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>
      </section>
      <section class="add-list">
        <h2 class="clearfix">
          Todo List
        </h2>

        <ul>
          <?php foreach ($todos as $todo) {; ?>
          <li>
            <form action="?action=toggle" method="post">
              <input type="checkbox" <?= $todo->is_done ? 'checked' : ''; ?>>
              <input type="hidden" name="id" value="<?= h($todo->id); ?>">
              <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
            </form>
            <span class="<?= $todo->is_done ? 'done' : ''; ?>">
            <?php if ($todo->urls) {; ?>
            <a href="<?= h($todo->urls); ?>" target="_blank"><?= h($todo->title); ?></a>
            <?php } else {; ?>
            <?= h($todo->title); ?>
            <?php }; ?>
            </span>
            
            <form action="?action=delete" method="post" class="delete-form">
            <span class="delete"><img src="img/batsu.png" alt=""></span>
              <input type="hidden" name="id" value="<?= h($todo->id); ?>">
              <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
            </form>
          </li>
          <?php }; ?>
        </ul>
      </section>
    </main>
    
    <aside class="aside">
        <div class="timerbox">
          <div id="timer">25:00</div>
          <div class="controls">
            <button id="start">Start</button>
            <button id="stop">Stop</button>
            <button id="reset">Reset</button>
          </div>
          <div id="open">
            5分休憩動画を見る
          </div>
          <div id="mask" class="hidden">
            <section id="modal" class="hidden">
              <div id="youtube_box"></div>
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
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
</head>
<body>
  <div id="app">
    <header class="header">
      <h1>Todo App</h1>
    </header>
    <div class="wrap">
    <main class="main">
      <section class="add-list">
        <h2 class="clearfix">
          Todoを追加しよう！
        </h2>
        <form action="?action=add" method="post">
          <input type="text" name="title" placeholder="Todo Title">
          <!-- 上で作って仕込んだセッションのトークンの値をフォームに仕込む -->
          <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
        </form>

        <ul>
          <?php foreach ($todos as $todo) {; ?>
          <li>
            <form action="?action=toggle" method="post">
              <input type="checkbox" <?= $todo->is_done ? 'checked' : ''; ?>>
              <input type="hidden" name="id" value="<?= h($todo->id); ?>">
              <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
            </form>
            <span class="<?= $todo->is_done ? 'done' : ''; ?>"><?= h($todo->title); ?></span>
            
            <form action="?action=delete" method="post">
            <span class="delete">×</span>
              <input type="hidden" name="id" value="<?= h($todo->id); ?>">
              <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
            </form>
          </li>
          <?php }; ?>
        </ul>
      </section>
    </main>
  </div>
  </div>
  <script src="js/main.js"></script>
</body>
</html>
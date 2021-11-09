<?php
//PDOを使ってDBへアクセスするための定数定義
define('DSN', 'mysql:host=localhost;dbname=todo;charset=utf8mb4');
define('DB_USER', 'root');
define('DB_PASS', '');

// 動作環境をローカルから移す時のためにURLを定数にする
// define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
define('SITE_URL', 'http://localhost/todo/work/public/');


//エラーになったら例外を投げるtry catch
try {
  //PDOのインスタンスを作成
  $pdo =new PDO(
    //data source name
    DSN,
    DB_USER,
    DB_PASS,
    [
      //エラー時の例外を投げる
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      // オブジェクト形式で結果を取得するFETCH_OBJにする
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
      // 取得したデータの型をSQLで定義した型にあわせて取得する
      PDO::ATTR_EMULATE_PREPARES => false,
    ]
  );
   //エラー時の例外を$eで受けとる
} catch (PDOException $e) {
  //エラー時の例外を表示させる
  echo $e->getMessage();
  exit;
}
// HTMLに値を埋め込む。文字の中には HTML において特殊な意味を持つものがあり、 それらの本来の値を表示したければ HTML の表現形式に変換してやらなければなりません。 この関数は、これらの変換を行った結果の文字列を返します。
// htmlspecialchars関数をh()で省略する書き方
function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}
// データの追加処理の定義
function addTodo($pdo)
{
  // データの取得し、前後に半角空白があればtrimで除去する
  $title = trim(filter_input(INPUT_POST, 'title'));
  // タイトルが空文字であれば追加の必要がないので、処理をストップ
  if($title === '') {
    return;
  }
  // 空文字でなければデータを追加する。prepareメソッドでSQL文を指定する。
  // INSERTでレコードを挿入。
  $stmt = $pdo->prepare("INSERT INTO todos (title) VALUES (:title)");
  // 値を紐づけるために、型の指定ができるbindValueを使用し、titleのプレースホルダーに対して、titleの値を割り当て、文字列型を指定する。
  $stmt->bindValue('title', $title, PDO::PARAM_STR);
  // レコードの追加を実行
  $stmt->execute();
}
//DBにアクセスしデータを取得する関数に定義
function getTodos($pdo)
{
  // PDOからすべてのレコードを取得
  $stmt = $pdo->query("SELECT * FROM todos ORDER BY id DESC");
  // SQL文の結果が帰ってくる
  $todos = $stmt->fetchAll();
  return $todos;
}
// formが送信された時にデータを追加したいので、サーバー変数を調べてREQUEST_METHODがPOSTであれば、データを追加する
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  addTodo($pdo);

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
  <link rel="stylesheet" href="../../css/style.css">
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
        <form action="" method="post">
          <input type="text" name="title" placeholder="Todo Title">
        </form>

        <ul>
          <?php foreach ($todos as $todo) {; ?>
          <li>
            <input type="checkbox" <?= $todo->is_done ? 'checked' : ''; ?>>
            <span class="<?= $todo->is_done ? 'done' : ''; ?>"><?= h($todo->title); ?></span>
          </li>
          <?php }; ?>
        </ul>
      </section>
    </main>
  </div>
  </div>
</body>
</html>
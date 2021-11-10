<?php

function getPdoInstance() {
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

    return $pdo;
   //エラー時の例外を$eで受けとる
  } catch (PDOException $e) {
    //エラー時の例外を表示させる
    echo $e->getMessage();
    exit;
  }
}
// HTMLに値を埋め込む。文字の中には HTML において特殊な意味を持つものがあり、 それらの本来の値を表示したければ HTML の表現形式に変換してやらなければなりません。 この関数は、これらの変換を行った結果の文字列を返します。
// htmlspecialchars関数をh()で省略する書き方
function h($str)
{
  return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// トークンを作る関数
function createToken() {
  // セッションにトークンが仕込まれていなかったら、セッションのトークンに推測されにくい文字列をトークンとして設定する
  if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
  }
}

// tokenをチェックする関数
function validateToken() {
  // セッションのトークンが空か、もしくはセッションのトークンとフォームが送信された時に一緒に送信されるトークンが一致していなければ、不正な処理になるので、メッセージを出して終了させる
  if (empty($_SESSION['token']) || $_SESSION['token'] !== filter_input(INPUT_POST, 'token')) {
      exit('Invalid post request');
    }
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

function toggleTodo($pdo) {
  //送信されてきたidを取得する
  $id = filter_input(INPUT_POST,'id');
  if(empty($id)) {
    return;
  }
 //チェックボッスに変化があると（チェックを入れると）チェックボックスのformでidが送信され、テーブルのis_doneカラムにtrueが入る。formの送信イベントはmain.jsに記載。
  $stmt = $pdo->prepare("UPDATE todos SET is_done = NOT is_done WHERE id = :id");
  $stmt->bindValue('id', $id, PDO::PARAM_INT);
  $stmt->execute();
}

function deleteTodo($pdo) {
  //送信されてきたidを取得する
  $id = filter_input(INPUT_POST,'id');
  if(empty($id)) {
    return;
  }
 //チェックボッスに変化があると（チェックを入れると）チェックボックスのformでidが送信され、テーブルのis_doneカラムにtrueが入る。formの送信イベントはmain.jsに記載。
  $stmt = $pdo->prepare("DELETE FROM todos WHERE id = :id");
  $stmt->bindValue('id', $id, PDO::PARAM_INT);
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
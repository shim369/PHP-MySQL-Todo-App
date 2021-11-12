<?php

// 開発の規模が大きくなるとクラス名が衝突しないように名前空間を設定しておく
namespace MyApp;

class todo
{
  // コンストトラクタに渡す$pdoはプロパティとして保持して他のメソッドで使うためにここで宣言しておく
  private $pdo;
  //引数に$pdoを渡したコンストラクタを定義
  public function __construct($pdo)
  {
    // 引数をプロパティに代入する
    $this->pdo = $pdo;
    //CSRF対策。 トークンを作ってセッションに仕込む
    Token::create();
  }
  //processPost()メソッドを定義する
  public function processPost()
  {
    // formが送信された時にデータを追加したいので、サーバー変数を調べてREQUEST_METHODがPOSTであれば、データを追加する
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // フォーム送信時に送られたトークンとセッションのトークンが一致するか調べる
      Token::validate();
      // フォーム送信時に送られたクエリ文字列を取得する
      $action = filter_input(INPUT_GET, 'action');
      //actionの値によって処理を振り分ける
      switch ($action) {
        case 'add':
          $this->add();
          break;
        case 'toggle':
          $this->toggle();
          break;
        case 'delete':
          $this->delete();
          break;
        case 'purge':
          $this->purge();
          break;
        default:
          exit;
      }

      //二重投稿を防ぐために、リダイレクト処理を追加
      header('Location: ' . SITE_URL);
      exit;
    }
  }

  // データの追加処理の定義
  private function add()
  {
    // データの取得し、前後に半角空白があればtrimで除去する
    $title = trim(filter_input(INPUT_POST, 'title'));
    $urls = trim(filter_input(INPUT_POST, 'urls'));
    // タイトルが空文字であれば追加の必要がないので、処理をストップ
    if($title === '') {
      return;
    }
    // 空文字でなければデータを追加する。prepareメソッドでSQL文を指定する。
    // INSERTでレコードを挿入。
    $stmt = $this->pdo->prepare("INSERT INTO todos (title,urls) VALUES (:title,:urls)");
    // 値を紐づけるために、型の指定ができるbindValueを使用し、titleのプレースホルダーに対して、titleの値を割り当て、文字列型を指定する。
    $stmt->bindValue('title', $title, \PDO::PARAM_STR);
    $stmt->bindValue('urls', $urls, \PDO::PARAM_STR);
    // レコードの追加を実行
    $stmt->execute();
  }

  private function toggle() {
    //送信されてきたidを取得する
    $id = filter_input(INPUT_POST,'id');
    if(empty($id)) {
      return;
    }
  //チェックボッスに変化があると（チェックを入れると）チェックボックスのformでidが送信され、テーブルのis_doneカラムにtrueが入る。formの送信イベントはmain.jsに記載。
    $stmt = $this->pdo->prepare("UPDATE todos SET is_done = NOT is_done WHERE id = :id");
    $stmt->bindValue('id', $id, \PDO::PARAM_INT);
    $stmt->execute();
  }

  private function delete() {
    //送信されてきたidを取得する
    $id = filter_input(INPUT_POST,'id');
    if(empty($id)) {
      return;
    }
  //チェックボッスに変化があると（チェックを入れると）チェックボックスのformでidが送信され、テーブルのis_doneカラムにtrueが入る。formの送信イベントはmain.jsに記載。
    $stmt = $this->pdo->prepare("DELETE FROM todos WHERE id = :id");
    $stmt->bindValue('id', $id, \PDO::PARAM_INT);
    $stmt->execute();
  }

  private function purge()
  {
    $this->pdo->query("DELETE FROM todos WHERE is_done = 1");
  }

  //DBにアクセスしデータを取得する関数に定義
  public function getAll()
  {
    // PDOからすべてのレコードを取得
    $stmt = $this->pdo->query("SELECT * FROM todos ORDER BY id DESC");
    // SQL文の結果が帰ってくる
    $todos = $stmt->fetchAll();
    return $todos;
  }
}
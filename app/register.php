<?php

namespace MyApp;

require_once(__DIR__ . '/../common.php'); 
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/UserLogic.php');

$errs = [];

$token = filter_input(INPUT_POST, 'csrf_token');
//トークンがない、もしくは一致しない場合、処理を中止
if(!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
  exit('不正なリクエスト');
}
//二重送信対策
unset($_SESSION['csrf_token']);

//validate
if(!$username = filter_input(INPUT_POST, 'username')) {
  $errs[] = 'ユーザー名を記入してください。';
}
if(!$email = filter_input(INPUT_POST, 'email')) {
  $errs[] = 'メールアドレスを記入してください。';
}
$password = filter_input(INPUT_POST, 'password');
//正規表現でバリデートする
//8文字以上100文字以下の英数字だった場合はOK
if(!preg_match("/\A[a-z\d]{8,100}+\z/i",$password)) {
  $errs[] = 'パスワードは英数字8文字以上100文字以下にしてください';
}
$password_conf = filter_input(INPUT_POST, 'password_conf');
if($password !== $password_conf) {
  $errs[] = '確認用パスワードと異なっています';
}
//エラーがなければユーザー登録
if(count($errs) === 0) {
  $hasCreated = UserLogic::createUser($_POST);

  if(!$hasCreated) {
    $errs[] = '登録に失敗しました';
  }
}

$result = UserLogic::checkLogin();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ユーザー登録完了画面 | <?php echo $title; ?></title>
	<?php include('../head.php') ?>
</head>
<body>
  <div id="app">
    <?php include('../header.php') ?>
    <div class="container">
    <main class="main">
      <section class="add-list common-box">
            <div class="ttl-box">
              <h2>
              <span class="material-icons">account_circle</span><span class="ttl">ユーザー登録</span>
              </h2>
              <a href="./signup_form.php" class="btn red">Back</a>
            </div>
  <?php if(count($errs) > 0): ?>
    <?php foreach($errs as $err): ?>
      <p><?php echo $err ?></p>
    <?php endforeach ?>
  <?php else: ?>
    <p>ユーザー登録が完了しました。</p>
  <?php endif ?>
      </section>
    </main>
    </div>
        <footer>
          <small>©2021 Shim</small>
        </footer>
    </div>
	<?php include('../common_footer.php') ?>
</body>
</html>
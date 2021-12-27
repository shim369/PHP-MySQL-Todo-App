<?php

namespace MyApp;
require_once 'UserLogic.php';

$errs = [];

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

  if($hasCreated) {
    $err[] = '登録に失敗しました';
  }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録完了画面</title>
</head>
<body>
  <?php if(count($errs) > 0): ?>
    <?php foreach($errs as $err): ?>
      <p><?php echo $err ?></p>
    <?php endforeach ?>
  <?php else: ?>
    <p>ユーザー登録が完了しました。</p>
  <?php endif ?>
  <a href="./signup_form.php">戻る</a>
</body>
</html>
<?php
namespace MyApp;
require_once(__DIR__ . '/UserLogic.php');


$errs = [];


if(!$email = filter_input(INPUT_POST, 'email')) {
  $errs['email'] = 'メールアドレスを記入してください。';
}
if(!$password = filter_input(INPUT_POST, 'password')){
  $errs['password'] = 'パスワードを記入してください。';
}


//ログインする処理
if(count($errs) > 0) {
  //エラーがあった場合は戻す
  $_SESSION = $errs;
  header('Location: login_form.php');
  return;
}
//ログイン成功時の処理
$result = UserLogic::login($email,$password);
//ログイン失敗時の処理
if(!$result) {
  header('Location: login_form.php');
  return;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログイン完了</title>
</head>
<body>
  <h2>ログイン完了</h2>
    <p>ログインしました！</p>
  <a href="./mypage.php">マイページへ</a>
</body>
</html>
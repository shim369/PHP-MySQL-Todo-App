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
if($result) {
  header('Location: /todo/index.php');
  return;
}
//ログイン失敗時の処理
if(!$result) {
  header('Location: login_form.php');
  return;
}

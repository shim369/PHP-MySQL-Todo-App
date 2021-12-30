<?php
namespace MyApp;
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/Utils.php');
require_once(__DIR__ . '/UserLogic.php');

$result = UserLogic::checkLogin();
if($result) {
  header('Location: mypage.php');
  return;
}

$login_err = isset($_SESSION['login_err']) ? $_SESSION['login_err'] : null;
unset($_SESSION['login_err']);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ユーザー登録画面</title>
</head>
<body>
  <h2>ユーザー登録フォーム</h2>
  <?php if(isset($login_err)): ?>
        <p><?php echo $login_err; ?></p>
  <?php endif; ?>
  <form action="register.php" method="POST">
    <div>
      <label for="username">ユーザー名：</label>
      <input type="text" name="username">
    </div>
    <div>
      <label for="email">メールアドレス：</label>
      <input type="email" name="email">
    </div>
    <div>
      <label for="password">パスワード：</label>
      <input type="password" name="password">
    </div>
    <div>
      <label for="password_conf">パスワード確認：</label>
      <input type="password" name="password_conf">
    </div>
    <div>
      <input type="hidden" name="csrf_token" value="<?php echo Utils::h(Utils::setToken()); ?>">
      <input type="submit" value="新規登録">
    </div>
  </form>
  <a href="login_form.php">ログインする</a>
</body>
</html>
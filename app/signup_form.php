<?php
namespace MyApp;
require_once(__DIR__ . '/../common.php'); 
require_once(__DIR__ . '/config.php');
require_once(__DIR__ . '/Utils.php');
require_once(__DIR__ . '/UserLogic.php');

$result = UserLogic::checkLogin();
if($result) {
  header('Location: /todo/index.php');
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
  <title>ユーザー登録画面 | <?php echo $title; ?></title>
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
            </div>
            <?php if(isset($login_err)): ?>
                  <p><?php echo $login_err; ?></p>
            <?php endif; ?>
            <form action="register.php" method="POST">
              <div>
                <label for="username">ユーザー名</label>
                <input type="text" name="username">
              </div>
              <div>
                <label for="email">メールアドレス</label>
                <input type="email" name="email">
              </div>
              <div>
                <label for="password">パスワード</label>
                <input type="password" name="password">
              </div>
              <div>
                <label for="password_conf">パスワード確認</label>
                <input type="password" name="password_conf">
              </div>
              <div>
                <input type="hidden" name="csrf_token" value="<?php echo Utils::h(Utils::setToken()); ?>">
                <p class="tcenter t-m10"><input class="btn red" type="submit" value="Sign up"></p>
              </div>
            </form>
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
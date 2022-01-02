<?php
namespace MyApp;
require_once(__DIR__ . '/../common.php'); 
require_once(__DIR__ . '/UserLogic.php');

$result = UserLogic::checkLogin();
if($result) {
  header('Location: /todo/index.php');
  return;
}
$err = $_SESSION;

//$_SESSION clear
$_SESSION = array();
//session file delete
session_destroy();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ログイン画面 | <?php echo $title; ?></title>
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
              <span class="ttl">ログインフォーム</span>
              </h2>
              <a href="signup_form.php" class="btn red">Sign Up</a>
            </div>
            <?php include('../common_footer.php') ?>
            <?php if(isset($err['msg'])): ?>
              <p><?php echo $err['msg']; ?></p>
            <?php endif; ?>
            <form action="login.php" method="POST">
              <div>
                <label for="email">メールアドレス</label>
                <input type="email" name="email">
                <?php if(isset($err['email'])): ?>
                  <p><?php echo $err['email']; ?></p>
                <?php endif; ?>
              </div>
              <div>
                <label for="password">パスワード</label>
                <input type="password" name="password">
                <?php if(isset($err['password'])): ?>
                  <p><?php echo $err['password']; ?></p>
                <?php endif; ?>
              </div>
              <div class="t-m20">
                <p class="tcenter"><input type="submit" value="Login" class="btn red"></p>
              </div>
            </form>
      </section>
    </main>
    </div>
    </div>
</body>
</html>
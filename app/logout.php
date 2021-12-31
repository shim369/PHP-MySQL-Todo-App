<?php

namespace MyApp;

require_once(__DIR__ . '/../common.php'); 
require_once(__DIR__ . '/UserLogic.php');

$logout = filter_input(INPUT_POST, 'logout');

if(!$logout) {
  exit('不正なリクエストです。');
}

$result = UserLogic::checkLogin();

if(!$result) {
  exit('セッションが切れましたので、ログインし直してください。');
}

UserLogic::logout();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ログアウト | <?php echo $title; ?></title>
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
              <span class="ttl">ログアウト完了</span>
              </h2>
            </div>
            <ul id="list-ul">
              <li>ログアウトしました。</li>
            </ul>
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
<?php
// 相対パスでrequireすると、想定しない読み込みエラーが起きることがあるので、__DIR__で絶対パスを示すようにする
require_once(__DIR__ . '/app/config.php');
require_once(__DIR__ . '/common.php'); 

define('FILENAME', 'app/youtube.txt');
$videos = file(FILENAME, FILE_IGNORE_NEW_LINES);
$arrays = array_rand($videos, 1);
$video = $videos[$arrays];
// Database classが出てきたらMyApp\をつけて呼び出してくれる
use MyApp\Database;

use MyApp\Todo;
use MyApp\Utils;

//DBに接続
$pdo = Database::getInstance();

//$pdoを使ってTodoクラスのインスタンスを生成
$todo = new Todo($pdo);
//postで送信されたデータを処理するメソッドをprocessPost()にする
$todo->processPost();
$dones = $todo->doneAll();


?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
	<meta name="robots" content="noindex">
  <title>Done List | <?php echo $title; ?></title>
	<?php include('head.php') ?>
</head>
<body>
  <div id="app">
    <?php include('header.php') ?>
    <div class="container">
    <main class="main" data-token="<?= Utils::h($_SESSION['token']); ?>">
      <section class="add-list common-box">
            <div class="ttl-box">
              <h2 class="clearfix">
              <span class="material-icons">list</span><span class="ttl">Done List</span>
              </h2>
              <a href="./" class="alink btn">Todo List</a>
            </div>
            <ul>
              <?php foreach ($dones as $done) {; ?>
              <li data-id="<?= Utils::h($done->id); ?>">
                <input type="checkbox" <?= $done->is_done ? 'checked' : ''; ?>>
                <span>
                <?php if ($done->urls) {; ?>
                <a href="<?= Utils::h($done->urls); ?>" target="_blank"><?= Utils::h($done->title); ?></a>
                <?php } else { ; ?>
                <?= Utils::h($done->title); ?>
                <?php }; ?>
                </span>
                <span class="delete"><span class="material-icons">delete</span></span>
              </li>
              <?php }; ?>
            </ul>
      </section>
    </main>
  </div>
  </div>
  <?php include('common_footer.php') ?>
  <script> 
  function liRemove() {
  const lis = document.querySelectorAll('li');
    lis.forEach(li => {
      if (li.children[0].checked === false) {
        li.remove();
      }
    });
  }
  </script>
</body>
</html>
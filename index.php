<?php
// 相対パスでrequireすると、想定しない読み込みエラーが起きることがあるので、__DIR__で絶対パスを示すようにする
require_once(__DIR__ . '/app/config.php');
require_once(__DIR__ . '/common.php'); 

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
// Todoを表示するために配列を取得するメソッドをgetAll()にする
$todos = $todo->getAll();
$videos = $todo->getVideoAll();
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
	<meta name="robots" content="noindex">
  <title><?php echo $title; ?></title>
	<?php include('head.php') ?>
  <script>
    function selectYoutube() {
      var videos = JSON.parse('<?php echo $videos; ?>');
      let video = videos[Math.floor(Math.random() * videos.length)];
      youtube_box.innerHTML = `<iframe width="100%" height="315" src="https://www.youtube.com/embed/${video}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
    }
  </script>
</head>
<body>
  <div id="app" data-token="<?= Utils::h($_SESSION['token']); ?>">
    <?php include('header.php') ?>
    <div class="container">
    <main class="main">
      <section class="add-list common-box">
          <form id="mainForm" autocomplete="off">
            <div class="ttl-box">
              <h2>
              <span class="material-icons">add_circle_outline</span><span class="ttl">Add Todo</span>
              </h2>
                <input type="submit" class="add btn red" value="Add">
            </div>
            <input type="text" name="title" placeholder="Todo Title">
            <input type="url" name="urls" placeholder="Todo URL">
          </form>
      </section>
      <section class="add-list common-box">
            <div class="ttl-box">
              <h2>
              <span class="material-icons">list</span><span class="ttl">Todo List</span>
              </h2>
              <span class="purge btn red">Purge</span>
            </div>

        <ul id="list-ul">
          <?php foreach ($todos as $todo) {; ?>
          <li data-id="<?= Utils::h($todo->id); ?>">
            <input type="checkbox" <?= $todo->is_done ? 'checked' : ''; ?>>
            <span>
            <?php if ($todo->urls) {; ?>
            <a href="<?= Utils::h($todo->urls); ?>" target="_blank"><?= Utils::h($todo->title); ?></a>
            <?php } else {; ?>
            <?= Utils::h($todo->title); ?>
            <?php }; ?>
            </span>
            <span class="delete material-icons">delete</span>
          </li>
          <?php }; ?>
        </ul>
      </section>
    </main>
    
    <aside class="aside">
        <div class="side-box common-box">
            <div class="ttl-box">
              <h2>
              <span class="material-icons">timer</span><span class="ttl">Work 25min</span>
              </h2>
            </div>
          <div id="timer">25:00</div>
          <div class="controls">
            <button id="start" class="btn brown">Start</button>
            <button id="stop" class="btn brown">Stop</button>
            <button id="reset" class="btn brown">Reset</button>
          </div>
        </div>

        <div class="side-box common-box">
            <div class="ttl-box">
              <h2>
              <span class="material-icons">play_circle_outline</span><span class="ttl">Rest 5min</span>
              </h2>
            </div>
          <form class="videoForm" autocomplete="off">
            <input type="text" placeholder="YouTube Video ID" name="youtubeId">
            <input type="submit" class="addYoutube btn brown" value="Add">
          </form>
          <button id="open" class="yt btn brown">Rest</button>

            <div id="mask" class="hidden">
            <section id="modal" class="hidden">
              <div id="youtube_box"></div>
              <button id="close" class="yt btn brown">Close</button>
            </section>
          </div>
        </div>
      </aside>
  </div>
      <footer>
        <small>©2021 Shim</small>
      </footer>
  </div>
	<?php include('common_footer.php') ?>
</body>
</html>
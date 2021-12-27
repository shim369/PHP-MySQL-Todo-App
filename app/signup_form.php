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
      <input type="submit" value="新規登録">
    </div>
  </form>
</body>
</html>
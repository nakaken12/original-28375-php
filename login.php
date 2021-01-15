<?php
session_start();
require('dbconnect.php');

if (!empty($_POST)) {
  if ($_POST['email'] !== '' && $_POST['password'] !== '') {
    $login = $db->prepare('SELECT * FROM users WHERE email=? AND password=?');
    $login->execute(array(
      $_POST['email'],
      sha1($_POST['password'])
    ));
    $member = $login->fetch();

    if ($member) {
      $_SESSION['id'] = $member['id'];
      $_SESSION['time'] = time();

      header('Location: index.php');
      exit();
    } else {
      $error['login'] = 'failed';
    }
  } else {
    $error['login'] = 'blank';
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/header.scss">
  <link rel="stylesheet" href="css/user-management.css">
  <link rel="stylesheet" href="css/footer.scss">
  <link rel="stylesheet" href="css/error.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/reset.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Films-php</title>
</head>
<body>
  
<?php require("shared/header.php") ?>

<form action="" method="post">
  <div class='form-wrap'>
    <div class='form-header'>
      <h1 class='form-header-text'>
        ログイン
      </h1>
    </div>

    <!-- エラー文 -->
      <?php if ($error['login'] === 'blank'): ?>
        <p class="error">・Eメールまたはパスワードを入力してください</p>
      <?php endif; ?>
      <?php if ($error['login'] === 'failed'): ?>
        <p class="error">・Eメールまたはパスワードが違います</p>
      <?php endif; ?>
    <!-- エラー文 -->

    <div class="form-group">
      <div class='form-text-wrap'>
        <label class="form-text">メールアドレス</label>
      </div>
      <input type="text" name="email" class="input-default" value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>">
    </div>
    <div class="form-group">
      <div class='form-text-wrap'>
        <label class="form-text">パスワード</label>
      </div>
      <input type="password" name="password" class="input-default" value="">
    </div>
    <div class='login-btn'>
      <input type="submit" class="login btn btn-primary" value="ログイン">
    </div>
  </div>
</form>

<?php require("shared/footer.php") ?>
  
</body>
</html>
<?php
session_start();
require("dbconnect.php");

if (!empty($_POST)) {
  if ($_POST['nickname'] === '') {
    $error['nickname'] = 'blank';
  }
  
  if ($_POST['email'] === '') {
    $error['email'] = 'blank';
  }
  
  if ($_POST['password'] === '') {
    $error['password'] = 'blank';
  }
  
  if (strlen($_POST['password']) > 0 && strlen($_POST['password']) < 6) {
    $error['password-a'] = 'length';
  }

  if (!preg_match("/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]+\z/i", $_POST['password'])) {
    $error['password-b'] = 'character';
  }
  
  if ($_POST['confirm_password'] === '') {
    $error['confirm_password'] = 'blank';
  }
  
  if ($_POST['confirm_password'] !== $_POST['password']) {
    $error['confirm_password'] = 'different';
  }

  // 重複エラー
  if (empty($error)) {
    $member = $db->prepare('SELECT COUNT(*) AS cnt FROM users WHERE email=?');
    $member->execute(array($_POST['email']));
    $record = $member->fetch();
    if ($record['cnt'] > 0) {
      $error['email'] = 'duplicate';
    }
  }
  // 重複エラー

  if (empty($error)) {
    $statement = $db->prepare('INSERT INTO users(nickname, email, password, created) VALUES(?, ?, ?, NOW())');
    $statement->execute(array(
        $_POST['nickname'],
        $_POST['email'],
        sha1($_POST['password'])
    ));

    $login = $db->prepare('SELECT * FROM users WHERE nickname=? AND email=?');
    $login->execute(array(
      $_POST['nickname'],
      $_POST['email']
    ));
    $member = $login->fetch();
    $_SESSION['id'] = $member['id'];
    $_SESSION['time'] = time();

    header('Location: index.php');
    exit();
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
  
<?php require("shared/header.php"); ?>

<form action="" method="post">
  <div class='form-wrap'>
    <div class='form-header'>
      <h1 class='form-header-text'>
        新規登録
      </h1>
    </div>

    <!-- エラー文 -->
      <?php if ($error['nickname'] === 'blank'): ?>
        <p class="error">・ニックネームを入力してください</p>
      <?php endif; ?>
      <?php if ($error['email'] === 'blank'): ?>
        <p class="error">・Eメールを入力してください</p>
      <?php endif; ?>
      <?php if ($error['email'] === 'duplicate'): ?>
        <p class="error">・メールアドレスが既に登録されています</p>
      <?php endif; ?>
      <?php if ($error['password'] === 'blank'): ?>
        <p class="error">・パスワードを入力してください</p>
      <?php endif; ?>
      <?php if ($error['password-a'] === 'length'): ?>
        <p class="error">・パスワードは6文字以上で入力してください</p>
      <?php endif; ?>
      <?php if ($error['password-b'] === 'character'): ?>
        <p class="error">・パスワードは半角英数字で入力してください</p>
      <?php endif; ?>
      <?php if ($error['confirm_password'] === 'blank'): ?>
        <p class="error">・パスワード(確認)を入力してください</p>
      <?php endif; ?>
      <?php if ($error['confirm_password'] === 'different'): ?>
        <p class="error">・パスワードが一致しません</p>
      <?php endif; ?>
    <!-- エラー文 -->

    <div class="form-group">
      <div class='form-text-wrap'>
        <label class="form-text">ニックネーム</label>
      </div>
      <input type="text" name="nickname" maxlength="40" placeholder="例) film太郎" class="input-default" value="<?php print(htmlspecialchars($_POST['nickname'], ENT_QUOTES)); ?>">
    </div>
    <div class="form-group">
      <div class='form-text-wrap'>
        <label class="form-text">メールアドレス</label>
      </div>
      <input type="text" name="email" class="input-default" placeholder="PC・携帯どちらでも可" value="<?php print(htmlspecialchars($_POST['email'], ENT_QUOTES)); ?>">
    </div>
    <div class="form-group">
      <div class='form-text-wrap'>
        <label class="form-text">パスワード</label>
      </div>
      <input type="password" name="password" placeholder="6文字以上の半角英数字" class="input-default" value="">
    </div>
    <div class="form-group">
      <div class='form-text-wrap'>
        <label class="form-text">パスワード(確認)</label>
      </div>
      <input type="password" name="confirm_password" placeholder="同じパスワードを入力して下さい" class="input-default" value="">
    </div>
    <div class='login-btn'>
      <input type="submit" class="sign-up btn btn-success" value="登録">
    </div>
  </div>
</form>

<?php require("shared/footer.php") ?>
  
</body>
</html>
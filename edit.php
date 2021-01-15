<?php
session_start();
require('dbconnect.php');

if (empty($_POST)) {
  // ログインしていないと入れない
  if (!isset($_SESSION['id']) && !isset($_SESSION['time'])) {
    header('Location: index.php');
    exit();
  }
  // ログインしていないと入れない

  if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) {
    $post_id = $_REQUEST['id'];

    $posts = $db->prepare('SELECT * FROM posts WHERE id=?');
    $posts->execute(array($post_id));
    $post = $posts->fetch();

    // 投稿者以外は入れない
    if ($_SESSION['id'] !== $post['user_id']) {
      header('Location: index.php');
      exit();
    }
    // 投稿者以外は入れない
  }
}

if (!empty($_POST)) {
  if ($_POST['title'] === '') {
    $error['title'] = 'blank';
  }

  if ($_POST['genre'] === '--') {
    $error['genre'] = 'blank';
  }

  if (empty($_POST['spoiler'])) {
    $error['spoiler'] = 'blank';
  }

  if ($_POST['content'] === '') {
    $error['content'] = 'blank';
  }

  if (empty($error)) {
    $statement = $db->prepare('UPDATE posts SET title=?, content=?, genre=?, spoiler=? WHERE id=?');
    $statement->execute(array(
      $_POST['title'],
      $_POST['content'],
      $_POST['genre'],
      $_POST['spoiler'],
      $_POST['id']
    ));

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
  <link rel="stylesheet" href="css/post.css">
  <link rel="stylesheet" href="css/footer.scss">
  <link rel="stylesheet" href="css/error.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/reset.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Films-php</title>
</head>
<body>

<?php require("shared/header.php"); ?>

<div class="posts-sell-contents">
  <div class="posts-sell-main">
    <h2 class="posts-sell-title">投稿の編集</h2>

    <!-- エラー文 -->
    <?php if ($error['title'] === 'blank'): ?>
      <p class="error">・タイトル名を入力してください</p>
    <?php endif; ?>
    <?php if ($error['genre'] === 'blank'): ?>
      <p class="error">・「--」以外を選択してください</p>
    <?php endif; ?>
    <?php if ($error['spoiler'] === 'blank'): ?>
      <p class="error">・ネタバレの有無を選択してださい</p>
    <?php endif; ?>
    <?php if ($error['content'] === 'blank'): ?>
      <p class="error">・レビューを入力してください</p>
    <?php endif; ?>
    <!-- エラー文 -->

    <form action="" method="post" class="new_posts">

      <input type="hidden" name="id" value="<?php print($post_id); ?>">

      <!-- タイトル名 -->
      <div class="weight-bold-text">
        タイトル名
        <span class="indispensable">必須</span>
      </div>
      <input type="text" name="title" class="title-text" maxlength="40" value="<?php print(htmlspecialchars($post['title'], ENT_QUOTES)); ?>">
      <!-- タイトル名 -->

      <!-- ジャンル -->
      <div class="posts-genre">
        <div class="form">
          <div class="weight-bold-text">
            ジャンル
            <span class="indispensable">必須</span>
          </div>
          <select name="genre" class="select-box">
            <option value="--">--</option>
            <option value="アニメ" <?php if ($post['genre'] === "アニメ") { print('selected'); } ?>>アニメ</option>
            <option value="アクション" <?php if ($post['genre'] === "アクション") { print('selected'); } ?>>アクション</option>
            <option value="アドベンチャー" <?php if ($post['genre'] === "アドベンチャー") { print('selected'); } ?>>アドベンチャー</option>
            <option value="SF" <?php if ($post['genre'] === "SF") { print('selected'); } ?>>SF</option>
            <option value="キッズ・ファミリー" <?php if ($post['genre'] === "キッズ・ファミリー") { print('selected'); } ?>>キッズ・ファミリー</option>
            <option value="コメディ" <?php if ($post['genre'] === "コメディ") { print('selected'); } ?>>コメディ</option>
            <option value="サスペンス" <?php if ($post['genre'] === "サスペンス") { print('selected'); } ?>>サスペンス</option>
            <option value="時代劇" <?php if ($post['genre'] === "時代劇") { print('selected'); } ?>>時代劇</option>
            <option value="青春" <?php if ($post['genre'] === "青春") { print('selected'); } ?>>青春</option>
            <option value="戦争" <?php if ($post['genre'] === "戦争") { print('selected'); } ?>>戦争</option>
            <option value="ドキュメンタリー" <?php if ($post['genre'] === "ドキュメンタリー") { print('selected'); } ?>>ドキュメンタリー</option>
            <option value="ドラマ" <?php if ($post['genre'] === "ドラマ") { print('selected'); } ?>>ドラマ</option>
            <option value="ファンタジー" <?php if ($post['genre'] === "ファンタジー") { print('selected'); } ?>>ファンタジー</option>
            <option value="ホラー" <?php if ($post['genre'] === "ホラー") { print('selected'); } ?>>ホラー</option>
            <option value="ミュージカル・音楽" <?php if ($post['genre'] === "ミュージカル・音楽") { print('selected'); } ?>>ミュージカル・音楽</option>
            <option value="恋愛" <?php if ($post['genre'] === "恋愛") { print('selected'); } ?>>恋愛</option>
          </select>
        </div>
      </div>
      <!-- ジャンル -->

      <!-- スコア -->
      <!-- スコア -->

      <!-- ネタバレ -->
      <div class="posts-spoiler">
        <div class="weight-bold-text">
          ネタバレ
          <span class="indispensable">必須</span>
        </div>
        <input type="radio" <?php if ($post['spoiler'] === "true") { print('checked="checked"'); } ?> name="spoiler" value="true">ネタバレあり
        <input type="radio" <?php if ($post['spoiler'] === "false") { print('checked="checked"'); } ?> name="spoiler" value="false">ネタバレなし
      </div>    
      <!-- ネタバレ -->

      <!-- レビュー -->
      <div class="posts-review">
        <div class="weight-bold-text">
          鑑賞記録
          <span class="indispensable">必須</span>
        </div>
        <textarea name="content" cols="30" rows="10" class="posts-text"><?php print(htmlspecialchars($post['content'], ENT_QUOTES)); ?></textarea>
      </div>
      <!-- レビュー -->

      <!-- 下部ボタン -->
      <div class="sell-btn-contents">
        <input type="submit" class="btn btn-primary" value="投稿する">
      </div>
      <!-- 下部ボタン -->
    </form>
  </div>
</div>

<?php require("shared/footer.php") ?>
  
</body>
</html>
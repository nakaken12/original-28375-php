<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id']) && isset($_SESSION['time'])) {
  $id = $_SESSION['id'];
}

$counts = $db->query("SELECT COUNT(*) AS cnt FROM posts WHERE genre LIKE '" . $_REQUEST['value'] . "' ");
$cnt = $counts->fetch();

$posts = $db->query("SELECT p.*, u.nickname FROM posts p, users u WHERE p.user_id=u.id AND genre LIKE '" . $_REQUEST['value'] . "' ORDER BY p.created DESC");  

?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="css/header.scss">
  <link rel="stylesheet" href="css/index.scss">
  <link rel="stylesheet" href="css/footer.scss">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/reset.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Films-php</title>
</head>
<body>

<?php require("shared/header.php"); ?>

<!-- 投稿一覧 -->
<div class='post-contents'>
  <h2 class='title'><?php print($cnt['cnt']); ?>件の検索結果</h2>
  <ul class='post-lists'>

    <!-- 投稿のインスタンス変数になにか入っている場合、中身を展開 -->
      <?php foreach ($posts as $post): ?>
        <li class='list'>
          <div class='post-info'>
            <div class='user-page'>
              <?php if (($id !== $post['user_id']) || !isset($id)): ?>
                <a href="user-page.php?id=<?php print($post['user_id']); ?>"><?php print(htmlspecialchars($post['nickname'], ENT_QUOTES)); ?></a>
              <?php endif; ?>
            </div>

            <!-- タイトル -->
            <h3 class='post-title'>
              <?php print(htmlspecialchars($post['title'], ENT_QUOTES)); ?>
            </h3>
            <!-- タイトル -->

            <!-- ジャンル -->
            <h2 class='post-genre'>
              ジャンル : <?php print(htmlspecialchars($post['genre'], ENT_QUOTES)); ?>
            </h2>
            <!-- ジャンル -->

            <!-- ネタバレ -->
            <?php if ($post['spoiler'] === 'true'): ?>
              <details>
            <?php endif; ?>
              <?php if ($post['spoiler'] === 'true'): ?>
                <summary role="button" aria-expanded="false" class='netabare'>このレビューはネタバレを含みます</summary>
              <?php endif; ?>
              <h3 class='post-content'>
                <?php print(htmlspecialchars($post['content'], ENT_QUOTES)); ?>
              </h3>
            <?php if ($post['spoiler'] === 'true'): ?>
              </details>
            <?php endif; ?>
            <!-- ネタバレ -->
            
            <?php if (!empty($id) && $post['user_id'] === $id): ?>
              <a href="edit.php?id=<?php print($post['id']); ?>" class="btn btn-warning">編集</a>
              <a href="delete.php?id=<?php print($post['id']); ?>" class="btn btn-danger">削除</a>
            <?php endif; ?>
          </div>
        </li>
      <?php endforeach; ?>
    <!-- 投稿のインスタンス変数になにか入っている場合、中身を展開 -->

    <!-- 投稿がない場合のダミー -->
    <?php if ($cnt['cnt'] === '0'): ?>
      <div class='post-dummy'>
        <h3 class='dummy-title'>
          該当する投稿が見つかりません。<br>検索結果を変えて、再度お試しください。
        </h3>
      </div>
    <?php endif; ?>
    <!-- 投稿がない場合のダミー -->
  </ul>
</div>

<!-- 投稿一覧 -->

<?php require("shared/footer.php"); ?>

</body>
</html>
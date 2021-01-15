<?php
require('dbconnect.php');

$member = $db->prepare('SELECT * FROM users WHERE id=?');
$member->execute(array($_REQUEST['id']));
$record = $member->fetch();

$counts = $db->prepare('SELECT COUNT(*) AS cnt FROM posts WHERE user_id=?');
$counts->execute(array($_REQUEST['id']));
$cnt = $counts->fetch();

$posts = $db->prepare('SELECT * FROM posts WHERE user_id=? ORDER BY created DESC');
$posts->execute(array($_REQUEST['id']));

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
  <h2 class='title'><?php print(htmlspecialchars($record['nickname'])); ?></h2>
  <h2 class='sub-title'><?php print($cnt['cnt']); ?>件の投稿</h2>
  <ul class='post-lists'>

    <!-- 投稿のインスタンス変数になにか入っている場合、中身を展開 -->
      <?php foreach ($posts as $post): ?>
        <li class='list'>
          <div class='post-info'>

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
          まだ投稿はありません
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
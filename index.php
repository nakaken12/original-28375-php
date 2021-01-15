<?php
session_start();
require('dbconnect.php');

if (isset($_SESSION['id']) && isset($_SESSION['time'])) {
  $id = $_SESSION['id'];
}

$counts = $db->query('SELECT COUNT(*) AS cnt FROM posts');
$cnt = $counts->fetch();

$posts = $db->query('SELECT p.*, u.nickname FROM posts p, users u WHERE p.user_id=u.id ORDER BY p.created DESC');
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

<!-- 広告部分 -->
<div class='add-header-contents'>
  <h2 class='header-service-title'>
    F i l m s
  </h2>
  <p class='header-service-explain'>
    〜観たい映画がきっと見つかる〜
  </p>
  <div class='store-btn'>
    <a href="#"><img src="https://linkmaker.itunes.apple.com/ja-jp/badge-lrg.svg?releaseDate=2011-09-21&kind=iossoftware&bubble=ios_apps" alt="App Store" class="apple-btn"></a>
    <a href="#"><img src="images/dl-android.png" alt="Google Play" class="google-btn"></a>
  </div>
</div>
<!-- 広告部分 -->

<!-- Filmsとは -->
<h2 class='feature-title'> Filmsとは </h2>
<div class="parents-horizon">
  <hr class='horizon'>
</div>
<p class='top-feature-title'>Filmsは、映画のレビューサービスです。</p>
<p class='second-feature-title'>観賞した作品のレビューを投稿したり、</p>
<p class='second-feature-title'>みんなのレビューをチェックできる機能をベースに</p>
<p class='second-feature-title'>「作品の観賞録」や「作品の感想・情報をシェアして楽しむツール」</p>
<p class='bottom-feature-title'>としてご利用いただけます。</p>
<!-- Filmsとは -->

<!-- 投稿一覧 -->
<div class='post-contents'>
  <h2 class='title'>新着投稿</h2>
  <ul class='post-lists'>

    <!-- 投稿のインスタンス変数になにか入っている場合、中身を展開 -->
      <?php foreach ($posts as $post): ?>
        <li class='list'>
          <div class='post-info'>
            <div class='user-page'>
              <a href="user-page.php?id=<?php print($post['user_id']); ?>"><?php print(htmlspecialchars($post['nickname'], ENT_QUOTES)); ?></a>
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
          まだ投稿はありません
        </h3>
      </div>
    <?php endif; ?>
    <!-- 投稿がない場合のダミー -->
  </ul>

  <!-- <div class="paging">
    <a href="#" class="paging-left">前へ</a>
    <a href="#" class="paging-right">次へ</a>
  </div> -->

</div>

<!-- 投稿一覧 -->

<?php require("shared/footer.php"); ?>

</body>
</html>
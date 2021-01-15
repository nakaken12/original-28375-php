<!-- 広告部分 -->
<?php session_start(); ?>

<div class='footer-title-contents'>
  <h2 class='footer-service-title'>
    いい映画との出会いを、あなたに。
  </h2>
  <p class='footer-contents-explain'>
    Filmsでは、みんなのリアルな映画レビューをチェックできます。
  </p>
  <p class='footer-contents-explain'>
    気になる作品、話題の作品のレビューを今すぐチェック！
  </p>
  <p class='footer-contents-explain'>
    あなたにとって最高の映画がきっと見つかる。
  </p>
  <?php if (!isset($_SESSION['id']) && !isset($_SESSION['time'])): ?>
    <p class='footer-contents-explain'>
      さあ、はじめよう。
    </p>
    <div>
      <ul class='user-management'>
        <li><a href="../login.php" class="login btn btn-primary">ログイン</a></li>
        <li><a href="../sign-up.php" class="sign-up btn btn-success">新規登録</a></li>
      </ul>
    </div>
  <?php endif; ?>
</div>
<!-- 広告部分 -->

<div class='footer'>
  <ul class='footer-link-parents'>
    <li><a href="#" class="footer-link">会社概要(運営会社)</a></li>
    <li><a href="#" class="footer-link">Films利用規約</a></li>
    <li><a href="#" class="footer-link">プライバシーポリシー</a></li>
  </ul>
  <p>© Films</p>
</div>

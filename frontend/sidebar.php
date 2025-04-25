<?php
// 用 $page 来高亮当前菜单，比如在每个页面最上面： $page='index';
?>
<aside>
  <h2>自管理</h2>
  <nav>
    <a href="index.php"      class="<?= $page=='index'?'active':'' ?>">首頁</a>
    <a href="TIMELINE.php"   class="<?= $page=='timeline'?'active':'' ?>">任務時間軸</a>
    <a href="news.php"       class="<?= $page=='news'?'active':'' ?>">交通快訊</a>
    <a href="card.php"       class="<?= $page=='card'?'active':'' ?>">小鹿知識卡</a>
    <a href="settings.php"   class="<?= $page=='settings'?'active':'' ?>">設定</a>
    <a href="profile.php"    class="<?= $page=='profile'?'active':'' ?>">個人資料</a>
    <a href="chat.php"       class="<?= $page=='chat'?'active':'' ?>">與小鹿對話</a>
  </nav>

  <?php if(isset($_SESSION['user_id'])): ?>
    <a href="logout.php" class="btn-login">登出 (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
  <?php else: ?>
    <a href="login.php"  class="btn-login">登入</a>
  <?php endif; ?>
</aside>

<?php
require_once 'config.php';
// 將當前頁面以 $page 告訴 nav 判斷哪個要加 .active
?>
<!DOCTYPE html>
<html lang="zh-Hant">
<head>
  <meta charset="UTF-8">
  <title>智能小鹿</title>
  <link rel="stylesheet" href="sidebar.css">
  <style>
  /* 全站共用 Card */
  main { flex:1; padding:30px; overflow:auto; background:#eaf9f3; }
  .card { background:#fff; border-radius:12px; padding:20px; margin-bottom:20px;
          box-shadow:0 2px 8px rgba(0,0,0,0.05); }
  .section-title { font-size:24px; margin-bottom:20px; }
  /* Login-card */
  .login-card { width:360px; margin:80px auto; background:#fff; border-radius:12px;
                padding:40px; box-shadow:0 2px 8px rgba(0,0,0,0.05); }
  .login-card h2 { text-align:center; margin-bottom:20px; }
  .login-card input, .login-card button { width:100%; padding:12px; margin-bottom:15px;
                                          border-radius:6px; border:1px solid #ccc; }
  .login-card button { background:#27c197; color:#fff; border:none; cursor:pointer; }
  /* Timeline */
  .month-nav, .legend { display:flex; align-items:center; gap:10px; margin-bottom:10px; }
  .month-nav button { background:#27c197; color:#fff; border:none; padding:6px 12px;
                      border-radius:4px; cursor:pointer; }
  .legend-item { display:flex; align-items:center; gap:6px; }
  .color-box { width:16px; height:16px; border-radius:3px; }
  .violation { background:#e74c3c; }
  .tax       { background:#f1c40f; }
  .inspect   { background:#3498db; }
  .timeline { display:grid; gap:4px; align-items:center; overflow-x:auto; }
  .timeline-header { display:contents; }
  .timeline-header div { text-align:center; font-weight:bold; padding:4px 0; }
  .task { border-radius:5px; padding:6px 0; text-align:center; color:#fff;
          font-size:12px; }
  </style>
</head>
<body>
  <aside>
    <h2>自管理</h2>
    <nav>
      <a href="index.php"        class="<?= $page==='index'?'active':'' ?>">首頁</a>
      <a href="TIMELINE.php"     class="<?= $page==='timeline'?'active':'' ?>">任務時間軸</a>
      <a href="news.php"         class="<?= $page==='news'?'active':'' ?>">交通快訊</a>
      <a href="card.php"         class="<?= $page==='card'?'active':'' ?>">小鹿知識卡</a>
      <a href="settings.php"     class="<?= $page==='settings'?'active':'' ?>">設定</a>
      <a href="profile.php"      class="<?= $page==='profile'?'active':'' ?>">個人資料</a>
      <a href="chat.html"         class="<?= $page==='chat'?'active':'' ?>">與小鹿對話</a>
    </nav>

    <!-- 登入/登出 按鈕固定左下 -->
    <div style="position:absolute;bottom:20px;left:20px;">
      <?php if(isset($_SESSION['user_id'])): ?>
        <a href="logout.php" style="background:#27c197;color:#fff;padding:10px 20px;
          border-radius:6px;display:inline-block;text-decoration:none;">
          登出 (<?= htmlspecialchars($_SESSION['username']) ?>)
        </a>
      <?php else: ?>
        <a href="login.php" style="color:purple;text-decoration:underline;">
          登入
        </a>
      <?php endif; ?>
    </div>
  </aside>
  <main>

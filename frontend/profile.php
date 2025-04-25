<?php
$page = 'profile';
include 'header.php';
?>
<div class="card">
  <h2>個人資料</h2>
  <?php if (isset($_SESSION['user_id'])): ?>
    <p>帳號：<?= htmlspecialchars($_SESSION['username']) ?></p>
    <h3>名下動產</h3>
    <ul>
      <li>AAA-1234｜Toyota Corolla｜1800cc</li>
      <li>BBB-5678｜Honda CBR150R｜150cc</li>
      <li>CCC-9012｜BMW X5｜3000cc</li>
    </ul>
  <?php else: ?>
    <p>請先登入才能檢視個人資料。</p>
  <?php endif; ?>
</div>
<?php include 'footer.php'; ?>

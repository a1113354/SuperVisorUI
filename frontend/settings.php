<?php
$page = 'settings';
include 'header.php';
?>
<div class="card">
  <h2>動產管理</h2>
  <?php if (isset($_SESSION['user_id'])): ?>
    <form action="#" method="post">
      <input type="text"   name="plate"       placeholder="車牌" style="width:100%; padding:8px; margin-bottom:10px;">
      <input type="text"   name="brand"       placeholder="廠牌" style="width:100%; padding:8px; margin-bottom:10px;">
      <select name="category" style="width:100%; padding:8px; margin-bottom:10px;">
        <option>汽車</option>
        <option>機車</option>
      </select>
      <input type="text"   name="model"       placeholder="車型" style="width:100%; padding:8px; margin-bottom:10px;">
      <input type="text"   name="displacement" placeholder="排氣量(如1800cc)" style="width:100%; padding:8px; margin-bottom:10px;">
      <button type="submit" style="background:#27c197;color:#fff;padding:10px 20px;border:none;border-radius:6px;cursor:pointer;">
        新增動產
      </button>
    </form>
  <?php else: ?>
    <p>請先登入才能設定動產。</p>
  <?php endif; ?>
</div>
<?php include 'footer.php'; ?>

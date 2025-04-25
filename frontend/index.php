<?php
$page = 'index';
include 'header.php';
?>

<div class="card">
  <div class="section-title">📌 今日任務</div>
  <?php if(isset($_SESSION['user_id'])): 
    // 實際請打 SQL 抓 user_id 名下的車牌
    $tasks = [
      'AAA-1234'=>['本月編排車稅','監理檢驗剩 2 天'],
      'BBB-5678'=>['本月編排車稅','監理檢驗剩 2 天'],
      'CCC-9012'=>['本月編排車稅','監理檢驗剩 2 天'],
    ];
    foreach($tasks as $plate=>$ts): 
      foreach($ts as $t): ?>
        <p>• <?= htmlspecialchars($plate) ?>：<?= htmlspecialchars($t) ?></p>
      <?php endforeach;
    endforeach;
  else: ?>
    <p>尚無待辦事項。</p>
  <?php endif; ?>
</div>

<div class="card">
  <div class="section-title">最新快訊</div>
  <?php
    // 實際可改成迴圈抓 DB
  ?>
  <p>4月5日<br>國道1號中段交流道南下棟站</p>
</div>

<div class="card">
  <div class="section-title">今日小知識：</div>
  <?php
    $tip = '若車輛遭拘未驗，罰款最高可達9000元！';
  ?>
  <p><?= htmlspecialchars($tip) ?></p>
</div>

<div class="card">
  <div class="section-title">公局知知</div>
  <?php
    $notice = '※ 新法來了！今年還有新車稅優惠';
  ?>
  <p><?= htmlspecialchars($notice) ?></p>
</div>

<?php include 'footer.php'; ?>

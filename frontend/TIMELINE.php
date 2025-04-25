<?php
// TIMELINE.php
$page = 'timeline';
include 'header.php';

// 判断是否已登录
$isPersonal = isset($_SESSION['user_id']);

// 通例（未登录）数据
$genericTasks = [
  5 => [
    ['day'=>1,'span'=>5,'type'=>'tax','label'=>'每年五月繳稅'],
  ],
  7 => [
    ['day'=>1,'span'=>5,'type'=>'inspect','label'=>'每年七月檢驗'],
  ],
];

// 个人（登录后）数据
$personalTasks = [
  5 => [
    ['vehicle'=>'AAA-1234','day'=>4,'span'=>4,'type'=>'violation','label'=>'罰鍰'],
    ['vehicle'=>'AAA-1234','day'=>6,'span'=>4,'type'=>'tax',      'label'=>'繳稅'],
    ['vehicle'=>'BBB-5678','day'=>7,'span'=>4,'type'=>'tax',      'label'=>'繳稅'],
    ['vehicle'=>'CCC-9012','day'=>8,'span'=>4,'type'=>'inspect',  'label'=>'檢驗'],
  ]
];
?>
<style>
/* 让所有任务色块可上下偏移 */
.timeline .task {
  position: relative;
}
/* 罰鍰 往上移 12px */
.timeline .task.violation {
  top: -12px;
}
/* 繳稅 往下移 12px */
.timeline .task.tax {
  top: 12px;
}
/* 檢驗 保持正中 */
.timeline .task.inspect {
  top: 0;
}
</style>

<div class="card">
  <div class="section-title">任務時間軸</div>

  <!-- 月份切換 -->
  <div class="month-nav">
    <button id="prev">&lt;</button>
    <span id="month-label">5月</span>
    <button id="next">&gt;</button>
  </div>

  <!-- 仅登录后显示的图例 -->
  <div class="legend" <?= $isPersonal ? '' : 'style="display:none;"'?>>
    <div class="legend-item"><div class="color-box violation"></div>AAA-1234</div>
    <div class="legend-item"><div class="color-box tax"></div>BBB-5678</div>
    <div class="legend-item"><div class="color-box inspect"></div>CCC-9012</div>
  </div>

  <!-- 任务网格 -->
  <div class="timeline" id="timeline-grid"></div>
</div>

<script>
// 从 PHP 传来的变量
const isPersonal   = <?= json_encode($isPersonal) ?>;
const tasksByMonth = isPersonal
  ? <?= json_encode($personalTasks, JSON_UNESCAPED_UNICODE) ?>
  : <?= json_encode($genericTasks, JSON_UNESCAPED_UNICODE) ?>;

// 每个月的天数表
const monthDays = [31,28,31,30,31,30,31,31,30,31,30,31];
let currentMonth = 5;

function renderTimeline(month) {
  const days = monthDays[month-1];
  const grid = document.getElementById('timeline-grid');
  grid.style.gridTemplateColumns = `120px repeat(${days},40px)`;
  grid.innerHTML = '';

  // 渲染表头
  const header = document.createElement('div');
  header.className = 'timeline-header';
  header.innerHTML = '<div></div>' +
    Array.from({length: days}, (_, i) => `<div>${i+1}</div>`).join('');
  grid.appendChild(header);

  const monthTasks = tasksByMonth[month] || [];

  if (isPersonal) {
    // 三辆车固定三行
    const vehicles = ['AAA-1234','BBB-5678','CCC-9012'];
    vehicles.forEach((veh, idx) => {
      const row = idx + 2; // AAA->2, BBB->3, CCC->4

      // 行标签留空
      const lbl = document.createElement('div');
      lbl.style.gridRowStart = row;
      lbl.textContent = '';
      grid.appendChild(lbl);

      // 渲染该车所有任务
      monthTasks
        .filter(t => t.vehicle === veh)
        .forEach(t => {
          const b = document.createElement('div');
          b.className = `task ${t.type}`;
          b.style.gridRowStart    = row;
          b.style.gridColumnStart = t.day + 1;
          b.style.gridColumnEnd   = `span ${t.span}`;
          b.textContent = t.label;
          grid.appendChild(b);
        });
    });
  } else {
    // 通例单行
    const row = 2;
    const lbl = document.createElement('div');
    lbl.style.gridRowStart = row;
    lbl.textContent = '';
    grid.appendChild(lbl);

    monthTasks.forEach(t => {
      const b = document.createElement('div');
      b.className = `task ${t.type}`;
      b.style.gridRowStart    = row;
      b.style.gridColumnStart = t.day + 1;
      b.style.gridColumnEnd   = `span ${t.span}`;
      b.textContent = t.label;
      grid.appendChild(b);
    });
  }
}

// 翻月按钮
document.getElementById('prev').onclick = () => {
  if (currentMonth > 1) {
    currentMonth--;
    document.getElementById('month-label').textContent = `${currentMonth}月`;
    renderTimeline(currentMonth);
  }
};
document.getElementById('next').onclick = () => {
  if (currentMonth < 12) {
    currentMonth++;
    document.getElementById('month-label').textContent = `${currentMonth}月`;
    renderTimeline(currentMonth);
  }
};

// 首次渲染
renderTimeline(currentMonth);
</script>

<?php include 'footer.php'; ?>

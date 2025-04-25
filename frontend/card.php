<?php include 'header.php'; ?>
<div class="card">
  <h3>小鹿知識卡</h3>
  <div id="card-text"></div>
  <button onclick="nextTip()">下一張</button>
</div>
<script>
  const tips = [
    '每次行駛前請檢查輪胎氣壓與胎紋深度。',
    '汽機油建議每5000公里或半年更換一次。', 
    // ... 共 10 條
  ];
  let idx=0;
  function nextTip(){
    document.getElementById('card-text').textContent = tips[idx++];
    if(idx>=tips.length) idx=0;
  }
  window.addEventListener('load', nextTip);
</script>
<?php include 'footer.php'; ?>

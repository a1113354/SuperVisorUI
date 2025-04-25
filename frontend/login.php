<?php
$page = 'login';
include 'header.php';

$error = '';
if ($_SERVER['REQUEST_METHOD']==='POST') {
  $u = $_POST['username'] ?? '';
  $p = $_POST['password'] ?? '';
  // 假設資料庫密碼是 MD5('abc')
  $stmt = $db->prepare("SELECT id,username FROM users WHERE username=? AND password=MD5(?)");
  $stmt->bind_param('ss',$u,$p);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($res->num_rows===1) {
    $row = $res->fetch_assoc();
    $_SESSION['user_id']   = $row['id'];
    $_SESSION['username']  = $row['username'];
    header('Location: index.php');
    exit;
  } else {
    $error = '帳號或密碼錯誤';
  }
}
?>

<div class="login-card">
  <h2>系統登入</h2>
  <?php if($error): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
  <?php endif; ?>
  <form method="post">
    <input name="username" placeholder="帳號">
    <input name="password" type="password" placeholder="密碼">
    <button type="submit">登入</button>
  </form>
  <p><a href="index.php">&larr; 返回首頁</a></p>
  <p><a href="register.php">註冊新帳號</a></p>
</div>

<?php include 'footer.php'; ?>

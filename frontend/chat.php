<?php
// chat.php
$page = 'chat';
include 'header.php';
require 'config.php';

// 啟動 Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 初始化對話歷史
if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}

// 處理使用者輸入
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
    $userMessage = trim($_POST['message']);
    // 加入到對話歷史
    $_SESSION['chat_history'][] = [
        'role'    => 'user',
        'content' => $userMessage,
    ];

    // 根據登入狀態選擇 system prompt
    if (isset($_SESSION['user_id'])) {
        $systemPrompt = <<<EOD
你是智能監理小鹿，已知使用者的帳號 ID {$_SESSION['user_id']}，他名下有以下車輛：
 AAA-1234 (Toyota Corolla 1800cc)  
 BBB-5678 (Honda CBR150R 150cc)  
 CCC-9012 (BMW X5 3000cc)  
請根據這些車輛資料，回答跟車輛監理相關的個人化問題。
EOD;
    } else {
        $systemPrompt = '你是智能監理小鹿，回答一般監理考題、罰鍰、行車安全等常見問題，其他非監理業務之事項尚不回應。';
    }

    // 組成要送到 OpenAI 的訊息清單
    $messages = array_merge(
        [['role'=>'system','content'=> $systemPrompt]],
        $_SESSION['chat_history']
    );

    // 呼叫 OpenAI ChatCompletion API
    $ch = curl_init('https://api.openai.com/v1/chat/completions');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST           => true,
        CURLOPT_HTTPHEADER     => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . OPENAI_API_KEY,
        ],
        CURLOPT_POSTFIELDS => json_encode([
            'model'       => 'gpt-4o',
            'messages'    => $messages,
            'temperature' => 0.7,
            'max_tokens'  => 500,
        ]),
    ]);
    $resp = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($resp, true);
    $assistantMessage = $data['choices'][0]['message']['content'] 
        ?? '抱歉，無法取得回應。';

    // 把小鹿的回應存進歷史
    $_SESSION['chat_history'][] = [
        'role'    => 'assistant',
        'content' => $assistantMessage,
    ];
}
?>

<div class="card">
  <div class="section-title">與小鹿對話</div>
  <div class="chat-window">
    <?php foreach ($_SESSION['chat_history'] as $msg): ?>
      <div class="message <?= htmlspecialchars($msg['role']) ?>">
        <?= nl2br(htmlspecialchars($msg['content'], ENT_QUOTES)) ?>
      </div>
    <?php endforeach; ?>
  </div>
  <form method="post" class="chat-form">
    <textarea 
      name="message" 
      rows="3" 
      placeholder="請輸入你的問題…" 
      required
    ></textarea>
    <button type="submit">送出</button>
  </form>
</div>

<?php include 'footer.php'; ?>

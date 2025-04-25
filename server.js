// server.js
require('dotenv').config();
const express = require('express');
const cors    = require('cors');
const session = require('express-session');
const OpenAI  = require('openai');
const path    = require('path');

const app = express();

// 啟用 CORS
app.use(cors({ origin: true, credentials: true }));

// 解析 JSON
app.use(express.json());

// 啟用 session 中介軟體
app.use(session({
  secret: process.env.SESSION_SECRET || 'supersecret',
  resave: false,
  saveUninitialized: false,
  cookie: { secure: false }
}));

// 提供整個專案目錄下的靜態檔案（包含 SU 資料夾）
app.use(express.static(__dirname));

// 建立 OpenAI 客戶端
const openai = new OpenAI({
  apiKey: process.env.OPENAI_API_KEY,
});
// 範例登入 API（測試用，正式請換成真實驗證）
app.post('/api/login', (req, res) => {
  req.session.userId = req.body.userId || '1234';
  res.json({ ok: true });
});

// Chat API
app.post('/api/chat', async (req, res) => {
  const { message } = req.body;
  const loggedIn = Boolean(req.session.userId);

  // 動態 system prompt，涵蓋所有監理事宜
  const systemPrompt = loggedIn
    ? `你是智能監理小鹿（個人化模式），已知使用者 ID ${req.session.userId}，其名下車輛：
- AAA-1234 (Toyota Corolla 1800cc)
- BBB-5678 (Honda CBR150R 150cc)
- CCC-9012 (BMW X5 3000cc)

提示：使用者可能詢問以下監理業務：
• 牌照稅與燃料使用費計算
• 環保檢驗（排放檢測）流程與費用
• 違規罰單金額、申訴流程與繳納期限
• 過戶手續、文件與費用

請根據臺灣現行相關法規：
- 《使用牌照稅法》
- 《燃料使用費法》
- 《道路交通管理處罰條例》
- 《空氣污染防制法》

針對使用者具體提問：
1. 列出適用法條與計算公式
2. 給出具體費用數字與繳納或檢驗時間
3. 解釋流程步驟、所需文件及期限
4. 如有減免、申訴或優惠，附上比較與建議
5. 回答必須具體詳盡，不要僅提供超連結或籠統資訊。`
    : `你是智能監理小鹿（公開模式），僅回答臺灣政府公開的監理業務一般資訊，涵蓋：
• 牌照稅與燃料稅計算方式與法規依據
• 環保檢驗的項目、頻率與費用
• 罰單種類、罰鍰金額範圍與繳納期限
• 過戶手續、所需文件與規費

指示：
1. 直接說明各項監理業務的計算方式、流程與常見費用
2. 明確指出相關繳納或檢驗的時間與地點依據（例如每年5月檢驗）
3. 不提供或要求任何車主個人資料，也不要只給網址。`;

  try {
    const completion = await openai.chat.completions.create({
      model: 'gpt-4o',
      messages: [
        { role: 'system', content: systemPrompt },
        { role: 'user', content: message }
      ],
    });

    const reply = completion.choices[0].message.content;
    res.json({ reply });
  } catch (err) {
    console.error(err);
    res.status(500).json({ error: err.message });
  }
});

const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`🚀 Server listening on http://localhost:${PORT}/public/chat.html`));

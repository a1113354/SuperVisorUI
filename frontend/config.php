<?php
// 只要一次 session 就好
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// 你的 DB 連線（示意）
$db = new mysqli('127.0.0.1','root','','supervisorui');
if ($db->connect_errno) {
    die("DB Error: " . $db->connect_error);
}

define('DB_DSN',  'mysql:host=localhost;dbname=supervisorui;charset=utf8mb4');
define('DB_USER', 'root');
define('DB_PASS', '');


// OpenAI API Key
define('OPENAI_API_KEY', getenv('OPENAI_API_KEY'));

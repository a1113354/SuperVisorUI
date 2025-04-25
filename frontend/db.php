<?php
// db.php
$mysqli = new mysqli('localhost','root','','supervisorui');
if ($mysqli->connect_errno) {
  die('資料庫連線錯誤: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');

<?php
// 参考"https://www.softel.co.jp/blogs/tech/archives/6505"
if (session_status() == PHP_SESSION_NONE) {
    // セッションは有効で、開始していないとき
    session_start();
}

// URL直打ちへの対応(仮)
if (!isset($_SESSION['user_id'])) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER['PHP_SELF']) . '/../index.php');
    exit();
}
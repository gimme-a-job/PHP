<?php

// 参考"https://qiita.com/syatiking2Z/items/67a69b1c5ecaba6a9aff"

// 参考"https://www.softel.co.jp/blogs/tech/archives/6505"
if (session_status() == PHP_SESSION_NONE) {
    // セッションは有効で、開始していないとき
    session_start();
}
$_SESSION = array();
session_destroy();

header("Location: http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER['PHP_SELF']) . '/../index.php');
exit();

?>
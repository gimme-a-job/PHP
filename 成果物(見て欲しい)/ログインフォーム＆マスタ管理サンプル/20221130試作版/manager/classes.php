<?php

// "sample.php"と同内容 ↓

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

require_once(__DIR__ . '/../function/select.php');
require_once(__DIR__ . '/../function/view.php');

$user = selectTB_where(
    TB_NAMES['職員マスタ'],
    '*',
    COL_INFO['職員マスタ']['職員コード']['列名'] . "='" . $_SESSION['user_id'] . "'"
)
    ->fetch();

$class = selectTB_where(
    TB_NAMES['権限マスタ'],
    '*',
    COL_INFO['権限マスタ']['権限コード']['列名'] .
        "='" . $user[COL_INFO['職員マスタ']['権限コード']['列名']] . "'"
)
    ->fetch();


// "sample.php"と同内容 ↑

$classes = selectTB(
    TB_NAMES['権限マスタ'],
    '*'
)
    ->fetchAll();

const COL_STAFF = COL_INFO['職員マスタ'];

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>権限マスタ</title>
</head>

<body>
    <hr>
    <a href="top.php">前のページに戻る</a>
</body>

</html>
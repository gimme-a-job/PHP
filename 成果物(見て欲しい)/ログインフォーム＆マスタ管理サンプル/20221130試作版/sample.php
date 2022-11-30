<?php
// 参考"https://www.softel.co.jp/blogs/tech/archives/6505"
if (session_status() == PHP_SESSION_NONE) {
    // セッションは有効で、開始していないとき
    session_start();
}

// URL直打ちへの対応(仮)
if (!isset($_SESSION['user_id'])) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER['PHP_SELF']) . '/index.php');
    exit();
}

require_once('function/select.php');
require_once('function/view.php');

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


$headers = array(
    '職員コード', '名',
    // 'ミドルネーム', 
    '姓'
);
$keys = array(
    COL_INFO['職員マスタ']['職員コード']['列名'], COL_INFO['職員マスタ']['名']['列名'],
    // COL_INFO['職員マスタ']['ミドルネーム']['列名'],
    COL_INFO['職員マスタ']['姓']['列名']
);
if ($class[COL_INFO['権限マスタ']['生年月日閲覧権限']['列名']] == TRUE) // '=='なのはあえて
{
    array_push($headers, '生年月日');
    array_push($keys, COL_INFO['職員マスタ']['生年月日']['列名']);
}
array_push($headers, '所属名', '県名', '国名', '権限名');
array_push(
    $keys,
    COL_INFO['所属マスタ']['所属名']['列名'],
    COL_INFO['県マスタ']['県名']['列名'],
    COL_INFO['国マスタ']['国名']['列名'],
    COL_INFO['権限マスタ']['権限名']['列名']
);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>サンプル</title>

    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>

    <h1>ようこそ　<?php echo $class[COL_INFO['権限マスタ']['権限名']['列名']] . ' ' . $user[COL_INFO['職員マスタ']['姓']['列名']] . " " .
                    $user[COL_INFO['職員マスタ']['名']['列名']] ?>　さん</h1><br>

    <?php // setTable(array(), selectAllTBs('*')); // print(implode(', ', $keys).'<br>'); // 25-Nov-22 検証用
    setTable($headers, selectAllTBs($keys)); ?><br>
    <br>
    <button type=“button” onclick="location.href='manager/top.php'" style="visibility:
    <?php

    if ($class[COL_INFO['権限マスタ']['マスタ編集権限']['列名']] != true)
        print('hidden');

    ?>">マスタ管理(未完成)</button><br>
    <br><br>
    <a href="./function/logout.php">ログアウト</a>

</body>

</html>
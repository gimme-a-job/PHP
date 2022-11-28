<?php

// "sample.php"と同内容 ↓

session_start();

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
    <title>職員情報マスタ</title>
</head>

<body>
    <form id="input" action="../function/insert.php" name="frm_input" method="post">
        　職員コード　：<input type="text" name="values[職員コード]" size="10"><br><br>
        　パスワード　：<input type="password" name="values[パスワード]" size="10"><br><br>
        　　　姓　　　：<input type="text" name="values[姓]" size="10"><br><br>
        　　　名　　　：<input type="text" name="values[名]" size="10"><br><br>
        　生年月日　：<input type="date" name="values[生年月日]" size="10"><br><br>
        　所属コード　：<input type="text" name="values[所属コード]" size="10"><br><br>
        　権限コード　：<select name="values[権限コード]">
            <?php
            foreach ($classes as $c) {
                print('<option value="' . $c[key2col('権限コード', '権限マスタ')] . '"');
                if ($c[key2col('権限デフォルト', '権限マスタ')] == true) print(' selected');
                print('>' . $c[key2col('権限名', '権限マスタ')] . '</option>');
            }
            ?>
        </select><br><br>
        ログイン失敗回数：<select name="values[ログイン失敗回数]">
            <?php
            for ($i = 0; $i < 5; $i++) {
                print('<option value="' . $i . '"');
                print('>' . $i . '</option>');
            }
            ?>
        </select><br><br>
        最終ログイン失敗日時：<input type="datetime-local" name="values[最終ログイン失敗日時]" size="10"><br><br>
        <input type="submit" value="新規登録">
    </form><br>
    <hr>
    <a href="top.php">前のページに戻る</a>
</body>

</html>
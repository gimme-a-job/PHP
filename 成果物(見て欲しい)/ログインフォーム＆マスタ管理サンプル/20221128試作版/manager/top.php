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

$keys = array('職員マスタ', '国マスタ', '県マスタ', '所属マスタ');
if ($class[COL_INFO['権限マスタ']['権限マスタ参照権限']['列名']] == true) array_push($keys, '権限マスタ');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>マスタ管理</title>
</head>

<body>
    <form name="frm_tb">
    <select name="tb_names" required>

        <?php

        foreach ($keys as $key) print("<option value=" . TB_NAMES[$key] . ">" . $key . "</option>");

        ?>

    </select></form><br>
    <br>
    <p>↓ 本当は ↑ の選択内容に応じて表示を変更したい</p><br>
    <?php
    setTable(array_keys(COL_INFO['職員マスタ']), selectTB(
        TB_NAMES['職員マスタ'],
        '*'
    )
        ->fetchAll())
    ?><br>
    <p>↑ 各行に「編集(updateを行う)」ボタンと「削除」ボタンを追加したい</p><br>
    <br>
    <p>※2022年11月28日現在、職員マスタの「新規登録」のみ動作</p>
    <br><br>
    <button type=“button” onclick="btnRegsister_click()">新規登録</button>　
    <script>
        // 参考"https://itsakura.com/js-selectbox" // JSでの選択値の取り方など
        // 参考"https://www.ipentec.com/document/javascript-get-selectbox-value" // JSでの選択値の取り方
        // 参考"https://qiita.com/shuntaro_tamura/items/99adbe51132e0fb3c9e9" JSでのページ遷移のやり方
        function btnRegsister_click() {
            const tb_name = document.frm_tb.tb_names.value;
            window.location.href = tb_name+".php"; // 通常の遷移
        }
    </script>
    <button type=“button” onclick="">csv入力(未実装)</button>　
    <button type=“button” onclick="">csv出力(未実装)</button><br>
    <br><br>
    <hr>
    <a href="../sample.php">前のページに戻る</a>
</body>

</html>
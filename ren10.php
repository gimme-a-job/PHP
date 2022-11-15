<?php
// "ren08.php"よりコピペ
function setTableHeaders($headers)
{
    print('<tr>');
    foreach ($headers as $header) {
        print('<th>');
        print($header);
        print('</th>');
    }
    print('</tr>');
}   //function setTableHeaders終わり

function setTableData($d)
{

    print('<tr>');
    foreach ($d as $item) {
        print('<td>');
        print($item);
        print('</td>');
    }
    print('</tr>');
}   //function setTableData終わり

function setTable($headers, $data)
{

    // print('<table>');
    print('<table border="10", cellspacing="10", cellpadding="10">');

    setTableHeaders($headers);

    foreach ($data as $d) setTableData($d);

    print('</table>');
}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>練習問題10</title>
</head>

<body>
    <?php
    // ファイルの読み込み
    const filename = 'ren10.txt';
    $contents = file_get_contents(filename);

    // シフトJISからUTF-8に変換
    // "https://uxmilk.jp/14324"より
    $str = mb_convert_encoding($contents, "utf-8", "sjis"); // シフトJISからUTF-8に変換

    // 改行ごとに配列に分ける
    // "https://public-constructor.com/php-file-each-row/"より
    $rows = explode("\n", $str);

    // ','区切りで２次元配列に分ける
    $data = array();
    foreach ($rows as $r) array_push($data, explode(',', $r));

    // テーブル作成
    setTable(array('family_name', 'given_name'), $data);
    ?>
</body>

</html>
<?php
// 
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

function setTableData($data)
{
    print('<tr>');
    foreach ($data as $d) {
        print('<td>');
        print($d);
        print('</td>');
    }
    print('</tr>');
}   //function setTableData終わり

function setTable($headers, $data)
{

    // print('<table>');
    print('<table border="10", cellspacing="10", cellpadding="10">');

    setTableHeaders($headers);

    setTableData($data);

    print('</table>');

}


?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>ren08</title>
</head>



<body>
    <?php

    // "ren06_Calc.php"よりコピペして改変

    const str = "@";

    if (empty($_GET['data'])) {
        echo "データが未入力です";
    // } else if (!strpos($_GET['data'], str)) {
    } else if (strpos($_GET['data'], str)===false) { // "https://www.sejuku.net/blog/25441"より
        echo str . "が含まれていない不正なデータです";
    } else {

        $i = strpos($_GET['data'], str);

        // if (strpos($_GET['data'], str, $i + 1)) {
        if (strpos($_GET['data'], str, $i + 1)!==false) { // "https://www.sejuku.net/blog/25441"より
            echo str . "が２つ以上含まれる不正なデータです";
        } else {
            $strs = explode(str, $_GET['data']);

            setTable(array('ユーザ名', 'ドメイン名'), $strs);
        }
    }



    ?>
    <br>
    <a href="ren08.html">前のページに戻る</a>
</body>

</html>
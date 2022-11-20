<?php
if(!empty($_GET['data'])) // この場合、入力値が'0'だとエラーになる？
{
$contents = $_GET['data'].PHP_EOL;
file_put_contents('ren09.txt', $contents, FILE_APPEND | LOCK_EX);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>練習問題09</title>
</head>
<body>
    <p>以下に入力した文字列がテキストファイルに書き込まれます。</p>
    <br>
    <form action="ren09.php" method="get">
    <input type="text" name="data" size="10"><input type="submit" value="書き込み">
    </form>
</body>
</html>
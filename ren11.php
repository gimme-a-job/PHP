<?php
const filename = 'ren11.txt';

// ファイルの書き込み
if (!empty($_GET['data'])) // この場合、入力値が'0'だとエラーになる？
{
    $data = $_GET['data'] . PHP_EOL;
    file_put_contents(filename, $data, FILE_APPEND | LOCK_EX);
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>練習問題11</title>
</head>

<body>
    <p>コメントを入力して送信ボタンを押してください。</p>
    <p>コメント未入力で送信ボタンを押すとページを更新します。</p>
    <form action="ren11.php" method="get">
        コメント：<input type="text" name="data" size="20"><input type="submit" value="送信">
    </form>
    <hr>
    <?php
    // ファイルの読み込み
    $contents = file_get_contents(filename);
    $contents = nl2br($contents);
    echo $contents;
    ?>
</body>

</html>
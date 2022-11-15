<?php
const filename = 'ren12.txt';
const delimiter = ','; // 区切り文字

// ファイルの書き込み

if (!empty($_GET['comment'])) // この場合、入力値が'0'だとエラーになる？
{
    if (!empty(str_replace(delimiter, '', $_GET['comment']))) // この場合、入力値が'0'だとエラーになる？
    {
        // 名前欄

        // $name;
        // if(empty($_GET['name'])) $name = '名無し';
        // else $name = str_replace(delimiter, '', $_GET['name']); // "https://www.php.net/manual/ja/function.str-replace.php"より

        $name = str_replace(delimiter, '', $_GET['name']); // "https://www.php.net/manual/ja/function.str-replace.php"より;
        if (empty($name)) $name = '名無し';

        // コメント欄
        $comment = str_replace(delimiter, '', $_GET['comment']); // "https://www.php.net/manual/ja/function.str-replace.php"より

        // テキストファイルに','区切りで保存
        $data = PHP_EOL . $name . delimiter . $comment . delimiter . (date("Y/m/d H:i:s"));
        file_put_contents(filename, $data, FILE_APPEND | LOCK_EX);
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>練習問題12</title>
</head>

<body>
    <p>コメントを入力して送信ボタンを押してください。</p>
    <p>コメント未入力で送信ボタンを押すとページを更新します。</p>
    <form action="ren12.php" method="get">
        名前：<input type="text" name="name" size="10"> コメント：<input type="text" name="comment" size="30"><input type="submit" value="送信">
    </form>
    <hr>
    <?php
    // ファイルの読み込み
    $contents = file_get_contents(filename);
    // $contents = nl2br($contents);
    $rows = explode(PHP_EOL, $contents);
    foreach ($rows as $r) {
        $columns = explode(delimiter, $r);
        echo $columns[0] . '「' . $columns[1] . '」' . $columns[2] . '<br>';
        // echo $columns.'<br>'; // 検証用
    }
    ?>
</body>

</html>
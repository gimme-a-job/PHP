<?php
// 参考"https://www.softel.co.jp/blogs/tech/archives/6505"
if (session_status() == PHP_SESSION_NONE) {
    // セッションは有効で、開始していないとき
    session_start();
}

if (isset($_SESSION['user_id'])) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER['PHP_SELF']) . '/sample.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>

    <script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body>
    <br>
    <form id="login" action="./function/auth.php" name="frm_login" method="post">
        職員コード：<input type="text" name="id" size="10"><br><br> パスワード：<input type="password" name="passwd" size="10">　<input type="submit" value="ログイン">
    </form><br>
    <?php
    $msgA = '';
    if (!empty($_GET['msgA'])) $msgA =  $_GET['msgA'];
    $msgB = '';
    if (!empty($_GET['msgB'])) $msgB =  $_GET['msgB'];
    $msgC = '';
    if (!empty($_GET['msgC'])) $msgC =  $_GET['msgC'];
    ?>
    <span style="color: red"><?php echo $msgA; ?></span><br>
    <span style="color: red"><?php echo $msgB; ?></span><br>
    <span style="color: red"><?php echo $msgC; ?></span><br>
    <br>
    <p>URL直打ちへのセッションでの対策も未実装です</p>
    <p>※'Wireshark'などパケットキャプチャソフトで簡単にパスワードなどを抜けるかもしれませんが、現在の知識ではそこまでケアできません…</p>
    <p>※セッションハイジャック等にも未対応です</p>
</body>

</html>
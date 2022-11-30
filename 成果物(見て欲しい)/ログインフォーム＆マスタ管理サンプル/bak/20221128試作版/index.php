<?php
session_start();

if (isset($_SESSION['name'])) {
    header("Location: send.php");
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
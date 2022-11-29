<?php

// require_once('select.php');
require_once(__DIR__.'/select.php');
// require_once(__DIR__.'/../config/config.php');

// 参考"https://blog.apar.jp/php/12373/"

// $user_id    = filter_input(INPUT_POST, $_POST['id']);  // 入力されたユーザーID
// $password   = filter_input(INPUT_POST, $_POST['passwd']); // 入力されたパスワード
$user_id = htmlspecialchars($_POST['id'], ENT_QUOTES); // sanitize
$password = htmlspecialchars($_POST['passwd'], ENT_QUOTES); // sanitize

echo $user_id.'<br>'; // 検証用
echo $password.'<br>'; // 検証用

$hash = selectTB_where(TB_NAMES['職員マスタ'], COL_INFO['職員マスタ']['パスワード']['列名'], COL_INFO['職員マスタ']['職員コード']['列名']." = '".$user_id."'")
->fetch()[COL_INFO['職員マスタ']['パスワード']['列名']];

echo $hash.'echo'.'<br>'; // 検証用
print($hash.'print'.'<br>'); // 検証用

// パスワードの検証
if ( ! password_verify($password, $hash) ) {
    $msgA = 'ユーザーIDまたはパスワードが間違っています';
    $msgB = ''; // まだ決めてない
    $msgC = 'あと'.'回失敗するとロックされます'; // これも未実装
    // 参考'https://www.yamata-pgblog.com/entry/2020/10/18/153234'
    // 参考'https://teratail.com/questions/27761'
    // header("Location: http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER['PHP_SELF']) . '/../index.php?
    // msgA='.$msgA.'&msgB='.$msgB.'&msgC='.$msgC);
    $params = [
        'msgA' => $msgA,
        'msgB' => $msgB,
        'msgC' => $msgC
    ];
    header("Location: http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER['PHP_SELF']) . '/../index.php?'
     . http_build_query($params, '', '&')); // リダイレクト後のURLがダサいが現状一旦これで妥協
    exit();
}

// ログイン認証成功の処理
session_start();
session_regenerate_id(true); // セッションIDをふりなおす
$_SESSION['user_id'] = $user_id; // ユーザーIDをセッション変数にセット

echo 'ログインしました！';

// リダイレクトを実行
// 参考"https://note.com/rottenmarron/n/n4644728f6511"
header("Location: http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER['PHP_SELF']) . "/../sample.php");
// header("Location: ".'../sample.php');
exit();

?>
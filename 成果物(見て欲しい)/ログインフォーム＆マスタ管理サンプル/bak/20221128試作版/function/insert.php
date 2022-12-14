<?php

// 参考 "https://cbc-study.com/training/advanced/class1"

require_once('../config/config.php');  /* DB接続用のファイルを読み込む */

const TB_NAME = TB_NAMES['職員マスタ'];
$col_names = implode(",", array_map(
  function ($key) {
    return key2col($key, '職員マスタ');
  },
  array_keys($_POST['values'])
));
$values = vals2str($_POST['values'], '職員マスタ');

/* 新規氏名+性別をデータベースへ登録 */
try {
  $sql = "INSERT INTO " . TB_NAME . " ("
    . $col_names .
    ") VALUES ("
    . $values .
    ")";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  /* ↓一つ前のページのパスを指定し、処理が終わったらそこに戻る */
  header('location:' . $_SERVER["HTTP_REFERER"]);
} catch (PDOException $e) {
  echo $e->getMessage();
}

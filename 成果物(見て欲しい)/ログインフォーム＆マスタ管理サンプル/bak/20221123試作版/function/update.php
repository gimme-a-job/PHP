<?php

// 参考 "https://cbc-study.com/training/advanced/class1"

require_once('../config/config.php');  /* DB接続用のファイルを読み込む */

/* Ajaxを経由してPOST受信した「座標」の変数をDBに登録 */
if(!empty($_POST['left'])){
  try{
    $sql  = '
            UPDATE
              sortable
            SET
              left_x = :LEFT,
              top_y  = :TOP
            WHERE
              id = :NUMBER
            ';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':LEFT'  , (int)$_POST['left'], PDO::PARAM_INT);
    $stmt->bindValue(':TOP'   , (int)$_POST['top'],  PDO::PARAM_INT);
    $stmt->bindValue(':NUMBER', (int)$_POST['id'],   PDO::PARAM_INT);
    $stmt->execute();

    /* ↓一つ前のページのパスを指定し、処理が終わったらそこに戻る */
    header('location:'.$_SERVER["HTTP_REFERER"]);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

?>
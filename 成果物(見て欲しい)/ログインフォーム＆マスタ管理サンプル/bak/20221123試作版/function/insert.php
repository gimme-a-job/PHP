<?php

// 参考 "https://cbc-study.com/training/advanced/class1"

require_once('../config/config.php');  /* DB接続用のファイルを読み込む */

/* 新規氏名+性別をデータベースへ登録 */
if(!empty($_POST['inputName'])){
  try{
    $sql = '
            INSERT INTO sortable(
              name,
              gender_id
            )
            VALUES(
              :ONAMAE,
              :GENDER
            )
            ';
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':ONAMAE', $_POST['inputName'],   PDO::PARAM_STR);
    $stmt->bindValue(':GENDER', $_POST['inputGender'], PDO::PARAM_INT);
    $stmt->execute();

    /* ↓一つ前のページのパスを指定し、処理が終わったらそこに戻る */
    header('location:'.$_SERVER["HTTP_REFERER"]);
  } catch (PDOException $e) {
    echo $e->getMessage();
  }
}

?>
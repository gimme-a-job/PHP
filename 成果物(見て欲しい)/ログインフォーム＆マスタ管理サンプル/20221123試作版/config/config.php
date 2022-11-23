<?php

// 参考 "https://cbc-study.com/training/advanced/class1"
// 参考 "https://nagablog.info/php-pdo-create-db/"

/* データベース設定 */
define('DB_NAME', 'sample_21nov22');
define('DB_DNS', 'mysql:host=localhost; dbname=' . DB_NAME . ';');
define('DB_USER', 'root');
define('DB_PASSWD', ''); // 環境に合わせて変更すべし

// テーブル名配列
// テーブル名をキーで呼ぶことで、後からテーブル名に変更があった際にここだけ変えればよくなるのが狙い
const TB_NAMES = array(
  '職員マスタ' => 'staff',
  '国マスタ' => 'countries',
  '県マスタ' => 'prefs',
  '所属マスタ' => 'branches',
  '権限マスタ' => 'classes'
);

// カラム名などの配列
// 連想配列が混ざった配列の入れ子なのでかなり分かりづらく、汎用性も低いかも
const COL_INFO = array(
  '職員マスタ' => array(
    '職員コード' => array(
      '列名' => 'code_staff',
      'プロパティ' => 'varchar(5) primary key'
    ),
    'パスワード' => array(
      '列名' => 'passawd',
      'プロパティ' => 'text'
    ),
    '名' => array(
      '列名' => 'given_nm',
      'プロパティ' => 'text not null'
    ),
    '姓' => array(
      '列名' => 'sur_nm',
      'プロパティ' => 'text'
    ),
    '生年月日' => array(
      '列名' => 'birth_date',
      'プロパティ' => 'date'
    ),
    '所属コード' => array(
      '列名' => 'code_branch',
      'プロパティ' => 'varchar(9)'
    ),
    '権限コード' => array(
      '列名' => 'class',
      'プロパティ' => 'tinyint'
    ),
    'ログイン失敗回数' => array(
      '列名' => 'cnt_auth_fail',
      'プロパティ' => 'tinyint default 0'
    ),
    '最終ログイン失敗日時' => array(
      '列名' => 'limit_reached',
      'プロパティ' => 'datetime'
    )
  ),
  '国マスタ' => array(
    '国コード' => array(
      '列名' => 'code',
      'プロパティ' => 'varchar(3) primary key'
    ),
    '国名' => array(
      '列名' => 'name_country',
      'プロパティ' => 'text'
    )
  ),
  '県マスタ' => array(
    '県コード' => array(
      '列名' => 'code',
      'プロパティ' => 'varchar(6) primary key'
    ),
    '県名' => array(
      '列名' => 'name_pref',
      'プロパティ' => 'text'
    )
  ),
  '所属マスタ' => array(
    '所属コード' => array(
      '列名' => 'code',
      'プロパティ' => 'varchar(9) primary key'
    ),
    '所属名' => array(
      '列名' => 'name_branch',
      'プロパティ' => 'text'
    )
  ),
  '権限マスタ' => array(
    '権限コード' => array( // 値
      '列名' => 'val',
      'プロパティ' => 'tinyint primary key'
    ),
    '権限名' => array( // 職名
      '列名' => 'name_class',
      'プロパティ' => 'text not null'
    ),
    'マスタ編集権限' => array( // マスタ編集画面にアクセスできるかどうか
      '列名' => 'flg_manage',
      'プロパティ' => 'tinyint(1) default 0'
    ),
    '生年月日閲覧権限' => array( // 社員の誕生日を閲覧可能かどうか
      '列名' => 'flg_birthdate',
      'プロパティ' => 'tinyint(1) default 0'
    ),
    '権限デフォルト' => array( // 新社員登録時にデフォルトに設定する場合にチェック
      '列名' => 'flg_default',
      'プロパティ' => 'tinyint(1) default 0'
    ),
    '権限編集可能フラグ' => array( // 権限マネージャで権限を変更できるかどうかのフラグ、最高権限者の権限を弄られると困るため
      '列名' => 'flg_editable',
      'プロパティ' => 'tinyint(1) default 1'
    )
  )
);

/* データベース作成済みかチェック */
createDB(); // 接続してまた切ってを行っているためムダかも

/* 各テーブル作成済みかチェック */
createTB(); // 接続してまた切ってを行っているためムダかも

/* データベースへ接続
======================================================== */
try {
  //データベースを開く処理（PDOインスタンスを生成 $dbh）
  $dbh = new PDO(DB_DNS, DB_USER, DB_PASSWD);
  // print("<p>データベース「" . DB_NAME . "」に接続しました</p>"); // 検証用
} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}

// DB未作成の場合作成する
function createDB()
{
  try {
    // DB接続
    $pdo = new PDO(
      // ホスト名
      'mysql:host=localhost;',
      // ユーザー名
      DB_USER,
      // パスワード
      DB_PASSWD
    );

    // SQL文をセット
    $stmt = $pdo->prepare('CREATE DATABASE IF NOT EXISTS ' . DB_NAME);

    // SQL実行
    $stmt->execute();

    // print("<p>データベース「" . DB_NAME . "」を確認、または作成されました。</p>"); // 検証用
  } catch (PDOException $e) {
    // エラー発生
    echo $e->getMessage();
  } finally {
    // DB接続を閉じる
    $pdo = null;
  }
}

// 各テーブルが未作成の場合作成する
function createTB()
{

  try {
    // DB接続
    $pdo = new PDO(
      // ホスト名
      DB_DNS,
      // ユーザー名
      DB_USER,
      // パスワード
      DB_PASSWD
    );
    // print("<p>データベース「" . DB_NAME . "」に接続しました</p>"); // 検証用

    foreach (TB_NAMES as $key => $tb_name) {

      // SQL文作成処理
      $sql = 'CREATE TABLE IF NOT EXISTS ' . $tb_name . ' (';
      foreach (COL_INFO[$key] as $colkey => $col) {
        $sql = $sql . $col['列名'] . ' ' . $col['プロパティ'];
        // 参考"https://qiita.com/_hiro_dev/items/fc48722eb518c6382895"
        if ($colkey !== array_key_last(COL_INFO[$key])) {
          // 最後以外
          $sql = $sql.',';
        } else {
          // 最後(終端処理)
          $sql = $sql.')';
        }
      }

      // SQL文をセット
      $stmt = $pdo->prepare($sql);

      // SQL実行
      $stmt->execute();

      // print("<p>テーブル「" . $tb_name . "」を確認、または作成しました</p>"); // 検証用
    }
  } catch (PDOException $e) {
    // エラー発生
    echo $e->getMessage();
  } finally {
    // DB接続を閉じる
    $pdo = null;
  }
}

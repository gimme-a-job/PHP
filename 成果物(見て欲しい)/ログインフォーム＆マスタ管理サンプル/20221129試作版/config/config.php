<?php

// // 参考"https://www.softel.co.jp/blogs/tech/archives/6505"
// if (session_status() == PHP_SESSION_NONE) {
//   // セッションは有効で、開始していないとき
//   session_start();
// }

// // URL直打ちへの対応(仮)
// if (!isset($_SESSION['user_id'])) {
//   header("Location: http://" . $_SERVER["HTTP_HOST"] . dirname($_SERVER['PHP_SELF']) . '/../index.php');
//   exit();
// }

// 参考 "https://cbc-study.com/training/advanced/class1"
// 参考 "https://nagablog.info/php-pdo-create-db/"

/* データベース設定 */

use function PHPSTORM_META\type;

define('DB_NAME', 'sample_21nov22');
define('DB_DNS', 'mysql:host=localhost; dbname=' . DB_NAME . ';');
define('DB_USER', 'root');
define('DB_PASSWD', 'root'); // 環境に合わせて変更すべし

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
      'プロパティ' => 'varchar(5) primary key',
      '型' => 'str'
    ),
    'パスワード' => array(
      '列名' => 'passwd',
      'プロパティ' => 'text',
      '型' => 'password'
    ),
    '名' => array(
      '列名' => 'given_nm',
      'プロパティ' => 'text not null',
      '型' => 'str'
    ),
    'ミドルネーム' => array(
      '列名' => 'middle_nm',
      'プロパティ' => 'text',
      '型' => 'str'
    ),
    '姓' => array(
      '列名' => 'sur_nm',
      'プロパティ' => 'text',
      '型' => 'str'
    ),
    '生年月日' => array(
      '列名' => 'birth_date',
      'プロパティ' => 'date',
      '型' => 'str'
    ),
    '所属コード' => array(
      '列名' => 'code_branch',
      'プロパティ' => 'varchar(9)',
      '型' => 'str'
    ),
    '権限コード' => array(
      '列名' => 'class',
      'プロパティ' => 'tinyint',
      '型' => 'int'
    ),
    'ログイン失敗回数' => array(
      '列名' => 'cnt_auth_fail',
      'プロパティ' => 'tinyint default 0',
      '型' => 'int'
    ),
    '最終ログイン失敗日時' => array( // ここを変えたら"staff.php"も変える
      '列名' => 'limit_reached',
      'プロパティ' => 'datetime',
      '型' => 'str'
    )
  ),
  '国マスタ' => array(
    '国コード' => array(
      '列名' => 'code',
      'プロパティ' => 'varchar(3) primary key',
      '型' => 'str'
    ),
    '国名' => array(
      '列名' => 'name_country',
      'プロパティ' => 'text',
      '型' => 'str'
    )
  ),
  '県マスタ' => array(
    '県コード' => array(
      '列名' => 'code',
      'プロパティ' => 'varchar(6) primary key',
      '型' => 'str'
    ),
    '県名' => array(
      '列名' => 'name_pref',
      'プロパティ' => 'text',
      '型' => 'str'
    )
  ),
  '所属マスタ' => array(
    '所属コード' => array(
      '列名' => 'code',
      'プロパティ' => 'varchar(9) primary key',
      '型' => 'str'
    ),
    '所属名' => array(
      '列名' => 'name_branch',
      'プロパティ' => 'text',
      '型' => 'str'
    )
  ),
  '権限マスタ' => array(
    '権限コード' => array( // 値
      '列名' => 'val',
      'プロパティ' => 'tinyint primary key',
      '型' => 'str'
    ),
    '権限名' => array( // 職名
      '列名' => 'name_class',
      'プロパティ' => 'text not null',
      '型' => 'str'
    ),
    '生年月日閲覧権限' => array( // 社員の誕生日を閲覧可能かどうか
      '列名' => 'flg_birthdate',
      'プロパティ' => 'tinyint(1) default 0',
      '型' => 'int'
    ),
    'マスタ編集権限' => array( // マスタ編集画面にアクセスできるかどうか
      '列名' => 'flg_manage',
      'プロパティ' => 'tinyint(1) default 0',
      '型' => 'int'
    ),
    '権限マスタ参照権限' => array( // 権限マスタを編集可能かどうか
      '列名' => 'flg_classes',
      'プロパティ' => 'tinyint(1) default 0',
      '型' => 'int'
    ),
    '権限デフォルト' => array( // 新社員登録時にデフォルトに設定する場合にチェック
      '列名' => 'flg_default',
      'プロパティ' => 'tinyint(1) default 0',
      '型' => 'int'
    ),
    '各権限チェック変更可能フラグ' => array( // 権限マネージャで権限を変更できるかどうかのフラグ、最高権限者の権限を弄られると困るため
      '列名' => 'flg_editable',
      'プロパティ' => 'tinyint(1) default 1',
      '型' => 'int'
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
  $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC); // 25-Nov-22 追加 // 参考"https://stackoverflow.com/questions/44306979/php-pdo-select-query-returns-double-values" // 参考"https://stackoverflow.com/questions/17534370/php-pdo-retrieves-duplicate-data"
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

    foreach (TB_NAMES as $key => $tb_key) {

      // SQL文作成処理
      $sql = 'CREATE TABLE IF NOT EXISTS ' . $tb_key . ' (';
      foreach (COL_INFO[$key] as $colkey => $col) {
        $sql = $sql . $col['列名'] . ' ' . $col['プロパティ'];
        // 参考"https://qiita.com/_hiro_dev/items/fc48722eb518c6382895"
        if ($colkey !== array_key_last(COL_INFO[$key])) {
          // 最後以外
          $sql = $sql . ',';
        } else {
          // 最後(終端処理)
          $sql = $sql . ')';
        }
      }

      // SQL文をセット
      $stmt = $pdo->prepare($sql);

      // SQL実行
      $stmt->execute();

      // print("<p>テーブル「" . $tb_key . "」を確認、または作成しました</p>"); // 検証用
    }
  } catch (PDOException $e) {
    // エラー発生
    echo $e->getMessage();
  } finally {
    // DB接続を閉じる
    $pdo = null;
  }


  function vals2str($array, $tb_key)
  {

    $str = '';

    foreach ($array as $key => $value) {
      $type = COL_INFO[$tb_key][$key]['型'];
      if ($type == 'int') $str = $str . $value;
      elseif ($type == 'text') $str = $str . "'" . $value . "'";
      elseif ($type == 'password') $str = $str . "'" . password_hash($value, PASSWORD_DEFAULT) . "'";
      else $str = $str . "'" . $value . "'"; // 本当はここには飛ばない予定

      // 参考"https://qiita.com/_hiro_dev/items/fc48722eb518c6382895"
      if ($key !== array_key_last($array)) {
        // 最後以外
        $str = $str . ',';
      }
    }

    return $str;
  }

  function key2col($key, $tb_key)
  {
    return COL_INFO[$tb_key][$key]['列名'];
  }
}

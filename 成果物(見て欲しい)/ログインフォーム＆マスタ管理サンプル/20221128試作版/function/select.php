<?php

// 参考 "https://cbc-study.com/training/advanced/class1"
// 参考 "https://www.flatflag.nir87.com/select-932"

// require_once('../config/config.php');  /* DB接続用のファイルを読み込む */
require_once(__DIR__.'/../config/config.php');

// 1つのテーブルについてのみ扱う場合
function selectTB($tb_name, $col_names)
{

    global $dbh;

    try {

        // SELECT文を変数に格納
        // $sql = "SELECT ".implode(',', $col_names)." FROM ".$tb_name;
        $sql = "SELECT " . cols2str($col_names) . " FROM " . $tb_name;

        // SQLステートメントを実行し、結果を変数に格納
        $stmt = $dbh->query($sql);

        return $stmt;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

function selectTB_where($tb_name, $col_names, $where)
{
    try {

        global $dbh;

        // SELECT文を変数に格納
        $sql = "SELECT " . cols2str($col_names) . " FROM " . $tb_name . " WHERE " . $where;

        // SQLステートメントを実行し、結果を変数に格納
        $stmt = $dbh->query($sql);

        return $stmt;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// 全てのテーブルを連結して返す処理
function selectAllTBs($col_names)
{

    try {

        global $dbh;


        // print(cols2str($col_names).'<br>'); // 25-Nov-22 検証用

        // SELECT文を変数に格納
        // $sql = "SELECT " . implode(',', $col_names) . " FROM " . TB_NAMES['職員'] . " as s " . 
        $sql = "SELECT " . cols2str($col_names) . " FROM " . TB_NAMES['職員マスタ'] . " as s " .
            " LEFT OUTER JOIN " . TB_NAMES['所属マスタ'] . " as b ON s." . COL_INFO['職員マスタ']['所属コード']['列名']  . " = b." . COL_INFO['所属マスタ']['所属コード']['列名'] .
            " LEFT OUTER JOIN " . TB_NAMES['県マスタ'] . " as p ON LEFT(s." . COL_INFO['職員マスタ']['所属コード']['列名']  . ", 6) = p." . COL_INFO['県マスタ']['県コード']['列名'] .
            " LEFT OUTER JOIN " . TB_NAMES['国マスタ'] . " as c ON LEFT(s." . COL_INFO['職員マスタ']['所属コード']['列名']  . ", 3) = c." . COL_INFO['国マスタ']['国コード']['列名'] .
            " LEFT OUTER JOIN " . TB_NAMES['権限マスタ'] . " as cls ON s." . COL_INFO['職員マスタ']['権限コード']['列名']  . " = cls." . COL_INFO['権限マスタ']['権限コード']['列名'];

        // SQLステートメントを実行し、結果を変数に格納
        $stmt = $dbh->query($sql);

        // foreach($stmt as $row){ foreach($row as $col) print($col.', '); } // 25-Nov-22 検証用

        return $stmt;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

// 配列を','区切りで連結する処理
// implodeでオッケーだった⇒配列以外がエラーになるのでやっぱり使うか
function cols2str($col_names)
{
    $str = '';

    if (is_array($col_names)) {
        foreach ($col_names as $key => $col_name) {
            $str = $str . $col_name;
            // 参考"https://qiita.com/_hiro_dev/items/fc48722eb518c6382895"
            if ($key !== array_key_last($col_names)) {
                // 最後以外
                $str = $str . ',';
            }
        }
    } else $str = $col_names;


    // print($str); // 25-Nov-22 検証用
    return $str;
}

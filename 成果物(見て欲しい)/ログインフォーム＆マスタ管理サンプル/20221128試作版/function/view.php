<?php
function setTableHeaders($headers)
{
    print('<tr>');
    foreach ($headers as $header) {
        print('<th>');
        print($header);
        print('</th>');
    }
    print('</tr>');
}   //function setTableHeaders終わり

function setTableData($d)
{

    print('<tr>');
    foreach ($d as $item) {
        // print('<td>');
        print('<td nowrap>');
        print($item);
        print('</td>');
    }
    print('</tr>');
}   //function setTableData終わり

function setTable($headers, $data)
{

    // print('<table>');
    print('<table border="10", cellspacing="10", cellpadding="10">');
    // print('<table border="10">');
    // print('<table border="10", cellspadding="10">');

    setTableHeaders($headers);

    // foreach($data as $d){ foreach($d as $item) print($item.', '); } // 25-Nov-22 検証用
    foreach ($data as $d) setTableData($d);

    print('</table>');
}


?>
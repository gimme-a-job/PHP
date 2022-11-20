<body>



<?php

$tableHeaders = array('西暦', '和暦', '満年齢');
const meiji = 1868;
const taisho = 1912;
const showa = 1926;
const heisei = 1989;
const reiwa = 2019;

print('<table border="10", cellspacing="10", cellpadding="10"');

print('<tr>');

for($i=0; $i<count($tableHeaders); $i++)
{
    print('<th>');
    print($tableHeaders[$i]);
    print('</th>');
}

print('</tr>');

for($i=1868; $i<=date("Y"); $i++)
{
    print('<tr>');

    print('<td>');
    print("{$i}年");
    print('</td>');

    print('<td>');
    if($i==meiji) print("明治元年");
    else if ($i<taisho) print("明治".($i-meiji+1)."年");
    else if ($i==taisho) print("明治45年、大正元年");
    else if ($i<showa) print("大正".($i-taisho+1)."年");
    else if ($i==showa) print("大正15年、昭和元年");
    else if ($i<heisei) print("昭和".($i-showa+1)."年");
    else if ($i==heisei) print("昭和64年、平成元年");
    else if ($i<reiwa) print("平成".($i-heisei+1)."年");
    else if ($i==reiwa) print("平成31年、令和元年");
    else  print("令和".($i-reiwa+1)."年");
    print('</td>');

    print('<td>');
    print((date("Y")-$i)."歳");
    print('</td>');

    print('</tr>');
}

print('</table>');


?>

</body>
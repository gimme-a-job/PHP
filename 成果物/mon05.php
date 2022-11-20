<body>
    <h2>現在の日時と曜日、時刻を表示</h2>
    <hr>
    <?php
        //date関数を用いて現在の曜日（数値）を代入
        $num_week=date("w");
        //曜日の文字データを配列に格納
        $week=array("日","月","火","水","木","金","土");
        //先の変数を使用して各曜日の現在日時を出力
        print(date("Y年m月d日({$week[$num_week]}) H時i分s秒")."<br>");
    ?>
</body>
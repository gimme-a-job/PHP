<body>


    <header>
        <div class="container">
            <h1>表示した時間(秒数)によって異なる画像を表示します</h1>
        </div><!-- /.container -->
    </header>

    <main>
        <div class="container">
            <section>
                <!-- 必要であればここにHTMLを追記 -->
                <div id="Tables"></div>

                <hr>

                <?php

                $week = array('日', '月', '火', '水', '木', '金', '土');

                echo (date("Y年m月d日({$week[date("w")]}) H時i分s秒") . "<br>");

                echo ('<img src="img/Penguins.jpg" alt="Penguins"><br>');

                ?>

            </section>
        </div><!-- /.container -->
    </main>



    <!-- JavaScriptのファイルを読み込む -->
    <script src="../js/_common/scripts/jquery-3.4.1.min.js"></script>
    <script src="script.js"></script>

</body>
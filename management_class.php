<?php

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>出欠れんらくん</title>
    <link rel="stylesheet" href="css/management_class.css">
</head>
<body>
    <div class="button">
        <div class="back_button">
            <div class="a_back_button">
                <a href="index.php" style="text-decoration:none">トップページに戻る</a>
            </div>
        </div>

        <div class="login_button">
            <div class="a_login_button">
                <a href="#" style="text-decoration:none">保育士ログイン中</a>
            </div>
        </div>
    </div>
    <h3>園児出欠一覧 クラス選択画面</h3>
    <h3>本日の日付： <tr>  <td><?= date('Y/m/d'); ?></td></tr></h3>
 

    <div class="table-content">
        <div class="select_class">
            <table border="1">
            <th>クラス</th>
                <tr>
                    <td><a href="./management.php?class=ひまわり" name="class">ひまわり</a></td>
                </tr>
                <tr>
                    <td><a href="./management.php?class=ばら" name="class">ばら</a></td>
                </tr>
                <tr>
                    <td><a href="./management.php?class=たんぽぽ" name="class">たんぽぽ</a></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
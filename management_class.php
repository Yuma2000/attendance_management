<?php

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>一覧</title>
    <link rel="stylesheet" href="css/management_.css">
</head>
<body>
    <h3>生徒出欠管理 クラス選択画面</h3>
    <h3>本日の日付： <tr>  <td><?= date('Y/m/d'); ?></td></tr></h3>

    <div class="table-content">


        <div class="yet">
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
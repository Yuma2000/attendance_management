<?php 

    require_once('./database.php');

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>一覧</title>
</head>

<?php
    //出席者と欠席者を取得
    //データベースの中から，状態
    try{
        $stmt = $db->prepare("select status from record where =?");


    // SQL実行
    $stmt->execute();

    //取得したのを出力
    foreach ($stmt as $row) {
        var_dump($row);
    }
    }catch (PDOException $e) {
        // エラー発生
        echo $e->getMessage();
     
    }

    // foreach($rows as $row){
    $row['name1'] = 'ここに出席者一覧';
    $row['name2'] = 'ここは欠席者';
?>

<body>
    <h3>管理画面</h3>
    <table border="1">
    <tr><th>出席</th></tr>
    <tr><td>
        <?php print($row['name1']) ?>
    </td></tr>

    <tr><th>欠席</th></tr>
    <tr><td>
        <?php print($row['name2']) ?>
    </td></tr>

    </table>    

</body>
</html>

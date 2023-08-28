<?php 

    require_once('./database.php');

?>



<?php
    // try {
 
    //     // 接続処理
    //     $db_user = "sample"; //ユーザー名
    //     $db_pass = "password"; //パスワード
    //     $db_host = "localhost"; //ホスト名
    //     $db_name = "attendancedb"; //データベース名
    //     $db_type = "mysql"; //データベースの種類

    //     //DSN（接続のための決まった情報を決まった順序に組み立てた文字列のこと）の組み立て
    //     $dsn = "$db_type:host=$db_host;dbname=$db_name;charset=utf8";
    //     try{
    //         //MySQLに接続
    //         $pdo = new PDO($dsn, $db_user, $db_pass);
    //         $pdo->setAttribute(PDO::ATTR_ERRMODE,
    //                 PDO::ERRMODE_EXCEPTION);
    
    //         $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //         //print "接続しました...<br>";
    //     }catch(PDOException $Exception){
    //         die('接続エラー:'.$Exception->getMessage());
    //     }
 
    //     // SELECT文を発行
    //     $sql = "SELECT * FROM inputtable";
    //     $stmt = $pdo->prepare($sql);
    //     $stmt->execute();
    //     $rows = $stmt->fetchAll(); // 全てのレコードを取得
 
    //     // 接続切断
    //     $pdo = null;
 
    // } catch (PDOException $e) {
    //     print $e->getMessage() . "<br/>";
    //     die();
    // }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>一覧</title>
</head>
<body>
    <h3>管理画面</h3>
    <table border="1">
        <tr>
            <th>生徒名</th>
            <th>出欠状態</th>
            <th>選択</th>
        </tr>
 
<?php

    // foreach($rows as $row){
?>
        <tr>
            <td><?php print($row['name']) ?></td>
            <td><?php if($row['type']==1){print '出席';}else{print '欠席';} ?></td>
        
            
            <td><a href="response.php?id=<?php print($row['id']) ?>" name="sentaku"><?php print($row['name']) ?>さんを選択</a></td>
        </tr>
<?php
    // }
?>
    </table>
    


</body>
</html>

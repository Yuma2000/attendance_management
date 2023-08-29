<?php
    try {
        $db_user = "sample";
        $db_pass = "password";
        $db_host = "localhost";
        $db_name = "attendance_managementdb";
        $db_type = "mysql";

        //DSN（接続のための決まった情報を決まった順序に組み立てた文字列のこと）の組み立て
        $dsn = "$db_type:host=$db_host;dbname=$db_name;charset=utf8";
        try{
            //MySQLに接続
            $pdo = new PDO($dsn, $db_user, $db_pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION);

            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $Exception) {
            die('接続エラー:'.$Exception->getMessage());
        }

        // SELECT文を発行
        $sql = "SELECT * FROM children";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(); // 全てのレコードを取得
 
        // 接続切断
        $pdo = null;
    } catch (PDOException $e) {
        print $e->getMessage() . "<br/>";
        die();
    }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>園児一覧</title>
    <link rel="stylesheet" href="css/selectchild.css">
</head>
<body>
    <h3>園児一覧</h3>
    <table>
        <tr>
            <th>名前</th>
        </tr>
        <?php foreach($rows as $row): ?>
            <tr>
                <td><a href="childdetail.php?id=<?php echo $row['id'] ?>"><?php echo $row['name'] ?></a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

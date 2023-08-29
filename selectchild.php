<?php

require_once 'vendor/autoload.php'; // Composer のオートロードファイルを読み込む
use Dotenv\Dotenv;

// .env ファイルを読み込む
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    // 接続処理
    $db_user = $_ENV['DB_USER']; //ユーザー名
    $db_pass = $_ENV['DB_PASSWORD']; //パスワード
    $db_host = $_ENV['DB_HOST']; //ホスト名
    $db_name = $_ENV['DB_NAME']; //データベース名
    $db_type = $_ENV['DB_TYPE']; //データベースの種類

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

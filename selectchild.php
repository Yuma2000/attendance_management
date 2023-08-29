<?php
    require_once 'database.php';
    require_once 'vendor/autoload.php'; // Composer のオートロードファイルを読み込む
    use Dotenv\Dotenv;

    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $database = new Database();
    // childrenテーブルの全カラムの値を取得
    $rows = $database->children();
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

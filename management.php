<?php 
require_once 'vendor/autoload.php'; // Composer のオートロードファイルを読み込む
use Dotenv\Dotenv;

// .env ファイルを読み込む
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once('./database.php');

$database = new Database();
$records = $database -> all_records();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>一覧</title>
    <link rel="stylesheet" href="css/management.css">
</head>
<body>
    <h3>管理画面</h3>
    <table border="1">
        <tr>
            <th>日付</th>
            <th>生徒名</th>
            <th>出欠状態</th>
        </tr>
 
<?php foreach($records as $record){ ?>
        <tr>
            <td><?= date('Y/m/d', strtotime($record['date'])); ?></td>
            <td><a href="response.php?id=<?php print($record['child_id']) ?>" name="sentaku"><?php print($record['child_name']) ?></a></td>
            <td><?php if($record['status']==1){print '欠席';}else{print '出席';} ?></td>
        </tr>
<?php } ?>
    </table>
    


</body>
</html>

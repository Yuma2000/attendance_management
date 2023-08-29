<?php 
    require_once 'vendor/autoload.php'; // Composer のオートロードファイルを読み込む
    use Dotenv\Dotenv;

    // .env ファイルを読み込む
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    require_once('./database.php');

    $database = new Database();
    // recordsテーブルのchild_idからその園児の出欠記録データとchildrenテーブルのnameカラムの値を取得
    $records = $database -> find((int)$_GET['id']);
    // // var_dump($records);
?>
 
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>一覧</title>
    <link rel="stylesheet" href="css/response.css">
</head>
<body>
    <h3>返信画面</h3>
    <table border="1">
        <tr>
            <th>園児名</th>
            <th>日付</th>
            <th>出欠</th>
            <th>欠席理由</th>
            <th>返信</th>
        </tr>

        <?php foreach($records as $record){ ?>
        <tr>
            <td><?= $record['child_name']; ?></td>
            <td><?= date('Y/m/d', strtotime($record['date'])); ?></td>
            
            
            <td><?php if ($record['status'] == 2){
                    print '欠席';
                }else{print '出席';}?></td>
            <td><?= $record['absence_reason']; ?></td>
            
            <td><a href="reply.php?id=<?php $record['id'] ?>">返信</a></td>
        </tr>
        <?php } ?>
    </table>
    <div class="return_managrment">
    <a href="management.php">管理画面に戻る</a>
    </div>
    
</body>
</html>

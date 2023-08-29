<?php 
    require_once 'vendor/autoload.php'; // Composer のオートロードファイルを読み込む
    use Dotenv\Dotenv;

    // .env ファイルを読み込む
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    require_once('./database.php');

    if(empty($records)){
        $database = new Database();
        // recordsテーブルのchild_idからその園児の出欠記録データとchildrenテーブルのnameカラムの値を取得
        $records = $database -> find((int)$_GET['id']);
    }
    // var_dump($records);
?>
 
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>一覧</title>
    <link rel="stylesheet" href="css/response.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
    <h3>出欠の詳細</h3>
    <table>
        <tr>
            <th>園児名</th>
            <th>日付</th>
            <th>出欠</th>
            <th>欠席理由</th>
            <th>欠席に対する返信</th>
            <th></th>
        </tr>

        <?php foreach($records as $index => $record){ ?>
        <tr>
            <td><?= $record['child_name']; ?></td>
            <td><?= date('Y/m/d', strtotime($record['date'])); ?></td>
            
            
            <td><?php if ($record['status'] == 2){
                    echo '<i class="fas fa-times fa-2x" style="color: #ff4d4d;"></i>';
                }else{echo '<i class="far fa-circle fa-2x" style="color: #62f973;"></i>';}?></td>
            <td><?= $record['absence_reason']; ?></td>
            <td><?= $record['reply_content'] ?><br><?= $record['childminder_name'] ?></td>

            <?php if($record['status'] == 2 && $index === 0): ?>
                <td>
                    <?php if(empty($record['reply_content'])): ?>
                        <a href="./reply.php?id=<?= $record['id']; ?>"><button>返信</button></a>
                    <?php else: ?>
                        <a href="./reply_edit.php?id=<?= $record['id']; ?>"><button>編集</button></a>
                    <?php endif ?>
                </td>
            <?php endif ?>
        </tr>
        <?php if($index === 0): ?>
    </table>
            <div class="return_managrment">
                <a href="management.php">管理画面に戻る</a>
            </div>
            <h3>過去の出席履歴</h3>
    <table>
        <tr>
            <th>園児名</th>
            <th>日付</th>
            <th>出欠</th>
            <th>欠席理由</th>
            <th>欠席に対する返信</th>
        </tr>
        <?php endif ?>
        <?php } ?>
    </table>

</body>
</html>

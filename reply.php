<?php

require_once 'vendor/autoload.php'; // Composer のオートロードファイルを読み込む
use Dotenv\Dotenv;

// .env ファイルを読み込む
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once('./database.php');

if(!empty($_POST)){
    if(empty($_POST['reply_content'])){
        exit('<p>返信内容が入力されていません</p>'.'<br>'.'<a href="./management.php">管理画面に戻る</a>');
    }

    $database = new Database();
    $records = $database->store_reply($_POST);

    header('Location: ./management.php');
    exit;
}

$database = new Database();
$record = $database -> find_record((int)$_GET['id']);
// var_dump($record);

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>返信</title>
</head>
<body>

    <h3><?= $record['child_name'] ?>さんへの返信</h3>
        <table border="1">
            <tr>
                <th>園児名</th>
                <th>日付</th>
                <th>出欠</th>
                <th>欠席理由</th>
            </tr>

            <tr>
                <th><?= $record['child_name'] ?></th>
                <th><?= $record['date'] ?></th>
                <th><?php if($record['status'] == 2){ print '欠席'; }  ?></th>
                <th><?= $record['absence_reason'] ?></th>
            </tr>
        </table>
        <div>
            <form method="POST" action="">
                <input type="hidden" name="child_id" value="<?= $record['child_id']; ?>">
                <input type="hidden" name="record_id" value="<?= $record['id']; ?>">
                <textarea name="reply_content" rows="4" cols="50" placeholder="返信内容を入力してください"></textarea><br>
                <div>
                    <label>返信者</label>
                    <select name="minder">
                        <option value="1">鈴木 たけし</option>
                        <option value="2">田村 えりこ</option>
                        <option value="3">中野 ゆかり</option>
                        <option value="4">山田 みさき</option>
                    </select>
                </div>
                <input type="submit" value="返信">
            </form>
        </div>
        <div class="return_managrment">
            <a href="management.php">管理画面に戻る</a>
        </div>
</body>
</html>
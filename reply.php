<?php

require_once 'vendor/autoload.php'; // Composer のオートロードファイルを読み込む
use Dotenv\Dotenv;

// .env ファイルを読み込む
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once('./database.php');

$database = new Database();
$record = $database -> find_record((int)$_GET['id']);
// var_dump($record['child_id']);

if(!empty($_POST)){
    if(empty($_POST['reply_content'])){
        exit('<p>返信内容が入力されていません</p>'.'<br>'.'<a href="./management.php">管理画面に戻る</a>');
    }

    $database = new Database();
    $records = $database->store_reply($_POST);

    $redirectUrl = "./response.php?id=" . $record["child_id"];

    header("Location: $redirectUrl");
    exit;
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>出欠れんらくん</title>
    <link rel="stylesheet" href="css/reply.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
    <div class="all">
    <h3><?= $record['child_name'] ?>さんへの返信</h3>
        <table>
            <tr>
                <th>園児名</th>
                <th>日付</th>
                <th>出欠</th>
                <th>欠席理由</th>
            </tr>

            <tr>
                <th><?= $record['child_name'] ?></th>
                <th><?= $record['date'] ?></th>
                <th><?php if($record['status'] == 2){ echo '<i class="fas fa-times fa-2x" style="color: #ff4d4d;"></i>'; }  ?></th>
                <th><?= $record['absence_reason'] ?></th>
            </tr>
        </table>
        <div class="reply_all">
            <form method="POST" action="">
            <div class="reply_childminders">
                <label class="reply_people">返信者</label>
                <select name="minder">
                    <option value="1">鈴木 たけし</option>
                    <option value="2">田村 えりこ</option>
                    <option value="3">中野 ゆかり</option>                        
                    <option value="4">山田 みさき</option>
                </select>
            </div>
            <div class="reply_content">
                <input type="hidden" name="child_id" value="<?= $record['child_id']; ?>">
                <input type="hidden" name="record_id" value="<?= $record['id']; ?>">
                <textarea name="reply_content" rows="2" cols="60" placeholder="返信内容を入力してください"></textarea><br>
                
            </div>

            <div class="button_position">
            <input type="submit" value="返信" class="button">
            </div >

            
            
            </form>
            
        </div>
        

        <div class="return_managrment">
            <a href="./response.php?id=<?= $record['child_id']; ?>" class="link">戻る</a>
        </div>    
       
    </div>
    

             
        
</body>
</html>

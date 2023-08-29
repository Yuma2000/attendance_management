<?php
require_once 'database.php';
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new Database();

$id = $_GET['id'];
$child_name = $db->getChildName($id);

// 出欠履歴をDBから取得

// その月の出欠履歴をデータベースから取得
$stmt = $pdo->prepare("SELECT date, status, absence_reason FROM records WHERE child_id = ? AND MONTH(date) = MONTH(CURRENT_DATE())");
$stmt->execute([$child_id]);
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <a href="selectchild.php">園児一覧へ戻る</a>
    
    <title>園児詳細</title>
    <link rel="stylesheet" href="css/childdetail.css">
</head>
<body>
<h2><?= htmlspecialchars($childName, ENT_QUOTES) ?>の出欠履歴</h2>
<form action="childdetail.php" method="post">
    <!-- 日付選択 -->
    <label for="date">日付:</label>
    <input type="date" id="date" name="date" required>
    <br><br>

    <!-- 出席/欠席選択 -->
    <input type="radio" id="attendance" name="status" value="出席" required>
    <label for="attendance">出席</label>
    <input type="radio" id="absence" name="status" value="欠席">
    <label for="absence">欠席</label>
    <br><br>

    <!-- 欠席理由（欠席を選択した場合のみ入力） -->
    <label for="reason">欠席理由:</label>
    <textarea id="reason" name="reason" rows="4" cols="50" placeholder="欠席理由を入力..."></textarea>
    <br><br>

<label for="date">日付</label>
<input>


<!-- 出欠登録 -->
<h2><?php echo htmlspecialchars($child_name['name']); ?>：出欠登録</h2>

<table border="1">
    <tr>
        <h3>本日の日付： <?php echo date('Y-m-d'); ?></h3>
        <h3>出欠状況の登録</h3>

        <form method="post" >
        <label><input type="radio" name="status" value=1>出席</label><br>
        <label><input type="radio" name="status" value=2>欠席</label><br>
        <input type="submit" value="送信"><br>
        <br>
        </form>

        <?php
        $status = 2;//出欠状態の初期値
        $absence_reason = NULL; //初期値としてNULLを設定


        if(isset($_POST['status'])) {
            $status = $_POST['status'];
            //echo '現在の登録：' . $status . '<br>';
            require_once('./database.php');
            $database_attendance = new Database();
            $record = $database_attendance -> record($child_id,$status,$absence_reason);
        }

        if ($status == 1){
            echo "出席が登録されました．<br>車に気をつけて，元気に登校してね！<br>";
        }

        if ($status == 2) : ?>
            <form method="post">
                欠席理由
        <div>
            <label for="absence_reason"></label>
            <textarea id="absence_reason" name="absence_reason" cols="50" rows="10"></textarea>
        </div>
        <input type="submit" value="送信"><br>
        <?php endif; ?>

        <?php

        if(isset($_POST['absence_reason'])) {
            $absence_reason = $_POST['absence_reason'];
            //echo '現在の登録：' . $status . '<br>';
            if(empty($_POST['absence_reason'])){
                echo '欠席理由が入力されていません．<br>';
            }elseif(!empty($_POST['absence_reason'])){
                require_once('./database.php');
                $database_attendance = new Database();
                $record = $database_attendance -> record($child_id,$status,$absence_reason);
                echo '欠席理由が送信されました．<br>';
            }
           
        } 

        

        ?>

    </tr>
    

</table>


<!-- 出欠履歴 -->
<h2><?php echo htmlspecialchars($child_name['name']); ?>の出欠履歴</h2>


<table border="1">
    <tr>
        <th>日付</th>
        <th>出欠</th>
        <th>欠席理由</th>
        <th>返信</th>
    </tr>
</table>

</body>
</html>


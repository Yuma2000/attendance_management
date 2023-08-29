<?php
require_once 'database.php';
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new Database();
$children_records = $db -> find((int)$_GET['id']);
// var_dump($records);

$pdo = $db->connect();
$id = $_GET['id'];
$childName = $db->getChildName($id);



// その月の出欠履歴をデータベースから取得
$sql = "SELECT date, status, absence_reason FROM records WHERE child_id = ? AND MONTH(date) = MONTH(CURRENT_DATE())";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
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

<!-- 出欠登録 -->
<h2><?php echo htmlspecialchars($childName); ?>：出欠登録</h2>

<table>
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
            $status = 2;  // 出欠状態の初期値
            $absence_reason = null;  // 初期値としてNULLを設定

            if(isset($_POST['status'])) {
                $status = $_POST['status'];
                $record = $db->record($id, $status, $absence_reason);
            }

            if ($status == 1){
                echo "出席が登録されました．<br>車に気をつけて，元気に登校してね！<br>";
            }
        ?>
        <?php if ($status == 2): ?>
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
                if (empty($_POST['absence_reason'])) {
                    echo '欠席理由が入力されていません．<br>';
                } elseif (!empty($_POST['absence_reason'])) {
                    $record = $db->record($id,$status,$absence_reason);
                    echo '欠席理由が送信されました．<br>';
                }
            
            }
        ?>

    </tr>
</table>

<!-- 出欠履歴 -->
<h3><?php echo htmlspecialchars($childName); ?>の出欠履歴</h3>
    <table>
        <tr>
            <th>日付</th>
            <th>出欠</th>
            <th>欠席理由</th>
            <th>欠席に対する返信</th>
        </tr>

        <?php foreach($children_records as $record){ ?>
        <tr>
            <td><?= date('Y/m/d', strtotime($record['date'])); ?></td>
            <td><?php if ($record['status'] == 2){
                    print '欠席';
                }else{print '出席';}?></td>
            <td><?= $record['absence_reason']; ?></td>
            <td><?= $record['reply_content'] ?><br><?= $record['childminder_name'] ?></td>
        </tr>
        <?php } ?>
    </table>

</body>
</html>

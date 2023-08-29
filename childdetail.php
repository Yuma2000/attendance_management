<?php
require_once 'database.php';
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new Database();
$pdo = $db->connect();

try {
    // 子供の名前を取得
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT name FROM children WHERE id = ?");
    $stmt->execute([$id]);
    $child = $stmt->fetch();

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
    <title>園児詳細</title>
    <link rel="stylesheet" href="css/childdetail.css">
</head>
<body>
<h2>園児Aの出欠履歴</h2>
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


<h2><?php echo htmlspecialchars($child['name']); ?>の出欠履歴</h2>


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


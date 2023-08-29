<?php
/* try {
    $db_user = "sample";
    $db_pass = "password";
    $db_host = "localhost";
    $db_name = "attendance_managementdb";
    $db_type = "mysql";

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
    }  */

    require_once 'vendor/autoload.php'; // Composer のオートロードファイルを読み込む
    use Dotenv\Dotenv;

    // .env ファイルを読み込む
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    require_once('./database.php');

    /* // 子供の名前を取得
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT name FROM children WHERE id = ?");
    $stmt->execute([$id]);
    $child = $stmt->fetch();
 */
    // 現在の月の日数を取得
    $daysInMonth = date('t');

   /*  // その月の出欠履歴をデータベースから取得
    $stmt = $pdo->prepare("SELECT date, attendance, reason FROM records WHERE child_id = ? AND MONTH(date) = MONTH(CURRENT_DATE())");
    $stmt->execute([$id]);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
 */
    // 接続切断
    $pdo = null;
/* } catch (PDOException $e) {
    print $e->getMessage() . "<br/>";
    die();
} */
    $child_id = 3;
    $status = 2;
    $absence_reason = "あああ";

    $record_test = new Database();
    $record_te = $record_test -> record($child_id,$status,$absence_reason);

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>園児詳細</title>
</head>
<body>

<h2><?php echo htmlspecialchars($child['name']); ?>の出欠履歴</h2>

<table border="1">
    <tr>
        <th>日付</th>
        <th>出欠</th>
        <th>欠席理由</th>
    </tr>
    <?php
    for ($i = 1; $i <= $daysInMonth; $i++) {
        $date = date('Y-m') . '-' . str_pad($i, 2, '0', STR_PAD_LEFT);
        $record = array_filter($records, function($r) use ($date) {
            return $r['date'] === $date;
        });
        $record = reset($record);
        
        echo "<tr>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . ($record['attendance'] ?? '') . "</td>";
        echo "<td>" . ($record['reason'] ?? '') . "</td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>


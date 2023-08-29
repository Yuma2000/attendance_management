<?php
require_once 'vendor/autoload.php'; // Composer のオートロードファイルを読み込む
use Dotenv\Dotenv;

// .env ファイルを読み込む
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $db_user = $_ENV['DB_USER']; //ユーザー名
    $db_pass = $_ENV['DB_PASSWORD']; //パスワード
    $db_host = $_ENV['DB_HOST']; //ホスト名
    $db_name = $_ENV['DB_NAME']; //データベース名
    $db_type = $_ENV['DB_TYPE']; //データベースの種類

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
    }

    // 子供の名前を取得
    $child_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT name FROM children WHERE id = ?");
    $stmt->execute([$child_id]);
    $child_name = $stmt->fetch();//配列 */

    // 現在の月の日数を取得
    $daysInMonth = date('t');

    // その月の出欠履歴をデータベースから取得
    $stmt = $pdo->prepare("SELECT date, status, absence_reason FROM records WHERE child_id = ? AND MONTH(date) = MONTH(CURRENT_DATE())");
    $stmt->execute([$child_id]);
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
    <a href="selectchild.php">園児一覧へ戻る</a>
    
    <title>園児詳細</title>
</head>
<body>

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
        echo "<td>" . ($record['status'] ?? '') . "</td>";
        echo "<td>" . ($record['absence_reason'] ?? '') . "</td>";
        echo "</tr>";
    }
    ?>
</table>

</body>
</html>


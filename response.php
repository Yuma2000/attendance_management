<?php 
    require_once 'vendor/autoload.php'; // Composer のオートロードファイルを読み込む
    use Dotenv\Dotenv;

    // .env ファイルを読み込む
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    require_once('./database.php');

    $db = new Database();
    // パラメータが存在しない場合は、今月の年と月を使用
    $selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');
    $selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('m');
    // 前月
    $prevMonth = $selectedMonth - 1;
    $prevYear = $selectedYear;
    if ($prevMonth < 1) {
        $prevMonth = 12;
        $prevYear--;
    }
    // 次月
    $nextMonth = $selectedMonth + 1;
    $nextYear = $selectedYear;
    if ($nextMonth > 12) {
        $nextMonth = 1;
        $nextYear++;
    }

    $child_id = (int)$_GET['id'];
    $monthlyRecords = $db->findMonthlyRecords($child_id, $selectedYear, $selectedMonth);

    if(empty($records)){
        $database = new Database();
        // recordsテーブルのchild_idからその園児の出欠記録データとchildrenテーブルのnameカラムの値を取得
        $records = $database -> find((int)$_GET['id']);

        
    }
    // var_dump($_GET['class']);
?>
 
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>出欠れんらくん</title>
    <link rel="stylesheet" href="css/response.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>
    <div class="button">
        <div class="back_button">
            <div class="a_back_button">
                <a href="management.php?class=<?= $_GET['class'] ?>"> 生徒選択画面に戻る</a>
            </div>
        </div>
        <div class="login_button">
            <div class="a_login_button">
                <a href="#" style="text-decoration:none">
        保育士ログイン中
    </a>
            </div>
        </div>
    </div>
    <h3>出欠の詳細</h3>
   
    <table>
        <tr>
            <th>園児名</th>
            <!-- <th>組</th> -->
            <th>日付</th>
            <th>出欠</th>
            <th>理由</th>
            <th>保育士からの返信</th>
            <th></th>
        </tr>

        
        <tr>
            <td><?= $records[0]['child_name']; ?></td>
            <?php if($records[0]['date'] == date('Y-m-d')):?>
            <td><?= date('Y/m/d', strtotime($records[0]['date'])); ?></td>
            <td>
                <?php 
                    if ($records[0]['status'] == 2) {
                        echo '<i class="fas fa-times fa-2x" style="color: #ff4d4d;"></i>';
                    } elseif ($records[0]['status'] == 3) {
                        echo '<i class="fas fa-square fa-2x" style="color: #fcff2e;"></i>';
                    } else {
                        echo '<i class="far fa-circle fa-2x" style="color: #62f973;"></i>';
                    }
                ?>
            </td>
            <td><?= $records[0]['absence_reason']; ?></td>
            <td><?= $records[0]['reply_content'] ?><br><?= $records[0]['childminder_name'] ?></td>

            <?php if(($records[0]['status'] == 2 || $records[0]['status'] == 3) && $records[0]['date'] == date('Y-m-d')): ?>
                <td>
                    <?php if(empty($records[0]['reply_content'])): ?>
                        <a href="./reply.php?id=<?= $records[0]['id']; ?>"><button>返信</button></a>
                    <?php else: ?><div class="reply-button">
                        <a href="./reply_edit.php?id=<?= $records[0]['id']; ?>"><button>編集</button></a>
                    </div> 
                    <?php endif ?>
                </td>
            <?php endif ?>
            <?php else: ?>
            <td>今日の出欠データがありません。</td>
            <?php endif ?>
        </tr>
    </table>

    <h3>過去の出席履歴</h3>
    <div class="pagination">
        <div>
            <a href="response.php?id=<?=$child_id?>&class=<?=$_GET['class']?>&year=<?=$prevYear?>&month=<?=$prevMonth?>"><?=$prevYear?>年<?=$prevMonth?>月</a>
        </div>
        <div>
            <a href="response.php?id=<?=$child_id?>&class=<?=$_GET['class']?>&year=<?=$nextYear?>&month=<?=$nextMonth?>"><?=$nextYear?>年<?=$nextMonth?>月</a>
        </div>
    </div>
    <table>
        <tr>
            <th>園児名</th>
            <th>日付</th>
            <th>出欠</th>
            <th>理由</th>
            <th>保育士からの返信</th>
        </tr>
        <?php foreach($monthlyRecords as $index => $record){ ?>
        <tr>
            <td><?= $record['child_name']; ?></td>
            <td><?= date('Y/m/d', strtotime($record['date'])); ?></td>
            <td>
                <?php 
                    if ($record['status'] == 2) {
                        echo '<i class="fas fa-times fa-2x" style="color: #ff4d4d;"></i>';
                    } elseif ($record['status'] == 3) {
                        echo '<i class="fas fa-square fa-2x" style="color: #fcff2e;"></i>';
                    } else {
                        echo '<i class="far fa-circle fa-2x" style="color: #62f973;"></i>';
                    }
                ?>
            </td>
            <td><?= $record['absence_reason']; ?></td>
            <td><?= $record['reply_content'] ?><br><?= $record['childminder_name'] ?></td>
        </tr>
        <?php } ?>
    </table>

</body>
</html>

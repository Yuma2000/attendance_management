<?php
require_once 'database.php';
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new Database();
$children_records = $db -> find((int)$_GET['id']);
// var_dump($records);

$pdo = $db->connect();
$child_id = $_GET['id'];
$childName = $db->getChildName($child_id);

//データの重複の確認処理→問題なければ保存
if(!empty($_POST)){
    // var_dump($_POST['date']);
    // $db -> record($_POST);
    $duplication = $db -> isDuplicationRecord($_POST['child_id'], $_POST['date']);

    if(!$duplication){
        $db -> record($_POST);
    }
}



// その月の出欠履歴をデータベースから取得
// $sql = "SELECT date, status, absence_reason FROM records WHERE child_id = ? AND MONTH(date) = MONTH(CURRENT_DATE())";
// $stmt = $pdo->prepare($sql);
// $stmt->execute([$id]);
// $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <a href="selectchild.php">園児一覧へ戻る</a>
    <title>園児詳細</title>
    <link rel="stylesheet" href="css/childdetail.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>
<body>

    <!-- 出欠登録 -->
    <h2><?php echo htmlspecialchars($childName); ?>：出欠登録</h2>

    <table>
        <tr>
            <h3>本日の日付： <?php echo date('Y-m-d'); ?></h3>
            <h3>出欠状況の登録</h3>

            <form method="post" action="" id="attendanceForm">
                <input type="hidden" name="child_id" value="<?= $child_id; ?>">
                <input type="hidden" name="date" value="<?= date('Y-m-d'); ?>">
                <label><input type="radio" name="status" value=1 id="attendanceRadio">出席</label><br>
                <label><input type="radio" name="status" value=2 id="absenceRadio">欠席</label><br>

                <div id="absenceReasonForm" style="display: none;">
                    欠席理由<br>
                    <div>
                        <label for="absence_reason"></label>
                        <textarea id="absence_reason" name="absence_reason" cols="50" rows="10"></textarea>
                    </div>
                    <div id="errorContainer" style="color: red;"></div> <!-- エラーメッセージ表示用のコンテナ -->
                </div>
                <input type="submit" value="送信"><br>
            </form>


            <!-- <?php
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
            ?> -->

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
                    echo '<i class="fas fa-times fa-2x" style="color: #ff4d4d;"></i>';
                }else{echo '<i class="far fa-circle fa-2x" style="color: #62f973;"></i>';}?></td>
            <td><?= $record['absence_reason']; ?></td>
            <td><?= $record['reply_content'] ?><br><?= $record['childminder_name'] ?></td>
        </tr>
        <?php } ?>
    </table>

    <script>
        const attendanceRadio = document.getElementById('attendanceRadio');
        const absenceRadio = document.getElementById('absenceRadio');
        const absenceReasonForm = document.getElementById('absenceReasonForm');

        attendanceRadio.addEventListener('change', function() {
            if (this.checked) {
                absenceReasonForm.style.display = 'none'; // 出席が選択されたら欠席理由フォームを非表示にする
            }
        });

    absenceRadio.addEventListener('change', function() {
        if (this.checked) {
            absenceReasonForm.style.display = 'block'; // 欠席が選択されたら欠席理由フォームを表示する
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        const attendanceForm = document.getElementById('attendanceForm'); // フォームを取得
        const absenceReasonForm = document.getElementById('absenceReasonForm');

        attendanceForm.addEventListener('submit', async function(event) {
            event.preventDefault(); // デフォルトのフォーム送信を防ぐ

            const statusInput = document.querySelector('input[name="status"]:checked');
            const absenceReasonInput = document.getElementById('absence_reason');

            // バリデーション: 欠席が選択されている場合、欠席理由が入力されているか確認
            if (statusInput && statusInput.value === '2' && !absenceReasonInput.value.trim()) {
                errorContainer.textContent = '欠席理由を入力してください。';
                return;
            }

            // エラーメッセージをクリア
            errorContainer.textContent = '';

            const formData = new FormData(attendanceForm);

            try {
                const response = await fetch(attendanceForm.action, {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    absenceReasonForm.style.display = 'none'; // 欠席理由フォームを非表示にする
                    location.reload();
                } else {
                    // エラー処理
                }
            } catch (error) {
                console.error(error);
                // エラー処理
            }
        });
    });
    </script>
</body>
</html>

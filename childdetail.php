<?php
require_once 'database.php';
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new Database();

$pdo = $db->connect();
$child_id = $_GET['id'];
$childData = $db->getChildName($child_id);
// var_dump($childData);
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

$monthlyRecords = $db->findMonthlyRecords($child_id, $selectedYear, $selectedMonth);

//データの重複の確認処理→問題なければ保存
if(!empty($_POST)){
    $duplication = $db -> isDuplicationRecord($_POST['child_id'], $_POST['date']);

    if(!$duplication){
        $db -> record($_POST);
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>出欠れんらくん</title>
    <link rel="stylesheet" href="css/childdetail.css">
    <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
</head>

<header>

</header>
<body>
  <div class="header">
      <div class="header-left">
          <a href="loginform.php">園児一覧に戻る</a>
      </div>
      <div class="header-center">
          F保育園
      </div>
      <div class="header-right">
          保護者としてログイン中
      </div>
  </div>

  <!-- 出欠登録 -->
  <div class="registration-content">
    <h2><?php echo htmlspecialchars($childData['name']); ?>：出欠登録</h2>
    <h3><?php echo htmlspecialchars($childData['class']); ?> 組</h3>
      <h3>本日の日付： <?php echo date('Y-m-d'); ?></h3>
      <h3>出欠状況の登録</h3>

      <form method="post" action="" id="attendanceForm">
          <input type="hidden" name="child_id" value="<?= $child_id; ?>">
          <input type="hidden" name="date" value="<?= date('Y-m-d'); ?>">

          <div class="attendance-details">
            <label><input type="radio" name="status" value=1 id="attendanceRadio">出席</label><br>
            <label><input type="radio" name="status" value=2 id="absenceRadio">欠席</label><br>
            <label><input type="radio" name="status" value=3 id="lateRadio">遅刻</label><br>
            <div id="absenceReasonForm" style="display: none;">

            <?php echo htmlspecialchars($childData['name']); ?>のメッセージ<br>
              <div>
                <label for="absence_reason"></label>
                <textarea id="absence_reason" name="absence_reason" cols="50" rows="10"></textarea>
              </div>
        
              <div id="errorContainer" style="color: red;"></div> <!-- エラーメッセージ表示用のコンテナ -->
            </div>        
            <div class="submit-button">
              <input type="submit" value="送信"><br>
            </div>
          </div>
        </form>
    </div>

    <!-- 出欠履歴 -->
    <h3><出欠履歴></h3>
    <div class="pagination">
        <div>
            <a href="childdetail.php?id=<?=$child_id?>&year=<?=$prevYear?>&month=<?=$prevMonth?>"><?=$prevYear?>年<?=$prevMonth?>月</a>
        </div>
        <div>
        <a href="childdetail.php?id=<?=$child_id?>&year=<?=$nextYear?>&month=<?=$nextMonth?>"><?=$nextYear?>年<?=$nextMonth?>月</a>
        </div>
    </div>
    <table>
        <tr>
            <th>日付</th>
            <th>出欠</th>
            <th><?php echo htmlspecialchars($childData['name']); ?>のメッセージ</th>
            <th>保育士メッセージ</th>
        </tr>

        <?php foreach($monthlyRecords as $record){ ?>

        <tr>
            <td><?= date('Y/m/d', strtotime($record['date'])); ?></td>
            <td><?php if ($record['status'] == 2){
                    echo '<i class="fas fa-times fa-2x" style="color: #ff4d4d;"></i>';
                }else if($record['status'] == 1){echo '<i class="far fa-circle fa-2x" style="color: #62f973;"></i>';}
                else{echo '<i class="fas fa-square fa-2x" style="color: ;"></i>';}?></td>
            <td><?= $record['absence_reason']; ?></td>
            
            <td><?= $record['reply_content'] ?><br><?= $record['childminder_name'] ?></td>
        </tr>
        <?php } ?>
    </table>

    <script>
        const attendanceRadio = document.getElementById('attendanceRadio');
        const absenceRadio = document.getElementById('absenceRadio');
        const absenceReasonForm = document.getElementById('absenceReasonForm');
        const lateRadio = document.getElementById('lateRadio');
       

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

        lateRadio.addEventListener('change', function() {
            if (this.checked) {
                absenceReasonForm.style.display = 'block'; // 遅刻が選択されたらフォームを表示にする
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const attendanceForm = document.getElementById('attendanceForm');
            const absenceReasonForm = document.getElementById('absenceReasonForm');
           

            attendanceForm.addEventListener('submit', async function(event) {
                event.preventDefault(); // デフォルトのフォーム送信を防ぐ

                const statusInput = document.querySelector('input[name="status"]:checked');
                const absenceReasonInput = document.getElementById('absence_reason');
              
                // 欠席が選択されている場合、欠席理由が入力されているか確認
                if (statusInput && statusInput.value === '2' && !absenceReasonInput.value.trim()) {
                    errorContainer.textContent = '欠席理由を入力してください。';
                    return;
                }

                // 遅刻が選択されている場合、遅刻理由が入力されているか確認
                if (statusInput && statusInput.value === '3' && !absenceReasonInput.value.trim()) {
                    errorContainer.textContent = '遅刻に関するメッセージを入力してください。';
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
                        absenceReasonForm.style.display = 'none';
                       
                        location.reload();
                    } else {
                        console.error(error);
                    }
                } catch (error) {
                    console.error(error);
                }
            });
        });
    </script>
</body>
</html>

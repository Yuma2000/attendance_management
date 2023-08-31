<?php 
require_once 'vendor/autoload.php'; // Composer のオートロードファイルを読み込む
use Dotenv\Dotenv;

// .env ファイルを読み込む
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once('./database.php');

$db = new Database();
//recordsテーブルのデータを全取得＆recordsテーブルのchild_idからchildrenテーブルのnameカラムの値を取得する
//出席者を取得
$records_pre = $db-> all_records_present($_GET['class']);

//recordsテーブルのデータを全取得＆recordsテーブルのchild_idからchildrenテーブルのnameカラムの値を取得する
//欠席者を取得
$records_ab = $db -> all_records_absent($_GET['class']);

/* 未提出者を取得 */
$records_yet = $db -> all_records_yet($_GET['class']);

if (!empty($_POST)) {
    $db->check($_POST);

    header("Location: management.php?class=" . $_GET['class']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>出欠れんらくん</title>
    <link rel="stylesheet" href="css/management.css">
</head>

<body>
    <div class="button">
        <div class="back_button">
            <div class="a_back_button">
                <a href="./management_class.php" style="text-decoration:none">クラス選択に戻る</a>
            </div>
        </div>

        <div class="login_button">
            <div class="a_login_button">
                <a href="#" style="text-decoration:none">保育士ログイン中</a>
            </div>
        </div>
    </div>

    <h3>園児出欠一覧</h3>
    <h3>本日の日付： <tr>  <td><?= date('Y/m/d'); ?></td></tr></h3>
    <h3><?= $_GET['class'] ?>組</h3>
    <div class="table-content">
        <div class="submited">
            <div class="attendance">
                <table>
                    <tr>
                        <th>出席</th>
                    </tr>
                    <?php if(empty($records_pre)): ?>
                        <tr>
                            <td>データなし</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($records_pre as $records_pre2): ?>
                        <tr>
                            <td>
                                <a href="response.php?id=<?php print($records_pre2['child_id']) ?>&class=<?= $_GET['class']?>" name="sentaku"><?php print($records_pre2['child_name']) ?></a>
                                <form method="POST" action="" id="attendanceForm" onsubmit="disableButton()">
                                    <input type="hidden" name="check_message" value="出席確認済みです。">
                                    <input type="hidden" name="record_id" value="<?=$records_pre2['id']?>">
                                    <input type="hidden" name="minder_id" value="1">
                                    <?php if($records_pre2['check_message'] != '出席確認済みです。'): ?>
                                    <button type="submit" id="submitButton">確認</button>
                                    <?php else: ?>
                                    <div>確認済み</div>
                                    <?php endif ?>                           
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </div>

            <div class="absence">
                <table>
                    <tr>
                        <th>欠席</th>
                    </tr>
                    <?php if(empty($records_ab)): ?>
                        <tr>
                            <td>データなし</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($records_ab as $records_ab2): ?>
                        <tr>
                            <td><a href="response.php?id=<?php print($records_ab2['child_id']) ?>&class=<?= $_GET['class']?>" name="sentaku"><?php print($records_ab2['child_name']) ?></a></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </div>
        </div>

        <div class="yet">
            <table>
                <th>未提出</th>
                    <?php foreach($records_yet as $records_yet2): ?>
                        <tr>
                            <td><a href="response.php?id=<?php print($records_yet2['child_id']) ?>&class=<?= $_GET['class']?>" name="sentaku"><?php print($records_yet2['child_name']) ?></a></td>
                        </tr>
                    <?php endforeach; ?>
            </table>
        </div>
    </div>
</body>
</html>

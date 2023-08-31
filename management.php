<?php 
require_once 'vendor/autoload.php'; // Composer のオートロードファイルを読み込む
use Dotenv\Dotenv;

// .env ファイルを読み込む
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once('./database.php');

$database_present = new Database();
//recordsテーブルのデータを全取得＆recordsテーブルのchild_idからchildrenテーブルのnameカラムの値を取得する
//出席者を取得
$records_pre = $database_present -> all_records_present($_GET['class']);


$database_absent = new Database();
//recordsテーブルのデータを全取得＆recordsテーブルのchild_idからchildrenテーブルのnameカラムの値を取得する
//欠席者を取得
$records_ab = $database_absent -> all_records_absent($_GET['class']);

/* 未提出者を取得 */
$database_yet = new Database();
$records_yet = $database_yet -> all_records_yet($_GET['class']);


?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>一覧</title>
    <link rel="stylesheet" href="css/management.css">
</head>
<body>
    <h3>生徒出欠管理画面</h3>
    <a href="./management_class.php">クラス選択へ</a>
    <h3>本日の日付： <tr>  <td><?= date('Y/m/d'); ?></td></tr></h3>
    <h3><?= $_GET['class'] ?>組</h3>
    <div class="table-content">
        <div class="attendance">
            <table>
                <tr>
                    <th>出席</th>
                    <?php foreach($records_pre as $records_pre2){ ?>
                <tr>
                    <td><a href="response.php?id=<?php print($records_pre2['child_id']) ?>" name="sentaku"><?php print($records_pre2['child_name']) ?></a></td>
                </tr>
                <?php } ?>
                    <th>欠席</th>
                    <?php foreach($records_ab as $records_ab2){ ?>
                <tr>
                    <td><a href="response.php?id=<?php print($records_ab2['child_id']) ?>" name="sentaku"><?php print($records_ab2['child_name']) ?></a></td>
                </tr>
                <?php } ?>
                </tr>
            </table> 
        </div>

        <div class="yet">
            <table>
            <th>未提出</th>
                    <?php foreach($records_yet as $records_yet2){ ?>
                <tr>
                    <td><a href="response.php?id=<?php print($records_yet2['child_id']) ?>" name="sentaku"><?php print($records_yet2['child_name']) ?></a></td>
                </tr>
            <?php } ?>
            </table>
        </div>
    </div>
</body>
</html>

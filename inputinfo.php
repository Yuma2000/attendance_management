<?php 

    require_once('./database.php');

?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="InputStyle.css">
</head>
<body>
    <h3 class="midasi">入力画面</h3>
    <form action="", method="post">
    
    <p>
    <label for="name">名前</label>
    <select name="name" >
    <option value="あいうえお">あいうえお</option>
    <option value="まなか">まなか</option>
    <option value="サンプル3">選択肢のサンプル3</option>
    <option value="サンプル4">選択肢のサンプル4</option>
    <option value="サンプル5">選択肢のサンプル5</option>
    </select>
    </p>

        <label for="date">日付</label>
        <input type="date" value="<?php echo date('Y-m-d'); ?>" name="day">
        <br>
        <br>
       
        <div class="spend-income">
            <div class="spendbutton">
                <input type="radio" name="sori" value="1" id="spend" >
                <label for="spend">出席</label>
            </div>
            <div class="incomebutton">
                <input type="radio" name="sori" value="2" id="income">
                <label for="income">欠席</label>
            </div>
        </div>

        <label for="memo">欠席理由</label>
        <input type="text" name="memo">
        <br>
        
        <br>
        <br>
        
        <br>
        <div class="register-or-report">
            <div>
            <input type="submit" value="登録" name="regist">
            </div>
            <div>
            <input type="submit" value="レポート" name="report">
            </div>
            
        </div>
        
        


    </form>

    <?php 
    
    // if(isset($_POST["report"])){
    //     //レポートボタンが押された時
    //     //report.phpに遷移する
    //     header("Location:report.php");
    //     unset($_SESSION['レポート']);
    //     exit();
    // }
    ?>
        
       

<?php 


    // if(isset($_POST["regist"])){
    //     $name = $_POST['name'];

    //     $db_user = "sample"; //ユーザー名
    //     $db_pass = "password"; //パスワード
    //     $db_host = "localhost"; //ホスト名
    //     $db_name = "attendancedb"; //データベース名
    //     $db_type = "mysql"; //データベースの種類

    //     //DSN（接続のための決まった情報を決まった順序に組み立てた文字列のこと）の組み立て
    //     $dsn = "$db_type:host=$db_host;dbname=$db_name;charset=utf8";

    //     try{
    //         //MySQLに接続
    //         $pdo = new PDO($dsn, $db_user, $db_pass);
    //         $pdo->setAttribute(PDO::ATTR_ERRMODE,
    //                 PDO::ERRMODE_EXCEPTION);

    //         $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    //         print "接続しました...<br>";
    //     }catch(PDOException $Exception){
    //         die('接続エラー:'.$Exception->getMessage());
    //     }

    //     try{

    //         //入力がない場合、１０が代入される
    //         $sori = 10;
            
    //         //フォームに入力された値を取得
    //         $day = $_POST['day'];
    //         $memo = $_POST['memo'];

    //         if (!empty($_POST["sori"])) {

    //             if ($_POST["sori"] == "1" ){
    //                 $sori = 1;
    //             }else{
    //                 $sori = 2;
    //             }
            
    //         }

           
            
    //         if($sori == 10){
    //             print '出席・欠席の欄を選択してください。<br>';
    //         }else{

    //             //if($id == null){
    //             //    $id = $_POST["id"] + 1;
    //             //}
    //             $pdo->beginTransaction();

    //         // テーブルに登録するINSERT INTO文を変数に格納　VALUESはプレースフォルダーで空の値を入れとく
    //         $sql = "INSERT INTO inputtable(day, type, memo, name) VALUES(:day, :sori ,:memo, :name)";
    
    //         $stmh = $pdo->prepare($sql); //値が空のままSQL文をセット
    //         $params = array(':day' => $day, ':sori' => $sori, ':memo' => $memo, ':name' => $name); // 挿入する値を配列に格納
    //         $stmh->execute($params); //挿入する値が入った変数をexecuteにセットしてSQLを実行

            
    //         //$stmh->execute();
    //         $pdo->commit();
    //         print "データを".$stmh->rowCount()."件、挿入しました。<br>";

            
            
    //         }
    //         }catch(PDOException $Exception){
    //             $pdo->rollBack();
    //             print "エラー：".$Exception->getMessage();
    //         }

            
            
                
    // }



        
        //トランザクションの開始
        
    
    ?>

   
    
</body>
</html> 
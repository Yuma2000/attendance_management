<?php 

    require_once('./database.php');

?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>出欠管理アプリ</title>
    <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="signin">
        <form  method="POST" action="">
            <h1>出欠管理アプリ</h1>
            <div class="guardian-or-childminder">
                <div>
                <input type="submit" value="保護者用" name="guardian">
                </div>
                <div>
                <input type="submit" value="保育士用" name="childminder">
                </div>
                
            </div>
            
        </form>
    </div>
    <?php 
    // if(isset($_POST["guardian"])){
    //     //保護者用ボタンが押された時
    //     //inputname.phpに遷移する
    //     header("Location:inputinfo.php");
    //     unset($_SESSION['保護者用']);
    //     exit();
    // }
     ?>

<?php 
    // if(isset($_POST["childminder"])){
    //     //保育士用ボタンが押された時
    //     //management.phpに遷移する
    //     header("Location:management.php");
    //     unset($_SESSION['保育士用']);
    //     exit();
    // }
     ?>
</body>
</html>

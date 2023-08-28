<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!--link rel="stylesheet" href="InputStyle.css"-->
</head>
<body>
    <h3 class="midasi">名前入力画面</h3>
    <form action="inputinfo.php", method="post">
        <label for="name">名前</label>
        <input type="text" value="" name="name">
        
        <div class="next-page">
            <div>
            <input type="submit" value="出欠登録に進む" name="next">
            </div>
        </div>
        
        


    </form>
    

    <?php 
    
    if(isset($_POST["next"])){
        //レポートボタンが押された時
        if($_POST["name"] == "あいうえお"){
            //inputinfo.phpに遷移する
            header("Location:inputinfo.php");
            unset($_SESSION['次へ']);
            exit();   
        }else if($_POST["name"] == "まなか"){
            //inputinfo.phpに遷移する
            header("Location:inputinfo.php");
            unset($_SESSION['次へ']);
            exit();   

        }else{
            print '未登録の生徒です。<br>';

        }




       
    }
    ?>
        
       

   
    
</body>
</html> 
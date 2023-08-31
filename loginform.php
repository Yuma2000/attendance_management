<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login_forms.css">
    <title>出欠れんらくん</title>
</head>
<body>
    <div class="header">
        <div class="header-left">
        <a href="index.php">ホームページに戻る</a>
    </div>
    <div class="header-center">
          F保育園
      </div>
      <div class="header-right">
          ログインをしてください
      </div>
    </div>

    <div class="forms-border">
    <form action="childdetail.php" method="GET">
        <label for="">生徒ID</label><br>
        <input type="text" name="user_name" required="required" value="IDを入力" onfocus="clearInput(this)"><br>
        <label for="">パスワード</label><br>
        <input type="text" name="password" required="required" value="パスワードを入力" onfocus="clearInput(this)"><br>
        <div class="login-submit">
        <input type="submit" value="ログイン"> 
        </div>
        
    </form>
    </div>
   
    </div>
  
    
</body>
<script>
    function clearInput(input) {
        if (input.value === input.defaultValue) {
            input.value = '';
        }
    }
</script>

</html>


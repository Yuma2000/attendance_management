<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login_forms.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>出欠れんらくん</title>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <a href="index.php">トップページに戻る</a>
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
            <div class="form-content">
                <label for="">生徒ID</label><br>
                <input type="text" name="id" required="required"value="IDを入力" onfocus="clearInput(this)"><br>
                <label for="">パスワード</label><br>
                <div class="password-container">
                    <input type="password" id="password" name="password" required="required" value="パスワードを入力" onfocus="clearInput(this)">
                    <i class="fas fa-eye password-toggle" onclick="togglePasswordVisibility()"></i>
                </div>
                <div class="login-submit">
                <input type="submit" value="ログイン"> 
                </div>
            </div>
        </form>
    </div>
</body>
<script>
    function clearInput(input) {
        if (input.value === input.defaultValue) {
            input.value = '';
        }
    }

    function togglePasswordVisibility() {
        const passwordField = document.getElementById('password');
        const toggleIcon = document.querySelector('.password-toggle');
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>
</html>

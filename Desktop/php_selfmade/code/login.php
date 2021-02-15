<?php
ini_set('display_errors', "On");
error_reporting(E_ALL & ~E_NOTICE);
require_once('model/User.php');
$user = new User();
$user->dbconnect();

session_start();
if (!empty($_POST['name']) && !empty(($_POST['password']))) {
    $_SESSION['member'] = $_POST;
    if ($user->login() >= 1) {
        $_SESSION['login'] = 'login';
        header('Location: mypage.php');
        exit;
    }
    if ($user->login() === 0) {
        $error['login'] = "error";
    }
}

if(empty($_POST['name']) || empty($_POST['password'])) {
    $error['login'] = "error";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ログイン</title>
    <link rel="icon" type="image/x-icon" href="../images/icon.jpg">
    <link rel="stylesheet" href="styles/login.css">
</head>

<body>
    <div id="global_container">
        <div id="container">
            <!-- header -->
            <?php require_once('header.html'); ?>
            <!-- header -->
            <main class="main">
                <div class="login">
                    <div class="text-area">
                        <h2 class="h2">▼ログイン情報を入力してください</h2><br>
                    </div>
                    <div class="form-area">
                        <div class="errormessage">
                            <?php
                            if (!empty($_POST)) {
                                if ($error['login'] == 'error') {
                                    echo 'ログイン出来ませんでした。' . '<br>' . '※名前またはパスワードが間違っています';
                                }
                            }
                            ?>
                        </div>
                        <form action="" method="post">
                            <div class="input-name">
                                <p>名前：</p><input type="text" name="name" id="name" size="30" placeholder="名前を入力してください">
                            </div>
                            <div class="input-password">
                                <p>パスワード：</p><input type="password" name="password" id="password" size="30" placeholder="パスワードを入力してください">
                            </div>
                            <input type="submit" name="submit" id="submit" value="ログイン">
                        </form>
                    </div>
                </div>
            </main>
            
        </div>
    </div>
    <!-- footer -->
    <?php require_once('footer.html'); ?>
    <!-- footer -->
</body>

</html>
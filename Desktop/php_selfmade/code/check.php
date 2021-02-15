<?php
session_start();

if($_POST) {
    $_SESSION['user_info'] = $_POST;
    header('Location: done.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登録情報確認</title>
    <link rel="icon" type="image/x-icon" href="../images/icon.jpg">
    <link rel="stylesheet" href="styles/check.css">
</head>

<body>
    <div id="global_container">
        <div id="container">
            <!-- header -->
            <?php require_once('header.html'); ?>
            <!-- header -->
            <h2 class="h2">▼内容確認</h2>
            <div class="check-area">
                <div class="text">
                    <p class="check name">名前：</p>
                    <?= htmlspecialchars($_SESSION['check']['name'], ENT_QUOTES) . '</br>'; ?>
                    <p class="check email">メールアドレス：</p>
                    <?= htmlspecialchars($_SESSION['check']['email'], ENT_QUOTES) . '</br>'; ?>
                    
                    <p>上記内容で登録しますか？</p>
                    <form action="" method="POST">
                        <input type="hidden" name="name" id="name" value="<?= $_SESSION['check']['name']; ?>">
                        <input type="hidden" name="email" id="email" value="<?= $_SESSION['check']['email']; ?>">
                        <input type="hidden" name="password" id="password" value="<?= $_SESSION['check']['password']; ?>">
                        <div class="btn">
                            <input type="submit" name="submit" id="submit" value="登録する">
                        </div>
                    </form>

                </div>
            </div>
            <!-- footer -->
            <?php require_once('footer.html'); ?>
            <!-- footer -->
        </div>
    </div>
</body>

</html>
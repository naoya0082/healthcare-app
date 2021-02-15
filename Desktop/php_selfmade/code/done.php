<?php 
// DBへの登録処理
require_once('model/User.php');
$user = new User();
$user->dbconnect();

session_start();
$user->insert();
unset($_SESSION['user_info']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登録完了</title>
    <link rel="icon" type="image/x-icon" href="../images/icon.jpg">
    <link rel="stylesheet" href="styles/done.css">
</head>
<body>
    <div id="global_container">
        <div id="container">
            <!-- header -->
            <?php require_once('header.html'); ?>
            <!-- header -->
            <div class="done">
                <p>登録が完了しました</p>
                <a href="index.php">トップページへもどる</a>
            </div>
            <!-- footer -->
            <?php require_once('footer.html'); ?>
            <!-- footer -->
        </div>
    </div>
</body>
</html>
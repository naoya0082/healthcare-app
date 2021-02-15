<?php
ini_set('display_errors', "On");
error_reporting(E_ALL & ~E_NOTICE);
require_once('model/User.php');
$user = new User();
$user->dbconnect();


session_start();
$userId = $user->getUserId();
$menuId = $user->getMenuId();
$user->addrecord($userId['id'], $menuId['id'], $_SESSION['date']);

if (isset($_GET['logout'])) {
    $_SESSION['login'] = '';
    $_SESSION['member'] = '';
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登録完了</title>
    <link rel="icon" type="image/x-icon" href="../images/icon.jpg">
    <link rel="stylesheet" href="styles/record_done.css">
    <script type="text/javascript" src="scripts/jquery.js"></script>

</head>

<body>
    <div id="global_container">
        <div id="container">
            <!-- header -->
            <?php require_once('header_in.php'); ?>
            <!-- header -->
            <main class="main">
                <div class="message-area">
                    <p class="text">記録が完了しました！</p>
                    <a href="record.php">記録を続ける</a><br>
                    <a href="mypage.php">マイページへもどる</a>
                </div>
            </main>
            <!-- footer -->
            <?php require_once('footer.html'); ?>
            <!-- footer -->
        </div>
    </div>
</body>
<script type="text/javascript" src="scripts/main.js"></script>

</html>
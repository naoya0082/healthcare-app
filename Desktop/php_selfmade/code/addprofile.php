<?php
ini_set('display_errors', "On");
error_reporting(E_ALL & ~E_NOTICE);
require_once('model/User.php');
date_default_timezone_set('Asia/Tokyo');
$user = new User();
$user->dbconnect();
session_start();

if ($_POST) {
    $userId = $user->getUserId();
    $height = $_POST['height'] / 100;
    $weight = $_POST['weight'];
    $bmi = $weight / $height / $height;
    $date = date('Y-m-d');
    $user->insertProfile($userId['id'], $bmi, $date);
    header('Location: mypage.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>プロフィール作成</title>
    <link rel="icon" type="image/x-icon" href="../images/icon.jpg">
    <link rel="stylesheet" href="styles/addprofile.css">
    <script type="text/javascript" src="scripts/jquery.js"></script>

</head>

<body>
    <!-- header -->
    <?php require_once('header_in.php'); ?>
    <!-- header -->
    <div id="global_container">
        <div id="container">
            <main class="main">
                <h2 class="h2">▼プロフィールを入力してください</h2>
                <div class="profile">

                    <div class="form-area">
                        <form action="" method="post">
                            <div class="image">
                            </div>
                            <div class="name">
                                名前：<?= $_SESSION['member']['name']; ?>
                            </div>
                            <div class="age">
                                年齢：
                                <input type="text" name="age" placeholder="年齢を入力してください">
                            </div>
                            <div class="sex">
                                性別：
                                <input type="radio" name="sex" value="男">男性
                                <input type="radio" name="sex" value="女">女性
                            </div>
                            <div class="height">
                                身長：
                                <input type="text" name="height" placeholder="身長を入力してください">
                            </div>
                            <div class="weight">
                                体重：
                                <input type="text" name="weight" placeholder="体重を入力してください">
                            </div>
                            <div class="goal">
                                目標：
                                <input type="radio" name="goal" value="増量">増量したい
                                <input type="radio" name="goal" value="減量">減量したい
                            </div><br>
                            <div class="btn">
                                <input type="submit" name="submit" id="submit" value="保存する">
                            </div>
                        </form>
                    </div>
                </div>
            </main>
            <!-- footer -->
            <?php require_once('footer.html'); ?>
            <!-- footer -->
        </div>
    </div>
    <script type="text/javascript" src="scripts/main.js"></script>

</body>

</html>
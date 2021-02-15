<?php
ini_set('display_errors', "On");
error_reporting(E_ALL & ~E_NOTICE);
require_once('model/User.php');
date_default_timezone_set('Asia/Tokyo');
$user = new User();
$user->dbconnect();
session_start();

// 非ログイン時トップへ飛ばす
if ($_SESSION['login'] !== 'login') {
    header('Location: index.php');
    exit;
}

$userId = $user->getUserId();
$userName = $_SESSION['member']['name'];
$userPosition = $user->getPosition($userId['id']);

if ($_POST) {
    $userName = $_SESSION['member']['name'];
    $height = $_POST['height'] / 100;
    $weight = $_POST['weight'];
    $bmi = $weight / $height / $height;
    $user->updateProfile($bmi, $userId['id'], $userName);
}

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
    <title>プロフィール</title>
    <link rel="icon" type="image/x-icon" href="../images/icon.jpg">
    <link rel="stylesheet" href="styles/display_profile.css">
    <script type="text/javascript" src="scripts/jquery.js"></script>

</head>

<body>
    <div id="global_container">
        <div id="container">
            <!-- header -->
            <?php require_once('header_in.php'); ?>
            <!-- header -->
            <main class="main">
                <h2 class="h2">▼プロフィール</h2>
                <div class="profile-area">
                    <div class="show_profile">
                        <?php
                        $profile = $user->displayProfile($userId['id']);
                        echo '名前：' . $profile['name'] . '<br>';
                        echo '年齢：' . $profile['age'] . '<br>';
                        echo '性別：' . $profile['sex'] . '<br>';
                        echo '身長：' . $profile['height'] . '<br>';
                        echo '体重：' . $profile['weight'] . '<br>';
                        echo 'BMI：' . round($profile['BMI'], 1) . '<br>';
                        echo '目標：' . $profile['goal'] . '<br>';
                        echo '作成日：' . $profile['created_at'] . '<br>';
                        ?>
                        <div class="btn">
                            <p class="edit">編集する</p><br>
                            <a href="mypage.php">マイページへもどる</a>
                        </div>
                    </div>
                    <div class="update_profile update">
                        <?php
                        echo '名前：' . $profile['name'] . '※変更できません' . '<br>';
                        ?>
                        <form action="display_profile.php" method="post">
                            年齢：
                            <input type="text" name="age" value="<?= $profile['age']; ?>"><br>
                            性別：
                            <input type="radio" name="sex" checked="checked" value="男">男性
                            <input type="radio" name="sex" value="女">女性<br>
                            身長：
                            <input type="text" name="height" value="<?= $profile['height']; ?>"><br>
                            体重：
                            <input type="text" name="weight" value="<?= $profile['weight']; ?>"><br>
                            目標：
                            <input type="radio" name="goal" checked="checked" value="増量">増量したい
                            <input type="radio" name="goal" value="減量">減量したい<br><br>
                            <div class="btn">
                                <input type="submit" value="保存"><br>
                                <a href="">キャンセル</a>
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
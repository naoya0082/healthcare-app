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
$date = date('Y-m-d');
$result = $user->checkWeight($userId['id'], $date);
$weight = $user->getWeight($userId['id'], $date);
if ($_POST && $result === 0) {
    if (!is_numeric($_POST['weight'])) {
        $error['number'] = 'number';
    }
    if (empty($error)) {
        $_SESSION['weight'] = $_POST;
        $user->insertWeight($userId['id']);
        header('Location: mypage.php');
        exit;
    }
}
if ($_POST && $result >= 1) {
    if (!is_numeric($_POST['weight'])) {
        $error['number'] = 'number';
    }
    if (empty($error)) {
        $user->updateWeight($userId['id'], $date);
        header('Location: mypage.php');
        exit;
    }
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
    <title>体重を記録</title>
    <link rel="icon" type="image/x-icon" href="../images/icon.jpg">
    <link rel="stylesheet" href="styles/weight_record.css">
    <script type="text/javascript" src="scripts/jquery.js"></script>

</head>

<body>
    <div id="global_container">
        <div id="container">
            <!-- header -->
            <?php require_once('header_in.php'); ?>
            <!-- header -->
            <main class="main">
                <section class="input-area">
                    <?php if ($result >= 1) : ?>
                        <h2 class="h2">▼今日の体重を編集</h2>
                        <div class="form-area">
                            <form action="" method="post" name="update">
                                <input type="text" name="weight" value="<?= $weight['weight'] ?>">
                                <input type="submit" name="submit" id="submit" value="保存する">
                            </form>
                        </div>
                    <?php endif; ?>
                    <?php if ($result === 0) : ?>
                        <h2 class="h2">▼今日の体重を記録</h2>
                        <div class="form-area">
                            <form action="" method="post" name="insert">
                                <input type="text" name="weight" id="weight" placeholder="体重を入力してください">
                                <input type="submit" name="submit" id="submit" value="記録">
                            </form>
                        <?php endif; ?>
                        <?php if ($error['number'] === 'number') : ?>
                            <p class="error">※数字で入力してください</p>
                        <?php endif; ?>
                        <br>
                        <a href="mypage.php">マイページへもどる</a>
                        </div>
                </section>

            </main>
            <!-- footer -->
            <?php require_once('footer.html'); ?>
            <!-- footer -->
        </div>
    </div>
    <script type="text/javascript" src="scripts/main.js"></script>

</body>

</html>
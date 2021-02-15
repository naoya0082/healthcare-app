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


if (isset($_GET['logout'])) {
    $_SESSION['login'] = '';
    $_SESSION['member'] = '';
    header('Location: index.php');
    exit;
}

$year = date('Y');
$month = date('m');
// 月末日を取得
$last_day = date('t', strtotime($year . $month . '01'));

// 日毎のカロリー量を取得
$calorie = [];
for ($day = 1; $day <= $last_day; $day++) {
    $calorie[$day] = $user->total_cal("${year}-${month}-${day}");
}
// 日毎のタンパク質量を取得
$protein = [];
for ($day = 1; $day <= $last_day; $day++) {
    $protein[$day] = $user->total_pr("${year}-${month}-${day}");
}
// 日毎の体重を取得
$weight = [];
for ($day = 1; $day <= $last_day; $day++) {
    $weight[$day] = $user->getWeight($userId['id'], "${year}-${month}-${day}");
}

// 日付情報を取得
$calender = [];
for ($day = 1; $day <= $last_day; $day++) {
    $calender[$day]['day'] = $day;
    $calender[$day]['week'] = date('w', strtotime($year . $month . sprintf('%02d', $day)));
    if (isset($calorie[$day])) {
        $calender[$day]['cal'] = $calorie[$day];
    } else {
        $calender[$day]['cal'] = '';
    }
    if (isset($protein[$day])) {
        $calender[$day]['pr'] = $protein[$day];
    } else {
        $calender[$day]['pr'] = '';
    }
    if (isset($weight[$day])) {
        $calender[$day]['kg'] = $weight[$day];
    } else {
        $calender[$day]['kg'] = '';
    }
}
$week = ['日', '月', '火', '水', '木', '金', '土']; ?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>記録一覧</title>
    <link rel="stylesheet" href="styles/list.css">
    <link rel="icon" type="image/x-icon" href="../images/icon.jpg">
    <script type="text/javascript" src="scripts/jquery.js"></script>
</head>

<body>
    <div id="global_container">
        <div id="container">
            <!-- header -->
            <?php require_once('header_in.php'); ?>
            <!-- header -->
            <main class="main">
                <h2 class="h2">▼<?= date('Y年m月'); ?>の記録▼</h2>
                <div class="table-area">
                    <table>
                        <tr>
                            <th>日付</th>
                            <th>摂取カロリー(kcal)</th>
                            <th>摂取タンパク質(g)</th>
                            <th>体重(kg)</th>
                        </tr>
                        <?php
                        foreach ($calender as $value) {
                            if ($value['day'] != date('j')) { ?>
                                <tr class="week<?= $value['week']; ?>">
                                <?php } else { ?>
                                <tr class="today">
                                <?php } ?>
                                <td>
                                    <?= $value['day'] ?>(<?= $week[$value['week']] ?>)
                                </td>
                                <td><?= round($value['cal']['SUM(calorie)'],1); ?></td>
                                <td><?= round($value['pr']['SUM(protein)'],1); ?></td>
                                <td><?= round($value['kg']['weight'],1); ?></td>
                                </tr>
                            <?php } ?>
                    </table>
                    <a href="mypage.php">マイページへもどる</a>
                </div>
            </main>
        </div>
    </div>
    <!-- footer -->
    <?php require_once('footer.html'); ?>
    <!-- footer -->
    <script type="text/javascript" src="scripts/main.js"></script>
</body>

</html>
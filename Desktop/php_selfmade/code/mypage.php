<?php
ini_set('display_errors', "On");
error_reporting(E_ALL & ~E_NOTICE);
require_once('model/User.php');
date_default_timezone_set('Asia/Tokyo');
$user = new User();
$user->dbconnect();

session_start();
if ($_SESSION['login'] !== 'login') {
    header('Location: login.php');
    exit;
}

if (isset($_GET['del'])) {
    $user->delete($_GET['del']);
    header('Location: mypage.php');
    exit;
}
if (isset($_GET['logout'])) {
    $_SESSION['login'] = '';
    $_SESSION['member'] = '';
    header('Location: index.php');
    exit;
}

$userId = $user->getUserId();
$userName = $_SESSION['member']['name'];
$userPosition = $user->getPosition($userId['id']);
$getBMI = $user->displayProfile($userId['id']);
$profile = $user->checkProfile($userId['id'], $userName);
$display = $user->displayProfile($userId['id']);

// POST送信される前は今日の日付を指定
if ($_POST) {
    $date = $_POST['date'];
} else {
    $date = date('Y-m-d');
}
$_SESSION['date'] = $date;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>マイページ</title>
    <link rel="stylesheet" href="styles/mypage.css">
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
                <div class="main__inner">
                    <div class="message">
                        <?php if ($profile > 0) : ?>
                            <p class="comment">
                                <?= $_SESSION['member']['name'] ?>さんのBMIは「<span><?= round($getBMI['BMI'], 1); ?></span>」です。<br>
                                理想値「<span>22</span>」を目指し頑張りましょう！
                            </p>
                        <?php endif; ?>
                        <?php if ($profile === 0) : ?>
                            <p class="create-profile">
                                まずは<a href="addprofile.php">プロフィール</a>を作成しましょう！
                            </p>
                        <?php endif; ?>
                    </div>
                    <section class="record-area">
                        <div class="today-record">
                            <form action="mypage.php" method="post">
                                <input type="date" name="date" value="<?php
                                                                        if ($_POST) {
                                                                            echo $_POST['date'];
                                                                        } else {
                                                                            echo date('Y-m-d');
                                                                        } ?>">
                                <input type="submit" name="submit" value="更新">
                            </form>
                            <?php
                            // 今日の記録を表示
                            $results = $user->todays_record($date);
                            ?>

                            <div class="table-area">
                                <table class="table">
                                    <tr>
                                        <th>メニュー</th>
                                        <th>カロリー</th>
                                        <th>タンパク質</th>
                                        <th>※編集</th>
                                    </tr>
                                    <?php foreach ($results as $result) : ?>
                                        <tr>
                                            <td><?= htmlspecialchars($result['menu_name'], ENT_QUOTES) . '<br>'; ?></td>
                                            <td><?php $calorie = $user->display_cal($result['menu_name']);
                                                echo $calorie['calorie'] . 'kcal'; ?>
                                            </td>
                                            <td><?php $protein = $user->display_pr($result['menu_name']);
                                                echo $protein['protein'] . 'g'; ?></td>
                                            <td>
                                                <a class="del" href="?del=<?= $result['id'] ?>">削除</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>

                                    <?php
                                    // カロリーの合計を表示
                                    $total_cal = $user->total_cal($date);
                                    // タンパク質の合計を表示
                                    $total_pr = $user->total_pr($date); ?>
                                    <tr>
                                        <td class="total">合計</td>
                                        <!-- カロリーの合計値を表示 -->
                                        <td class="total">
                                            <?php echo $total_cal['SUM(calorie)'] . 'kcal' ?>
                                        </td>
                                        <!-- タンパク質の合計値を表示 -->
                                        <td class="total">
                                            <?php echo round($total_pr['SUM(protein)'], 1) . 'g' ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="goal-message">
                            <?php
                            $calorie = $user->total_cal($date);
                            $protein = $user->total_pr($date);
                            if ($display['goal'] === '増量') : ?>

                            <?php
                                $ass_cal = 3000 - $calorie['SUM(calorie)'];
                                $ass_pr = 120 - $protein['SUM(protein)'];
                                if ($ass_cal > 0) {
                                    echo 'カロリー：';
                                    echo round($ass_cal, 1) . 'kcal不足しています' . '<br>';
                                } elseif ($ass_cal < 0) {
                                    echo 'カロリー：';
                                    echo '目標達成です！' . '<br>';
                                } else {
                                    echo 'カロリー：';
                                    echo '最適な摂取量です！' . '<br>';
                                }
                                if ($ass_pr > 0) {
                                    echo 'タンパク質：';
                                    echo round($ass_pr, 1) . 'g不足しています' . '<br>';
                                } elseif ($ass_pr < 0) {
                                    echo 'タンパク質：';
                                    echo '目標達成です！' . '<br>';
                                } else {
                                    echo 'タンパク質：';
                                    echo '最適な摂取量です！' . '<br>';
                                }
                            endif; ?>

                            <?php
                            if ($display['goal'] === '減量') : ?>

                            <?php
                                $ass_cal = 2000 - $calorie['SUM(calorie)'];
                                $ass_pr = 60 - $protein['SUM(protein)'];
                                if ($ass_cal > 0) {
                                    echo 'カロリー：';
                                    echo round($ass_cal, 1) . 'kcal不足しています' . '<br>';
                                } elseif ($ass_cal < 0) {
                                    echo 'カロリー：';
                                    echo round(abs($ass_cal), 1) . 'kcalオーバーです' . '<br>';
                                } else {
                                    echo 'カロリー：';
                                    echo '最適な摂取量です！' . '<br>';
                                }
                                if ($ass_pr > 0) {
                                    echo 'タンパク質：';
                                    echo round($ass_pr, 1) . 'g不足しています' . '<br>';
                                } elseif ($ass_pr < 0) {
                                    echo 'タンパク質：';
                                    echo round(abs($ass_pr), 1) . 'gオーバーです' . '<br>';
                                } else {
                                    echo 'タンパク質：';
                                    echo '最適な摂取量です！' . '<br>';
                                }
                            endif; ?>

                        </div>
                        <!-- 今日の体重を表示 -->
                        <div class="weight-area">
                            <div class="text">
                                <?php echo '体重' ?>
                            </div>
                            <div class="weight">
                                <?php
                                $weight = $user->getWeight($userId['id'], $date);
                                echo round($weight['weight'], 1) . 'kg';
                                ?>
                            </div>
                        </div>
                        <a href="graph.php">グラフで確認する</a>
                    </section>

                    <div class="btn-area">
                        <div class="btn">
                            <a class="record" href="record.php">登録済みメニューから記録</a>
                        </div>
                        <div class="btn">
                            <a class="record" href="weight_record.php">今日の体重を記録</a>
                        </div>
                        <div class="list">
                            <a class="list" href="list.php">記録一覧</a>
                        </div>
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
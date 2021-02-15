<?php
ini_set('display_errors', "On");
error_reporting(E_ALL & ~E_NOTICE);
require_once('model/User.php');
$user = new User();
$user->dbconnect();

session_start();
// 非ログイン時トップへ飛ばす
if ($_SESSION['login'] !== 'login') {
    header('Location: index.php');
    exit;
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
    <title>記録内容の確認</title>
    <link rel="icon" type="image/x-icon" href="../images/icon.jpg">
    <link rel="stylesheet" href="styles/record_check.css">
    <script type="text/javascript" src="scripts/jquery.js"></script>

</head>

<body>

    <div id="global_container">
        <div id="container">
            <!-- header -->
            <?php require_once('header_in.php'); ?>
            <!-- header -->
            <main class="main">
                <h2 class="h2">▼この内容で保存しますか？</h2>

                <div class="check-area">
                    <!-- <p class="text">選んだ食材</p> -->
                    <?php
                    // 栄養素の情報を取得
                    if ($_POST['checkbox']) : ?>
                        <div class="form-area">
                            <?php $elements = $user->check_elements(); ?>
                            <div class="menu">
                                <?php echo '■' . htmlspecialchars($_POST['checkbox'], ENT_QUOTES) . '■' . '<br>'; ?>
                            </div>
                            <?php echo '(カロリー:' . $elements['calorie'] . 'kcal, ' . 'タンパク質:' . $elements['protein'] . 'g)' . '<br>'; ?>
                            <form action="record_done.php" method="post">
                                <input type="hidden" name="menu_name" value="<?= $_POST['checkbox']; ?>"><br>
                                <input type="submit" id="submit" value="保存する">
                            </form>
                        </div>
                    <?php endif; ?>
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
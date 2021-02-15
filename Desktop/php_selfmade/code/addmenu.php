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

if (!empty($_POST)) {
    if (mb_strlen($_POST['menu_name']) > 10) {
        $error['menu_name'] = 'over';
    }
    if (mb_strlen($_POST['menu_name']) < 1) {
        $error['menu_name'] = 'blank';
    }
    if (!is_numeric($_POST['calorie'])) {
        $error['calorie'] = 'num';
    }
    if (!is_numeric($_POST['protein'])) {
        $error['protein'] = 'num';
    }
    if (empty($error)) {
        $_SESSION['menu'] = $_POST;
        header('Location: record.php');
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
    <title>メニュー新規登録</title>
    <link rel="icon" type="image/x-icon" href="../images/icon.jpg">
    <link rel="stylesheet" href="styles/addmenu.css">
    <script type="text/javascript" src="scripts/jquery.js"></script>

</head>

<body>
    <div id="global_container">
        <div id="container">
            <!-- header -->
            <?php require_once('header_in.php'); ?>
            <!-- header -->
            <main class="main">
                <h2 class="h2">▼追加したいメニュー情報を入力してください</h2>
                <div class="addmenu-area">
                    <div class="form-area">
                        <form action="" method="post">
                            <p>メニュー名：</p>
                            <input type="text" name="menu_name" id="menu_name" value="<?= htmlspecialchars($_POST['menu_name'], ENT_QUOTES); ?>">
                            <?php if ($error['menu_name'] === 'over') : ?>
                                <p class="error">※10文字以内で設定してください</p>
                            <?php endif; ?>
                            <?php if ($error['menu_name'] === 'blank') : ?>
                                <p class="error">※メニュー名を入力してください</p>
                            <?php endif; ?>
                            <p>カロリー：</p>
                            <input type="text" name="calorie" id="calorie" value="<?= htmlspecialchars($_POST['calorie'], ENT_QUOTES); ?>">
                            <?php if ($error['calorie'] === 'num') : ?>
                                <p class="error">※数字で入力してください</p>
                            <?php endif; ?>
                            <p>タンパク質：</p>
                            <input type="text" name="protein" id="protein" value="<?= htmlspecialchars($_POST['protein'], ENT_QUOTES); ?>"><br>
                            <?php if ($error['protein'] === 'num') : ?>
                                <p class="error">※数字で入力してください</p>
                            <?php endif; ?>
                            <p class="category">カテゴリー：</p>
                            <select name="category" id="category">
                                <option value="メニュー">メニュー</option>
                                <option value="肉">肉</option>
                                <option value="野菜">野菜</option>
                            </select>
                            <div class="add-menubtn">
                                <input type="submit" value="登録する">
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
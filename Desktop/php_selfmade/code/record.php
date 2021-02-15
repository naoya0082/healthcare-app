<?php
ini_set('display_errors', "On");
error_reporting(E_ALL & ~E_NOTICE);
require_once('model/User.php');
$user = new User();
$user->dbconnect();

session_start();
$userId = $user->getUserId();
$userName = $_SESSION['member']['name'];
$userPosition = $user->getPosition($userId['id']);

// 非ログイン時トップへ飛ばす
if ($_SESSION['login'] !== 'login') {
    header('Location: index.php');
    exit;
}

if ($_SESSION['menu']) {
    $user->addmenu();
    unset($_SESSION['menu']);
}
if (!empty($_POST)) {
    $error['choice'] = 'blank';
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
    <title>今日の記録</title>
    <link rel="icon" type="image/x-icon" href="../images/icon.jpg">
    <link rel="stylesheet" href="styles/record.css">
    <script type="text/javascript" src="scripts/jquery.js"></script>

</head>

<body>
    <div id="global_container">
        <div id="container">
            <!-- header -->
            <?php require_once('header_in.php'); ?>
            <!-- header -->
            <main class="main">
                <h2 class="h2">▼登録するメニューを選択してください</h2>
                <div class="record-area">
                    <!-- ユーザー情報取得 -->
                    <?php
                    if ($_POST) {
                        $category = $_POST['category'];
                        $menus = $user->display($category);
                    } else {
                        // 初期画面ではカテゴリー=メニューを表示
                        $menus = $user->display($category = 'メニュー');
                    }
                    ?>
                    <div class="form-area">
                        <form method="post">
                            カテゴリーを選択：
                            <select name="category" id="category">
                                <option value="メニュー">メニュー</option>
                                <option value="肉">肉</option>
                                <option value="野菜">野菜</option>
                            </select>
                            <input type="submit" formaction="record.php" value="表示">
                            <table>
                                <tr>
                                    <th>選択</th>
                                    <th>メニュー</th>
                                    <th>カロリー</th>
                                    <th>タンパク質</th>
                                    <th>カテゴリー</th>
                                </tr>
                                <?php foreach ($menus as $menu) : ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox" value="<?= htmlspecialchars($menu['menu_name'], ENT_QUOTES); ?>"></td>
                                        <td><?= htmlspecialchars($menu['menu_name'], ENT_QUOTES); ?></td>
                                        <td><?= htmlspecialchars($menu['calorie'], ENT_QUOTES) . 'kcal'; ?></td>
                                        <td><?= htmlspecialchars($menu['protein'], ENT_QUOTES) . 'g'; ?></td>
                                        <td><?= htmlspecialchars($menu['category'], ENT_QUOTES); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <div class="btn"><br>
                                <input type="submit" formaction="record_check.php" value="確認する"><br>
                                <a href="addmenu.php">メニュー新規登録</a>
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
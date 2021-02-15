<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles/header_in.css">
</head>
<header class="header">
    <div class="header__inner">
        <div class="logo">
            <a href="index.php"><img src="../images/logo.jpg" alt="logo"></a>
        </div>
        <div class="menu">
            <?php if ($userPosition['position'] === 'owner') : ?>
                <a class="owner" href="owner.php">管理者ページ</a>
                |
            <?php endif; ?>
            <a href="mypage.php"><?= htmlspecialchars($_SESSION['member']['name'], ENT_QUOTES) . 'さん'; ?></a>
            |
            <a href="index.php">トップページ</a>
            |
            <?php
            if ($user->checkProfile($userId['id'], $userName) > 0) : ?>
                <a href="display_profile.php">プロフィール</a>
                |
            <?php endif; ?>
            <?php if ($user->checkProfile($userId['id'], $userName) === 0) : ?>
                <a href="addprofile.php">プロフィール</a>
                |
            <?php endif; ?>
            <a href="list.php">わたしの記録</a>
            |
            <a class="logout" href="?logout">ログアウト</a>
        </div>
    </div>
</header>

</html>
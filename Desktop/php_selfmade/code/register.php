<?php
session_start();

if (!empty($_POST)) {

    if ($_POST['name'] === '') {
        $error['name'] = 'empty';
    }
    if (mb_strlen($_POST['name']) >= 10) {
        $error['name'] = 'over';
    }
    if (strpos($_POST['email'], '@') === false) {
        $error['email'] = 'addres';
    }
    if (mb_strlen($_POST['password']) < 6) {
        $error['password'] = 'length';
    }
    if ($_POST['password'] != $_POST['check']) {
        $error['password'] = 'check';
    }
    if (empty($error)) {
        $_SESSION['check'] = $_POST;
        header('Location: check.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>新規登録</title>
    <link rel="icon" type="image/x-icon" href="../images/icon.jpg">
    <link rel="stylesheet" href="styles/register.css">
</head>

<body>
    <div id="global_container">
        <div id="container">
            <!-- header -->
            <?php require_once('header.html'); ?>
            <!-- header -->
            <main class="main">
                <div class="adduser">
                    <div class="text-area">
                        <h2 class="h2"><p>「CalReco」へ新規登録します。</p></h2>
                        <span>※の項目は必須項目です。</span>
                    </div>
                    <section class="form-area">
                        <form action="" method="POST">
                            <p class="text">名前<span>※</span></p>
                            <input type="text" size="30" name="name" id="name" value="<?= $_POST['name'] ?>">
                            <?php if ($error['name'] === 'empty') : ?>
                                <p class="error">※名前を入力してください</p>
                            <?php endif; ?>
                            <?php if ($error['name'] === 'over') : ?>
                                <p class="error">※10文字以下で入力してください</p>
                            <?php endif; ?>
                            <p class="text">メールアドレス<span>※</span></p>
                            <input type="text" size="30" name="email" id="email" value="<?= $_POST['email']; ?>">
                            <?php if ($error['email'] === 'addres') : ?>
                                <p class="error">※正しいメールアドレスを入力してください</p>
                            <?php endif; ?>
                            <p class="text">パスワード<span>※</span></p>
                            <input type="password" size="30" name="password" id="password" value="">
                            <?php if ($error['password'] === 'length') : ?>
                                <p class="error">※6文字以上で設定してください</p>
                            <?php endif; ?>
                            <p class="text">パスワード(確認)<span>※</span></p>
                            <input type="password" size="30" name="check" id="check" value="">
                            <?php if ($error['password'] === 'check') : ?>
                                <p class="error">※パスワードが一致しません</p>
                            <?php endif; ?>
                            <br>
                            <br>
                            <input type="submit" name="subnit" id="submit" value="内容を確認する">
                        </form>
                    </section>

                </div>
            </main>
            <!-- footer -->
            <?php require_once('footer.html'); ?>
            <!-- footer -->
        </div>
    </div>
</body>

</html>
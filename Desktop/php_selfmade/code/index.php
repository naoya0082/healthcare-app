<?php
ini_set('display_errors', "On");
error_reporting(E_ALL & ~E_NOTICE);
require_once('model/User.php');
$user = new User();
$user->dbconnect();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CalReco</title>
    <link rel="icon" type="image/x-icon" href="../images/icon.jpg">
    <link rel="stylesheet" href="styles/index.css">
</head>

<body>
    <div id="global_container">
        <div class="menu-sp">
            <a class="register" href="register.php">新規登録する</a><br><br>
            <a class="mypage" href="mypage.php">ログイン</a>
        </div>
        <div id="container">
            <!-- header -->
            <?php require_once('header.html'); ?>
            <!-- header -->
            <main class="main">
                <div class="main__inner">
                    <section class="explanetion">
                        <div class="explanetion__inner">
                            <div class="text">
                                <h2 class="h2">あなたの食事<br>見直してみませんか？</h2>
                                <p>CalRecoは、PCやスマホで簡単に食事を管理することができます。<br>
                                    普段気にしない栄養素を数値化し、<br>
                                    より一層理想の身体に近づきましょう！
                                </p>
                            </div>
                        </div>
                        <div class="btn">
                            <a class="register" href="register.php">新規登録する</a>
                            <a class="mypage" href="mypage.php">ログイン</a>
                        </div>
                    </section>
                    <section class="description">
                        <div class="service">
                            <p class="text">食事管理できる完全無料サービス</p>
                            <div class="image">
                                <div class="man-image">
                                    <img src="../images/syokuji_gehin.jpg" alt="">
                                </div>
                                <div class="graph-image">
                                    <img src="../images/graph.jpg" alt="">
                                </div>
                                <div class="woman-image">
                                    <img src="../images/syokuji_girl.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="contents">
                            <p class="text">カロリーや栄養素を自動計算</p>
                            <div class="image">
                                <div class="woman-image">
                                    <img src="../images/syokuji_girl.jpg" alt="">
                                </div>
                                <div class="dentaku-image">
                                    <img src="../images/bunbougu_dentaku.jpg" alt="">
                                </div>
                                <div class="man-image">
                                    <img src="../images/syokuji_gehin.jpg" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="registration">
                            <p class="text">簡単な会員登録ですぐに利用できる</p>
                            <div class="image">

                                <div class="man-image">
                                    <img src="../images/syokuji_gehin.jpg" alt="">
                                </div>
                                <div class="done-image">
                                    <img src="../images/done.jpg" alt="">
                                </div>
                                <div class="woman-image">
                                    <img src="../images/syokuji_girl.jpg" alt="">
                                </div>
                            </div>
                        </div>
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
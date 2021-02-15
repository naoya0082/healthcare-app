<!-- <?php
ini_set('display_errors', "On");
require_once('model/User.php');
$user = new User();
$user->dbconnect();

session_start();
$_SESSION['login'] = '';
$_SESSION['member'] = '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="styles/logout.css">
</head>
<body>
    <div id="global_container">
        <div id="container">
            <?php require_once('header.html'); ?>
            <main class="main">
                <div class="logout-message">
                    <p class="message">ログアウトしました</p>
                </div>
            </main>
            <?php require_once('footer.html'); ?>
        </div>
    </div>
</body>
</html> -->
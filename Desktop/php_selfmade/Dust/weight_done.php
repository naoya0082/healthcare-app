<!-- <?php
ini_set('display_errors', "On");
error_reporting(E_ALL & ~E_NOTICE);
require_once('model/User.php');
date_default_timezone_set('Asia/Tokyo');

session_start();
$user = new User();
$user->dbconnect();
$userId = $user->getUserId();
$user->insertWeight($userId['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>体重チェック</title>
</head>
<body>
    記録しました
    <a href="mypage.php">マイページへ</a>
</body>
</html> -->
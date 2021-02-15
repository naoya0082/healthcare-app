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
$year = date('Y');
$month = date('m');

$last_day = date('t', strtotime($year . $month . '01'));

// --------------------------------------
require_once('../jpgraph-4.3.4/src/jpgraph.php');
require_once('../jpgraph-4.3.4/src/jpgraph_bar.php');
// 縦軸のデータ
$calorie = [];
$result = [];
for ($day = 0; $day < $last_day; $day++) {
    $calorie[$day] = $user->total_cal("${year}-${month}-${day}");
    $result[$day-1] = $calorie[$day]['SUM(calorie)'];
}
// print_r($result);
$x_data = $result;
// グラフの生成
$graph = new Graph(900, 500);
$graph->SetScale('textlin');

$graph->SetMarginColor('white');
// タイトル
$graph->title->Set('Calorie');
// グラフ表示
$bar = new BarPlot($x_data);
$bar->value->Show();
$graph->Add($bar);
$graph->Stroke();
// ---------------------------------------
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>

</body>

</html>
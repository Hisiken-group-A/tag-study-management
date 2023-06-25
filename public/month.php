<?php

require_once '../config/dbconnect.php'; 
require_once '../class/Tag.php';

$pdo = connect();

$stmt = $pdo->query("SELECT * FROM study_time WHERE date BETWEEN '2023-06-01' AND '2023-06-31'");
$studies = $stmt->fetchAll();

$total = 0;

foreach ($studies as $study_time) {
    $total += (int)$study_time["study_time"];
}

$hour = floor($total / 60);
$minuits = $total % 60;

echo $hour . "h" . $minuits . "m";

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAG-STUDY-MANAGEMENT</title>
</head>
<body>
<div class="tab">
    <ul class="tab_menu">
        <li class="Index"><a href="index.php">入力</a></li>
        <li class="Graph"><a href="graph.php">グラフ</a></li>
        <li class="Week"><a href="week.php">週</a></li>
        <li class="Month"><a href="month.php">月</a></li>
    </ul>
</div>
<div id="next_back_button">
    <button id="back" onclick="back()"><</button>
    <button id="next" onclick="next()">></button>
</div>
<div id="calendar"></div>
<script src="../js/month.js"></script>
</body>
</html>
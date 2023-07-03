<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>グラフ（週）</title>
    <!-- <link rel="stylesheet" href="../css/common.css"> -->
</head>
<body>
<?php include('../inc/tab.php'); ?>

<div id="next_back_button">
    <button id="back" onclick="back()"><</button>
    <button id="next" onclick="next()">></button>
    <span id="Sunday"></span>ー<span id="Saturday"></span>
</div>
<canvas id="graph_bar" class="graph_class_bar"></canvas>
<canvas id="graph_pie" class="graph_class_pie"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../js/graph_week.js"></script>
</body>
</html>
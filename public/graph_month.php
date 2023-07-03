<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>グラフ（月）</title>
    <!-- <link rel="stylesheet" href="../css/common.css"> -->
</head>
<body>
<?php include('../inc/tab.php'); ?>

<div id="next_back_button">
    <button id="back_graph_month" onclick="back_graph_month()"><</button>
    <button id="next_graph_month" onclick="next_graph_month()">></button>
</div>

<div id="MonthCount"></div>

<canvas id="graph" class="graph_class"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../js/graph_month.js"></script>
</body>
</html>
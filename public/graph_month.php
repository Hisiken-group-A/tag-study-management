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
    <button id="back" onclick="back()"><</button>
    <button id="next" onclick="next()">></button>
</div>
<canvas id="graph" class="graph_class" width="100" height="50"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../js/graph_week.js"></script>
</body>
</html>
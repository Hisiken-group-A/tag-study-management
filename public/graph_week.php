<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>グラフ（週）</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/graph_week.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Edu+VIC+WA+NT+Beginner&family=M+PLUS+1&family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="../css/common.css"> -->
</head>
<body>
<?php include('../inc/tab.php'); ?>

<div class="main">
<div id="next_back_button">
    <button id="back_graph_week" onclick="back_graph_week()">＜</button>
    <div id="Sunday_Saturday"></div>
    <button id="next_graph_week" onclick="next_graph_week()">＞</button>
</div>

<div class="graph-G">
<canvas id="graph_bar" class="graph_class_bar"></canvas>
<canvas id="graph_pie" class="graph_class_pie"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../js/graph_week.js"></script>
</div>
</div>
</body>
</html>
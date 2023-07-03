<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAG-STUDY-MANAGEMENT</title>
    <!-- <link rel="stylesheet" href="../css/common.css"> -->
</head>
<body>
<div class="tab">
            <ul class="tab_menu">
                <li class="Index"><a href="index.php">入力</a></li>
                <li class="Graph"><a href="graph_week.php">週グラフ</a></li>
                <li class="Week"><a href="graph_month.php">月グラフ</a></li>
                <li class="Month"><a href="month.php">月</a></li>
            </ul>
</div>

<div id="next_back_button">
    <button id="back_graph_month" onclick="back_graph_month()"><</button>
    <button id="next_graph_month" onclick="next_graph_month()">></button>
</div>

<div id="MonthCount">
</div>
<canvas id="graph" class="graph_class"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="../js/graph_month.js"></script>
</body>
</html>
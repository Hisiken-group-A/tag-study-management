<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAG-STUDY-MANAGEMENT</title>
    <link rel="stylesheet" href="../css/month.css">
</head>
<body>
<div class="tab">
    <ul class="tab_menu">
        <li class="Index"><a href="index.php">入力</a></li>
        <li class="Graph_week"><a href="graph.php">週グラフ</a></li>
        <li class="Graph_month"><a href="week.php">月グラフ</a></li>
        <li class="Month"><a href="month.php">月</a></li>
    </ul>
</div>
<div id="next_back_button">
    <button id="back" onclick="back()"><</button>
    <button id="next" onclick="next()">></button>
</div>
<div id="calendar"></div>
<div id="total"></div>
<script src="../js/month.js"></script>
</body>
</html>
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
<form>
<div class="radio_check">
    <input type="radio" name="graph" value="week" onclick="select_check()" checked>
    <label class = "radio_check_label">週</label>
</div>
<div class="radio_check">
    <input type="radio" name="graph" value="month" onclick="select_check()">
    <label class = "radio_check_label">月</label>
</div>
</form>

<div id="select_week">
    <li>週出力</li>
</div>
<div id="select_month">
    <li>月出力</li>
</div>

<script src="../js/graph.js"></script>
</body>
</html>
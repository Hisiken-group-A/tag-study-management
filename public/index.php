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
<form action="tag_name.php" method="post" name="tag_name">
                タグの追加
                <br><input type="text" name="tag_add" placeholder="例）数学"><br>
                勉強時間入力
                <br><input type="text" name="tag_study" placeholder="例）数学">
                <input type="number" name="hour" min="0" max="23">h
                <input type="number" name="minute" min="0" max="59">m<br>
                <input type="submit" value="決定">
            </form>
</body>
</html>
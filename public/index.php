<?php

require_once '../config/dbconnect.php'; 

$pdo = connect();

//タグ追加フォームを打ち込んだとき
if (!empty($_POST['add_tag_button'])) {
    try {
        $stmt = $pdo->prepare("INSERT INTO tag (tag_name) VALUES (:title)");
        $stmt->bindValue('title', $_POST['tag_name'], \PDO::PARAM_STR);//(文字列として)
        $stmt->execute();

        header('Location: index.php');
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

$stmt = $pdo->query("SELECT * FROM tag");
$tags = $stmt->fetchAll();

//日本の東京時間に設定
date_default_timezone_set("Asia/Tokyo");

//勉強時間入力フォームを打ち込んだとき
if (!empty($_POST['tag_name']) && !empty($_POST['hour']) && !empty($_POST['minute'])) {
    try {
        $tag_id = $_POST['tag_name'];
        $date = $_POST['date'];
        
        //○時間○分を○分間に変換
        $minute_time = (int)$_POST['hour'] * 60 + (int)$_POST['minute'];
        $minute_time = (string)$minute_time;

        $sql = "INSERT INTO study_time (study_time, date, tag_id) VALUES (:study_time, :date, :tag_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':study_time', $minute_time, PDO::PARAM_STR); //文字列として
        $stmt->bindValue(':date', $date, PDO::PARAM_STR);
        $stmt->bindValue(':tag_id', $tag_id, PDO::PARAM_STR); 
        $stmt->execute();

        header('Location: index.php');
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} 

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAG-STUDY-MANAGEMENT</title>
    <link rel="stylesheet" href="../css/index.css">
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

<!-- タグ追加フォーム -->
<form method="post">
    タグの追加
    <br><input type="text" id="intext" name="tag_name"><br>
    <input type="submit" name="add_tag_button" value="追加">
</form>
<!-- 勉強時間入力フォーム -->
<form action="#" method="post" name="a">
    勉強時間入力
    <select name="tag_name">
        <option value="">タグを選択</option>
        <?php foreach($tags as $tag): ?>
        <option value="<?php echo $tag['id']; ?>"><?php echo $tag['tag_name']; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="hidden" name="date" value="<?php echo date("Y-m-d H:i:s"); ?>">
    <input type="number" name="hour" min="0" max="23">h
    <input type="number" name="minute" min="0" max="59">m
    <br>
    <input type="submit" value="決定">
</form>
<a href="./edit.html">編集画面へ移動（確認用）</a>

</body>
</html>
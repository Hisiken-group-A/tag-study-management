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
    <title>編集ページ</title>
    <!-- <link rel="stylesheet" href="../css/common.css"> -->
</head>
<body>
<?php include('../inc/tab.php'); ?>

<h1>編集</h1>
<!-- 勉強時間入力フォーム -->
<form action="#" method="post" name="a">
    勉強時間入力
    <br>
    <select name="tag_name">
        <option value="">タグを選択</option>
        <?php foreach($tags as $tag): ?>
        <option value="<?php echo $tag['id']; ?>"><?php echo $tag['tag_name']; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="hidden" name="date" value="<?php echo date("Y-m-d H:i:s"); ?>">
    <input type="number" name="hour" value="0" min="0" max="23"required>h
    <input type="number" name="minute" value="0" min="0" max="59" required>m
    <br>
    <button type="button" onclick="window.history.back();" >戻る</button>
    <input type="submit" value="決定">
</form>

</body>
</html>
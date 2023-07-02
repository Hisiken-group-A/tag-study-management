<?php

require_once '../config/dbconnect.php'; 

$pdo = connect();

$stmt = $pdo->query("SELECT * FROM tag");
$tags = $stmt->fetchAll();

//日本の東京時間に設定
date_default_timezone_set("Asia/Tokyo");

//エラー変数
$error_message = "";

//勉強時間変更
if (!empty($_POST['tag_name'])) {
    if ($_POST['hour'] == 0 && $_POST['minute'] == 0) {
        //エラーメッセージ
        $error_message = "0h0mは入力できません";
    } else {
        try {
            $tag_id = $_POST['tag_name'];
            // $date = $_POST['date'];
            
            //○時間○分を○分間に変換
            $minute_time = (int)$_POST['hour'] * 60 + (int)$_POST['minute'];
            $minute_time = (string)$minute_time;
    
            $sql = "UPDATE study_time SET study_time = :study_time, tag_id = :tag_id WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':study_time', $minute_time, PDO::PARAM_STR); //文字列として
            $stmt->bindValue(':tag_id', $tag_id, PDO::PARAM_STR); 
            $stmt->bindValue(':id', 14);
            $stmt->execute();
    
            header('Location: edit.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST</title>
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
<h3>編集</h3>
<!-- 勉強時間入力フォーム -->
<form action="edit.php" method="post" name="a">
    勉強時間入力
    <br>
    <select name="tag_name">
        <option value="">タグを選択</option>
        <?php foreach($tags as $tag): ?>
        <option value="<?php echo $tag['id']; ?>"><?php echo $tag['tag_name']; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="hidden" name="date" value="<?php echo date("Y-m-d H:i:s"); ?>">
        <input type="number" name="hour" value="<?php echo isset($_POST['hour']) ? $_POST['hour'] : "0"; ?>" min="0" max="23" required="required">h
        <input type="number" name="minute" value="<?php echo isset($_POST['minute']) ? $_POST['minute'] : "0"; ?>" min="0" max="59" required="required">m
        <br>
        <!-- エラーメッセージ表示 -->
        <div class="error_message">
            <?php if (mb_strlen($error_message) > 0) : ?>
                <p>0h0mは入力できません</p>
            <?php endif; ?>
        </div>
        <input type="submit" value="決定">
</form>

</body>
</html>
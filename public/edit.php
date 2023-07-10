<?php

require_once '../config/dbconnect.php'; 
require_once '../class/Tag.php';

$pdo = connect();
$tag = new Tag($pdo);
$tag->process_post();
$tags = $tag->get_tag();

//変更部分の勉強時間を抽出し◯h◯mに変換
$study_id = $_GET['id'];
$study_hour = "";
$study_mimute = "";
// 勉強時間情報を取得
$stmt = $pdo->query("SELECT study_time,tag_id FROM study_time WHERE id = $study_id");
$study_datas = $stmt->fetchAll();
foreach ($study_datas as $study_data) {
    $study_time = $study_data['study_time'];
    $study_id =  $study_data['tag_id'];
}
$study_hour = number_format(floor((int)$study_time / 60), 0);
$study_mimute = number_format((int)$study_time % 60, 0);

// idからタグ名を取得
$stmt = $pdo->query("SELECT tag_name,id FROM tag WHERE id = $study_id");
$study_tags = $stmt->fetchAll();
foreach ($study_tags as $study_tag) {
    $study_tag_id = $study_tag['id'];
    $study_tag_name = $study_tag['tag_name'];
}

//日本の東京時間に設定
date_default_timezone_set("Asia/Tokyo");

//エラー変数
$error_message = "";

//勉強時間変更
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['hour'] == 0 && $_POST['minute'] == 0) {
        //エラーメッセージ
        $error_message = "0h0mは入力できません";
    } else {
        try {
            $id = $_POST['id'];
            $tag_id = $_POST['tag_name'];
            
            //○時間○分を○分間に変換
            $minute_time = (int)$_POST['hour'] * 60 + (int)$_POST['minute'];
            $minute_time = (string)$minute_time;
    
            $sql = "UPDATE study_time SET study_time = :study_time, tag_id = :tag_id WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':study_time', $minute_time, PDO::PARAM_STR); //文字列として
            $stmt->bindValue(':tag_id', $tag_id, PDO::PARAM_STR); 
            $stmt->bindValue(':id', $id);
            $stmt->execute();
    
            header('Location: month.php');
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
    <title>編集ページ</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/edit.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Edu+VIC+WA+NT+Beginner&family=M+PLUS+1&family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="../css/common.css"> -->
</head>
<body>
<?php include('../inc/tab.php'); ?>

<div class="main">
<h1>編集</h1>
<!-- 勉強時間入力フォーム -->
<form  method="post" name="a">
    <h3>勉強時間入力</h3>
    <br>
    <div class="in">
    <select name="tag_name" id="intext">
        <option value="<?php echo $study_tag_id; ?>"><?php echo $study_tag_name; ?></option>
        <?php foreach($tags as $tag): ?>
        <option value="<?php echo $tag['id']; ?>"><?php echo $tag['tag_name']; ?></option>
        <?php endforeach; ?>
    </select>

    <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
    <input type="hidden" name="date" value="<?php echo date("Y-m-d H:i:s"); ?>">
    <input type="number" name="hour" value="<?php echo $study_hour ?>" min="0" max="23" required="required" id="time">
    <a href="" id="time_h">h</a>
    <input type="number" name="minute" value="<?php echo $study_mimute ?>" min="0" max="59" required="required" id="time">
    <a href=""  id="time_m">m</a>
    <br>
    <!-- エラーメッセージ表示 -->
    <div class="error_message"><?php echo $error_message; ?></div>
    <input type="submit" value="決定" id="btn">
    </div>
</form>
</div>

</body>
</html>
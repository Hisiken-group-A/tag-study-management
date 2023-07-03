<?php

require_once '../config/dbconnect.php'; 
require_once '../class/Tag.php';

$pdo = connect();
$tag = new Tag($pdo);
$tag->process_post();
$tags = $tag->get_tag();

//日本の東京時間に設定
date_default_timezone_set("Asia/Tokyo");

//エラー変数
$error_message = "";

//勉強時間入力フォームを打ち込んだとき
if (!empty($_POST['tag_name'])) {
    if ($_POST['hour'] == 0 && $_POST['minute'] == 0) {
        //エラーメッセージ
        $error_message = "0h0mは入力できません";
    } else {
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
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TAG-STUDY-MANAGEMENT</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/index.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Edu+VIC+WA+NT+Beginner&family=M+PLUS+1&family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
</head>
<body>

<?php include('../inc/tab.php'); ?>

<div class="box">
    <div class="top"></div>
    <div class="bottom"></div>
    <div class="left"></div>
    <div class="right"></div>
</div>

<div class="main">
    <!-- タグ追加フォーム -->
    <form action="?action=add_tag" method="post">
        <h3>タグの追加</h3>
        <input type="text" id="intext" name="tag_name">
        <input type="submit" id="btn" value="追加">
    </form>

    <br>
    <br>
    <!-- タグ編集・削除フォーム -->
    <form action="?action=change_or_delete" method="post">
        <h3>タグの削除/変更</h3>
        <!-- タグ削除フォーム-->
        <div class ="tag_ya">
        <select id="intext" class="tag_edit_select" name="tag_id">
            タグを選択
            <option value="" >タグを選択</option>
            <?php  foreach($tags as $tag): ?>
            <option value=" <?php echo $tag['id']; ?>"><?php echo $tag['tag_name']; ?> </option>
            <?php endforeach; ?>
        </select>
        <input type="submit" value="削除" name="change_or_delete" id="btn">
        </div>
    </form>

    <!-- タグ編集フォーム -->
    <form action="?action=change_or_delete" method="post">
        <div class="edit_modal_open_button">変更</div>
        <!-- モーダル本体 -->
        <div class="edit_modal">
            <div class="edit_modal_container">
                <!-- モーダルを閉じるボタン -->
                <div class="edit_modal_close">×</div>
                <!-- モーダル内部のコンテンツ -->
                <div class="edit_modal_content">
                    <input type="submit" value="変更" name="change_or_delete" id="btn">
                </div>
            </div>
        </div>
    </form>
  
    <br>
    <br>
    <br>
    <br>

    <!-- 勉強時間入力フォーム -->
    <form action="index.php" method="post" name="a">
        <h3>勉強時間入力</h3>
        <div class="time_ya">
        <select name="tag_name" id="intext">
            <option value="">タグを選択</option>
            <?php foreach($tags as $tag): ?>
            <option value="<?php echo $tag['id']; ?>" ><?php echo $tag['tag_name']; ?></option>
            <?php endforeach; ?>
        </select>
      
        <input type="hidden" name="date" value="<?php echo date("Y-m-d H:i:s"); ?>">
        <input type="number" name="hour" value=" <?php echo isset($_POST['hour']) ? $_POST['hour'] : "0"; ?>" min="0" max="23" required="required" id="time">
        <a href="" id="time_h">h</a>
        <input type="number" name="minute" value="<?php echo isset($_POST['minute']) ? $_POST['minute'] : "0"; ?>" min="0" max="59" required="required" id="time">
        <a href=""  id="time_m">m</a>
        <input type="submit" id="btn" value="決定">
        <!-- エラーメッセージ表示 -->
        <div class="error_message"><?php echo $error_message; ?></div>
        </div>
    </form>
</div>

<script src="../js/index.js"></script>
</body>
</html>
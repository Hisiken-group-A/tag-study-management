<?php

require_once '../config/dbconnect.php'; 
require_once '../class/Tag.php';

$pdo = connect();
$tag = new Tag($pdo);
$tag->process_post();
$tags = $tag->get_tag();

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
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/index.css">
</head>
<body>

<div class="tab">
    <ul class="tab_menu">
        <li class="Index"><a href="index.php">入力</a></li>
        <li class="Graph"><a href="graph_week.php">グラフ（週）</a></li>
        <li class="Week"><a href="graph_month.php">グラフ（月）</a></li>
        <li class="Month"><a href="month.php">月</a></li>
    </ul>
</div>

<div class="box">
    <div class="top"></div>
    <div class="bottom"></div>
    <div class="left"></div>
    <div class="right"></div>
</div>

<div class="main">
    <!-- タグ追加フォーム -->
    <form action="?action=add_tag" method="post">
        タグの追加
        <br><input type="text" id="intext" name="tag_name"><br>
        <input type="submit" value="追加">
    </form>

    <!-- タグ編集・削除フォーム -->
    <form action="?action=change_or_delete" method="post">
    <select name="tag_id">
        タグを選択
<!-- タグ削除フォーム-->
<form name="tag_edit" action="?action=change_or_delete" method="post">
    <select class="tag_edit_select" name="tag_id">
        タグを選択
        <option value="">タグを選択</option>
        <?php foreach($tags as $tag): ?>
        <option value="<?php echo $tag['id']; ?>"><?php echo $tag['tag_name']; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="submit" value="削除" name="change_or_delete">
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
                <input type="submit" value="変更" name="change_or_delete">
            </div>
        </div>
    </div>
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
    <input type="submit" value="削除" name="change_or_delete">
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

    </div>

<script src="../js/index.js"></script>
</body>
</html>
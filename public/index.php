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
<form action="?action=add_tag" method="post">
    タグの追加
    <br><input type="text" id="intext" name="tag_name"><br>
    <input type="submit" value="追加">
</form>

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
<form action="index.php" method="post" name="a">
    勉強時間入力
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
    <div class="error_message"><?php echo $error_message; ?></div>
    <input type="submit" value="決定">
</form>
<a href="./edit.html">編集画面へ移動（確認用）</a>

<script src="../js/index.js"></script>
</body>
</html>
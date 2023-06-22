<?php

require_once '../dbconnect.php'; 

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

//勉強時間入力フォームを打ち込んだとき
if (!empty($_POST['tag_name']) && !empty($_POST['hour']) && !empty($_POST['minute'])) {
    try {
        //○時間○分を○分間に変換
        $minute_time = (int)$_POST['hour'] * 60 + (int)$_POST['minute'];
        $minute_time = (string)$minute_time;
        //選択されたtagのidの取得とdateの取得の方法がわからないため追加されるかの確認でid=1とdate=now()を仮として使ってる状態
        $id = 1;
        $sql = "INSERT INTO study_time (study_time, date, tag_id) VALUES (:study_time, now(), :tag_id)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':study_time', $minute_time, PDO::PARAM_STR); //文字列として
        $stmt->bindValue(':tag_id', $id, PDO::PARAM_INT); 
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
            <!-- <form action="check_login.php" method="post" name="a"> -->
            <form action="#" method="post" name="a">
                <!--<textarea id="message" col="400" rows="5"></textarea> -->
                勉強時間入力
                <select name="tag_name">
                    <option value="">タグを選択</option>
                    <?php foreach($tags as $tag): ?>
                    <option value="<?php echo $tag['tag_name']; ?>"><?php echo $tag['tag_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <br>
                <input type="number" name="hour" min="0" max="23">h
                <input type="number" name="minute" min="0" max="59">m
                <br>
                <input type="submit" value="決定">
            </form>
    <a href="./edit.html">編集画面へ移動（確認用）</a>
</body>

</html>
<!--今井-->
<!-- 小松 -->
<!-- 淺川 -->
<!--amano pra-->

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
</head>
<body>

  <div class="tab">
      <ul class="tab_menu">
        <li class="Index"><a href="index.php">入力</a></li>
        <li class="Graph"><a href="graph.php">グラフ</a></li>
        <li class="Week"><a href="week.php">週</a></li>
        <li class="Month"><a href="month.php">月</a></li>
      </ul>
      <div class="tab_panel">

        <div class="tab_panel_box tab_panel_box001 is_show" data-tab="Select">
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
                <input type="number" name="hour" min="0" max="23">h
                <input type="number" name="minute" min="0" max="59">m<br>
                <input type="submit" value="決定">
            </form>
        </div>

        <div class="tab_panel_box tab_panel_box002" data-tab="Graph">
            <ul class="Graphmaterial">
                <li><a href="BouGraph"></a>棒グラフ</li>
                <li><a href="WariaiGraph"></a>割合円グラフ</li>
            </ul>
        </div>

        <div class="tab_panel_box tab_panel_box003" data-tab="Week">
          <p class="tab_panel_text">
            <div id="WeekCal"></div>
          </p>
        </div>

        <div class="tab_panel_box tab_panel_box004" data-tab="Month">
              <!-- The corrected placement of the div -->
              <div id="calender"></div>
      </div>
  </div>

</div>
    <!-- タグ追加フォーム -->
    <form method="post">
        タグの追加
        <br><input type="text"name="tag_name" placeholder="例）数学"><br>
        <input type="submit" name="add_tag_button" value="追加">
    </form>
    <!-- 勉強時間入力フォーム -->
    <form action="tag_name.php" method="post" name="tag_name">
        勉強時間入力
        <select name="tag_name">
            <option value="">タグを選択</option>
            <?php foreach($tags as $tag): ?>
            <option value="<?php echo $tag['tag_name']; ?>"><?php echo $tag['tag_name']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="hour" min="0" max="23">h
        <input type="number" name="minute" min="0" max="59">m<br>
        <input type="submit" value="決定">
    </form>
</body>
</html>
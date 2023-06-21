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
    <title>Study management</title>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>
        <div class="tab">
            <ul class="tab_menu">
                <li class="tab_menu_item is_active" data-tab="Select">入力</li>
                <li class="tab_menu_item" data-tab="Graph">グラフ</li>
                <li class="tab_menu_item" data-tab="Week">週</li>
                <li class="tab_menu_item" data-tab="Month">月</li>
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
                    <option value="<?php echo $tag['id']; ?>"><?php echo $tag['tag_name']; ?></option>
                    <?php endforeach; ?>
                </select>
              
                <input type="hidden" name="date" value="<?php echo date("Y-m-d H:i:s"); ?>">
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
    <a href="./edit.html">編集画面へ移動（確認用）</a>
    <script>
      'use strict';
    
      // DOM取得
      const tabMenus = document.querySelectorAll('.tab_menu_item');
      console.log(tabMenus);
    
      // イベント付加
      tabMenus.forEach((tabMenu) => {
        tabMenu.addEventListener('click', tabSwitch);
      })
    
      // イベントの処理
      function tabSwitch(e) {
        // クリックされた要素のデータ属性を取得
        const tabTargetData = e.currentTarget.dataset.tab;
    
        // クリックされた要素の親要素と、その子要素を取得
        const tabList = e.currentTarget.closest('.tab_menu');
        console.log(tabList);
        const tabItems = tabList.querySelectorAll('.tab_menu_item');
        console.log(tabItems);
    
        // クリックされた要素の親要素の兄弟要素の子要素を取得
        const tabPanelItems = tabList.nextElementSibling.querySelectorAll('.tab_panel_box');
        console.log(tabPanelItems);
    
        // クリックされたtabの同階層のmenuとpanelのクラスを削除
        tabItems.forEach((tabItem) => {
          tabItem.classList.remove('is_active');
        })
        tabPanelItems.forEach((tabPanelItem) => {
          tabPanelItem.classList.remove('is_show');
        })
    
        // クリックされたmenu要素にis-activeクラスを付加
        e.currentTarget.classList.add('is_active');
    
        // クリックしたmenuのデータ属性と等しい値を持つパネルにis-showクラスを付加
        tabPanelItems.forEach((tabPanelItem) => {
          if (tabPanelItem.dataset.tab === tabTargetData) {
            tabPanelItem.classList.add('is_show');
          }
        })
      }
    </script>
    <script src="../js/month.js"></script>
    <script src="../js/week.js"></script>
</body>

</html>
<!--今井-->
<!-- 小松 -->
<!-- 淺川 -->
<!--amano pra-->

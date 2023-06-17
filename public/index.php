<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study management</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
        <div class="tab">
            <ul class="tab_menu">
                <li class="tab_menu-item is-active" data-tab="Select">入力</li>
                <li class="tab_menu-item" data-tab="Graph">グラフ</li>
                <li class="tab_menu-item" data-tab="Week">週</li>
                <li class="tab_menu-item" data-tab="Month">月</li>
            </ul>


        <div class="tab_panel">
            <div class="tab_panel-box tab_panel-box001 is-show" data-tab="Select">
            <form action="check_login.php" method="post">
                タグの追加
                <br><input type="text" id="intext"><br>
                <!--<textarea id="message" col="400" rows="5"></textarea> -->
                勉強時間入力
                <br><input type="text" id="intext"><br>
                <input type="submit" value="決定">
            </form>
            </div>

        <div class="tab_panel-box tab_panel-box002" data-tab="Graph">
            <ul class="Graphmaterial">
                <li><a href="BouGraph"></a>棒グラフ</li>
                <li><a href="WariaiGraph"></a>割合円グラフ</li>
            </ul>
        </div>

        <div class="tab_panel-box tab_panel-box003" data-tab="Week">
          <p class="tab_panel-text">
            <div id="WeekCal"></div>
          </p>
        </div>

        <div class="tab_panel-box tab_panel-box004" data-tab="Month">
              <!-- The corrected placement of the div -->
              <div id="calender"></div>
      </div>
  </div>
</div>
    <a href="./edit.html">編集画面へ移動（確認用）</a>
    <script>
      'use strict';
    
      // DOM取得
      const tabMenus = document.querySelectorAll('.tab_menu-item');
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
        const tabItems = tabList.querySelectorAll('.tab_menu-item');
        console.log(tabItems);
    
        // クリックされた要素の親要素の兄弟要素の子要素を取得
        const tabPanelItems = tabList.nextElementSibling.querySelectorAll('.tab_panel-box');
        console.log(tabPanelItems);
    
        // クリックされたtabの同階層のmenuとpanelのクラスを削除
        tabItems.forEach((tabItem) => {
          tabItem.classList.remove('is-active');
        })
        tabPanelItems.forEach((tabPanelItem) => {
          tabPanelItem.classList.remove('is-show');
        })
    
        // クリックされたmenu要素にis-activeクラスを付加
        e.currentTarget.classList.add('is-active');
    
        // クリックしたmenuのデータ属性と等しい値を持つパネルにis-showクラスを付加
        tabPanelItems.forEach((tabPanelItem) => {
          if (tabPanelItem.dataset.tab === tabTargetData) {
            tabPanelItem.classList.add('is-show');
          }
        })
      }
    </script>
    <script src="./month.js"></script>
    <script src="./week.js"></script>
</body>

</html>

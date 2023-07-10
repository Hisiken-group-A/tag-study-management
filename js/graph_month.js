'use strict';

let date = new Date(); //現在の日時
let year = date.getFullYear(); //年のデータ
let month = date.getMonth() + 1; //月のデータ
let firstDate = new Date(year, month - 1, 1); //現在の日時
let firstDay = firstDate.getDay(); //曜日のデータ
let lastDate = new Date(year, month, 0); //今月の最終日
let lastDayCount = lastDate.getDate();

let eachTagStudyTime = [];
let eachTagName = [];

let chart = null;

makeGraphData();

//PHPからデータを取得し加工
function makeGraphData(){
    getEachDayStudyTime(function(eachDayStudyTime) {
        getAllTag(function(jsonTags) {
            // タグごとの勉強時間を全て0で初期化，タグ名を代入
            for(let i = 0; i < jsonTags.length; i++){
                eachTagStudyTime[i] = 0;
                eachTagName[i] = jsonTags[i].tag_name;
            }
            //タグごとの勉強時間の合計を計算
            for(let i = 0; i < eachDayStudyTime.length; i++){
                for(let j = 0; j < jsonTags.length; j++){
                    if(eachDayStudyTime[i].tag_id == jsonTags[j].id){
                        eachTagStudyTime[j] += Number(eachDayStudyTime[i].study_time);
                        continue;
                    }
                }
            }
            //勉強時間が0のタグは表示しないため削除
            for(let i = 0; i < jsonTags.length; i++){
                if(eachTagStudyTime[i]==0){
                    eachTagName.splice(i, 1);
                    eachTagStudyTime.splice(i, 1);
                    i--;
                }
            }
            NewGraph();
        });
    });
}

function NewGraph () {
    NewGraphCount();
    let context = document.querySelector("#graph").getContext('2d');
    // チャートがすでに存在している場合は破棄して再描画する
    if (chart) {
        chart.destroy();
    }
    if(eachTagName.length===0){
        chart = new Chart(context, {
            type: 'pie',
            data: {
                labels: ['データがありません'],
                datasets: [{
                    data:[100],
                    backgroundColor : 'rgba(128,128,128,0.5)',//塗りつぶす色
                }],
            }
        });
    } else {
        chart = new Chart(context, {
            type: 'pie',
            data: {
                labels: eachTagName,
                datasets: [{
                    data:eachTagStudyTime
                }]
            }
        });
    }
}

//グラフの年と月を表示
function NewGraphCount() {
    let MonthCountHtml = '';

    MonthCountHtml = '<h1>' + year + '/' + month + '</h1>';
    document.querySelector('#MonthCount').innerHTML = MonthCountHtml;
}

function back_graph_month() {
    month--; //1ヶ月ずつマイナス
    if (month < 1) { //1未満になったら
        year--; //年を1ずつ減らす
        month = 12; //12に戻る
    }
    makeGraphData();
}

function next_graph_month() {
    month++;
    if (month > 12) {
        year++;
        month = 1;
    }
    makeGraphData();
}

function getAllTag(callback) {
    let xhr = new XMLHttpRequest();
    //openの第三引数は非同期(true)で行うと言う指定
    xhr.open("GET",`../public/change-month.php?type=month_tag`,true); 
    xhr.responseType = "text"; //結果をテキスト形式で取得
    xhr.addEventListener('load', function(event){
        var param = JSON.parse(xhr.responseText); //JSONデコード
        callback(param);
    });
    xhr.send(null);
}

function getEachDayStudyTime(callback) {
    let xhr = new XMLHttpRequest();
    //openの第三引数は非同期(true)で行うと言う指定
    xhr.open("GET",`../public/change-month.php?type=each_day&year=${year}&month=${month}`,true); 
    xhr.responseType = "text"; //結果をテキスト形式で取得
    xhr.addEventListener('load', function(event){
        var param = JSON.parse(xhr.responseText); //JSONデコード
        callback(param);
    });
    xhr.send(null);
}
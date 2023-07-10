'use strict';

let date = new Date(); //現在の日時
let year = date.getFullYear(); //年のデータ
let month = date.getMonth(); //月のデータ
let day = date.getDate(); //日のデータ

let Sunday  = day - date.getDay();
let Saturday = Sunday + 6;
let StartSunday = new Date(year, month, Sunday);
let EndSaturday = new Date(year, month, Saturday, 23,59,59,999);

let StartDate = (StartSunday.getMonth() + 1) + "/" + StartSunday.getDate();
let endDate = (EndSaturday.getMonth() + 1) + "/" + EndSaturday.getDate();

let WeekCountHtml = '';

let eachTagStudyTime = [];
let eachTagName = [];

let formattedStartSunday = '';
let formattedEndSaturday = '';

let weekBarDataLabel = [];

let pie = null;
let bar = null;

makeGraphData();
New_Graph_Week(StartDate, endDate);

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

            for(let i=0; i<7; i++){
                weekBarDataLabel[i]+=StartSunday+i;
            }
            console.log(weekBarDataLabel);

            console.log(eachTagName);
            console.log(eachDayStudyTime);
            NewGraph();
        });
    });
}

function NewGraph(){
    let context_bar = document.querySelector("#graph_bar").getContext('2d');
    if (bar) {
        bar.destroy();
    }
    bar = new Chart(context_bar, {
        type: 'bar',
        data: {
            labels: ['6/11', '6/12', '6/13', '6/14', '6/15', '6/16', '6/17'],
            datasets: [{
                label: "数学",
                data: [70, 0, 200, 360, 100, 60, 20],
            },{
                label: "英語",
                data: [50, 30, 100, 0, 200, 60, 0],
            },{
                label: "プログラミング",
                data: [30, 60, 100, 0, 200, 0, 100],
            },{
                label: "SPI",
                data: [0, 0, 100, 0, 0, 0, 0],
            },{
                label: "ES",
                data: [0, 0, 0, 0, 0, 0, 60],
            }],
        },
        options: {
            scales: {
                x: {
                    stacked: true,
                }
            },
            y: {
                stacked: true
            }
        },
        responsive: false
    });
    
    let context_pie = document.querySelector("#graph_pie").getContext('2d');
    if (pie) {
        pie.destroy();
    }
    console.log(eachTagName);
    if(eachTagName.length===0){
        pie = new Chart(context_pie, {
            type: 'pie',
            data: {
                labels: ['データがありません'],
                datasets: [{
                    data:[100],
                    backgroundColor : 'rgba(128,128,128,0.5)',//塗りつぶす色
                }],
            },
            options: {
                responsive: false,
            }
        });
    } else {
        pie = new Chart(context_pie, {
            type: 'pie',
            data: {
                labels: eachTagName,
                datasets: [{
                    data:eachTagStudyTime
                }]
            },
            options: {
                responsive: false,
            }
        });
    }
    document.querySelector('#Sunday_Saturday').innerHTML = WeekCountHtml;
}

function New_Graph_Week(startDate, endDate) {
    WeekCountHtml = '<h1>' + startDate + ' 〜 ' + endDate + '</h1>';
    document.querySelector('#Sunday_Saturday').innerHTML = WeekCountHtml;
  }

function back_graph_week() {
    StartSunday.setDate(StartSunday.getDate() - 7);
    EndSaturday.setDate(EndSaturday.getDate() - 7);
    console.log(StartSunday);
    // 開始日
    var year = StartSunday.getFullYear(); // 年を取得
    var month = ("0" + (StartSunday.getMonth() + 1)).slice(-2); // 月を取得（0埋め）
    var day = ("0" + StartSunday.getDate()).slice(-2); // 日を取得（0埋め）
    formattedStartSunday = year + "-" + month + "-" + day; // yyyy-mm-dd形式の文字列を作成
    //終了日
    var year = EndSaturday.getFullYear(); // 年を取得
    var month = ("0" + (EndSaturday.getMonth() + 1)).slice(-2); // 月を取得（0埋め）
    var day = ("0" + EndSaturday.getDate()).slice(-2); // 日を取得（0埋め）
    formattedEndSaturday = year + "-" + month + "-" + day; // yyyy-mm-dd形式の文字列を作成

    console.log(formattedStartSunday); // yyyy-mm-dd形式の日付を表示
    console.log(formattedEndSaturday); // yyyy-mm-dd形式の日付を表示

    let startDate = (StartSunday.getMonth() + 1) + "/" + StartSunday.getDate();
    let endDate = (EndSaturday.getMonth() + 1) + "/" + EndSaturday.getDate();
    console.log(StartSunday);
    New_Graph_Week(startDate, endDate);
    makeGraphData();
}

function next_graph_week() {
    StartSunday.setDate(StartSunday.getDate() + 7);
    EndSaturday.setDate(EndSaturday.getDate() + 7);

    // 開始日
    var year = StartSunday.getFullYear(); // 年を取得
    var month = ("0" + (StartSunday.getMonth() + 1)).slice(-2); // 月を取得（0埋め）
    var day = ("0" + StartSunday.getDate()).slice(-2); // 日を取得（0埋め）
    formattedStartSunday = year + "-" + month + "-" + day; // yyyy-mm-dd形式の文字列を作成
    //終了日
    var year = EndSaturday.getFullYear(); // 年を取得
    var month = ("0" + (EndSaturday.getMonth() + 1)).slice(-2); // 月を取得（0埋め）
    var day = ("0" + EndSaturday.getDate()).slice(-2); // 日を取得（0埋め）
    formattedEndSaturday = year + "-" + month + "-" + day; // yyyy-mm-dd形式の文字列を作成

    console.log(formattedStartSunday); // yyyy-mm-dd形式の日付を表示
    console.log(formattedEndSaturday); // yyyy-mm-dd形式の日付を表示
    
    let startDate = (StartSunday.getMonth() + 1) + "/" + StartSunday.getDate();
    let endDate = (EndSaturday.getMonth() + 1) + "/" + EndSaturday.getDate();
    New_Graph_Week(startDate, endDate);
    makeGraphData();
}

function getAllTag(callback) {
    let xhr = new XMLHttpRequest();
    //openの第三引数は非同期(true)で行うと言う指定
    xhr.open("GET",`../public/change-week.php?type=get_tag`,true); 
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
    xhr.open("GET",`../public/change-week.php?type=each_day&StartDay=${formattedStartSunday}&EndDay=${formattedEndSaturday}`,true); 
    xhr.responseType = "text"; //結果をテキスト形式で取得
    xhr.addEventListener('load', function(event){
        var param = JSON.parse(xhr.responseText); //JSONデコード
        callback(param);
    });
    xhr.send(null);
}
'use strict';

let date = new Date(); //現在の日時
let year = date.getFullYear(); //年のデータ
let month = date.getMonth() + 1; //月のデータ
let firstDate = new Date(year, month - 1, 1); //現在の日時
let firstDay = firstDate.getDay(); //曜日のデータ
let lastDate = new Date(year, month, 0); //今月の最終日
let lastDayCount = lastDate.getDate();

NewGraphCount();
getEachDayStudyTime(function(eachDayStudyTime) {
    getAllTag(function(tags) {
        const eachTagStudyTime = [];
        const eachTagName = [];
        for(let i = 0; i < tags.length; i++){
            eachTagStudyTime[i] = 0;
        }
        for(let i = 0; i < eachDayStudyTime.length; i++){
            for(let j = 0; j < tags.length; j++){
                if(eachDayStudyTime[i].tag_id == tags[j].id){
                    eachTagStudyTime[j] += Number(eachDayStudyTime[i].study_time);
                    console.log(eachTagStudyTime[j]);
                    continue;
                }
            }
        }
        for(let i = 0; i < tags.length; i++){
            // console.log(eachTagStudyTime[i]);
        }
    });
    NewGraph();
});

function NewGraph () {
    let context = document.querySelector("#graph").getContext('2d')
    new Chart(context, {
        type: 'pie',
        data: {
            labels: ["数学","英語","プログラミング","SPI","ES"],
            datasets: [{
                data:[60, 20, 15, 10, 5]
            }]
        }
    });
}

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

    NewGraphCount();
    getEachDayStudyTime(function(eachDayStudyTime) {
        getAllTag(function(tags) {
            const eachTagStudyTime = [];
            for(let i = 0; i < tags.length; i++){
                eachTagStudyTime[i] = 0;
            }
            for(let i = 0; i < eachDayStudyTime.length; i++){
                for(let j = 0; j < tags.length; j++){
                    if(eachDayStudyTime[i].tag_id == tags[j].id){
                        eachTagStudyTime[j] += Number(eachDayStudyTime[i].study_time);
                        console.log(eachTagStudyTime[j]);
                        continue;
                    }
                }
            }
            for(let i = 0; i < tags.length; i++){
                // console.log(eachTagStudyTime[i]);
            }
        });
    });
}

function next_graph_month() {
    month++;
    if (month > 12) {
        year++;
        month = 1;
    }
    NewGraphCount();
    getEachDayStudyTime(function(eachDayStudyTime) {
        getAllTag(function(tags) {
            const eachTagStudyTime = [];
            for(let i = 0; i < tags.length; i++){
                eachTagStudyTime[i] = 0;
            }
            for(let i = 0; i < eachDayStudyTime.length; i++){
                for(let j = 0; j < tags.length; j++){
                    if(eachDayStudyTime[i].tag_id == tags[j].id){
                        eachTagStudyTime[j] += Number(eachDayStudyTime[i].study_time);
                        console.log(eachTagStudyTime[j]);
                        continue;
                    }
                }
            }
            for(let i = 0; i < tags.length; i++){
                // console.log(eachTagStudyTime[i]);
            }
        });
    });
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
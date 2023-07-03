'use strict';

const total = document.getElementById('total');

let date = new Date(); //現在の日時
let year = date.getFullYear(); //年のデータ
let month = date.getMonth() + 1; //月のデータ
let firstDate = new Date(year, month - 1, 1); //現在の日時
let firstDay = firstDate.getDay(); //曜日のデータ
let lastDate = new Date(year, month, 0); //今月の最終日
let lastDayCount = lastDate.getDate();
const month_English = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
let month_Eng = '';
month_Eng = month_English[date.getMonth()];

let dayCount = 1;
let createHtml = '';

createHtml = '<h1>' + year + '/' + month + '</h1>';
createHtml += '<table>' + '<tr>';

const weeks = ['日', '月', '火', '水', '木', '金', '土'];
for (let i = 0; i < weeks.length; i++) {
    createHtml += '<td>' + weeks[i] + '</td>';
}
createHtml += '</tr>';

getTotalStudyTime(function(response) {
    console.log(response);
    total.textContent = response;
});

getEachDayStudyTime(function(response) {
    console.log(response);
    createCalendar(response);
});

//カレンダー作成
function createCalendar(studyTimeJson) {
  createHtml = '<h1>' + year + '/' + month + month_Eng + '</h1>';
  createHtml += '<table>' + '<tr>';

  for (let i = 0; i < weeks.length; i++) {
    createHtml += '<td>' + weeks[i] + '</td>';
  }
  createHtml += '</tr>';

  for (let n = 0; n < 6; n++) {
    createHtml += '<tr>';
    for (let d = 0; d < 7; d++) {
        if (n == 0 && d < firstDay) {
            createHtml += '<td></td>';
        } else if (dayCount > lastDayCount) {
            createHtml += '<td></td>';
        } else {
            //勉強時間表示
            createHtml += '<td>' + dayCount;
            let calendarDate = year + '-' + month + '-' + dayCount;
            console.log(calendarDate);
            for(let i = 0; i < studyTimeJson.length; i++){
                let date = new Date(studyTimeJson[i].date);
                let year = date.getFullYear();
                let month = date.getMonth() + 1;
                let day = date.getDate();
                let formattedDate = year + '-' + month + '-' + day;
                if(calendarDate==formattedDate){
                    const hour = Math.floor(studyTimeJson[i].study_time / 60);
                    const minuits = studyTimeJson[i].study_time % 60;
                    createHtml += '<br>'+ '<a href="edit.php?id='+ studyTimeJson[i].id +'">' + hour + 'h' + minuits + 'm' + '</a>';
                }
            }
            createHtml += '</td>';
            dayCount++;
        }
    }
    createHtml += '</tr>';
    }
    createHtml += '</table>';
    document.querySelector('#calendar').innerHTML = createHtml;
}

//back,next
function NewCalendar(studyTimeJson) {
    firstDate = new Date(year, month - 1, 1);
    firstDay = firstDate.getDay();
    lastDate = new Date(year, month, 0);
    lastDayCount = lastDate.getDate();
    dayCount = 1;
    createCalendar(studyTimeJson);
}

//前の月を表示
function back() {
    month--; //1ヶ月ずつマイナス
    month_Eng = month_English[month - 1];
    if (month < 1) { //1未満になったら
        year--; //年を1ずつ減らす
        month = 12; //12に戻る
        month_Eng = month_English[11];
    }
    getTotalStudyTime(function(response) {
      console.log(response);
      total.textContent = response;
    });
    getEachDayStudyTime(function(response) {
        console.log(response);
        NewCalendar(response);
    });
}

//次の月を表示
function next() {
    month++;
    month_Eng = month_English[month + 1];
    if (month > 12) {
        year++;
        month = 1;
    }
    if(month > 11) {
        month_Eng = month_English[0];
    }
    getTotalStudyTime(function(response) {
        console.log(response);
        total.textContent = response;
    });
    getEachDayStudyTime(function(response) {
        console.log(response);
        NewCalendar(response);
    });
}

//月の合計時間を取得し，合計時間をコールバック関数として返す
function getTotalStudyTime(callback) {
    let xhr = new XMLHttpRequest();
    //openの第三引数は非同期(true)で行うと言う指定
    xhr.open("GET",`../public/change-month.php?type=month&year=${year}&month=${month}`,true); 
    xhr.responseType = "text"; //結果をテキスト形式で取得
    xhr.addEventListener('load', function(event){
        callback(xhr.response); 
    });
    xhr.send(null);
}

//選択された月の日にちごとの勉強時間を取得し，コールバック関数として返す
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
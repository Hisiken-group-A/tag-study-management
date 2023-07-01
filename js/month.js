'use strict';

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

function createCalendar() {
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
        createHtml += '<td>' + dayCount + '</td>';
        dayCount++;
      }
    }
    createHtml += '</tr>';
  }
  createHtml += '</table>';

  document.querySelector('#calendar').innerHTML = createHtml;
}
createCalendar();
getTotalStudyTime();
getEachDayStudyTime();

//back,next
function NewCalendar() {
    firstDate = new Date(year, month - 1, 1);
    firstDay = firstDate.getDay();
    lastDate = new Date(year, month, 0);
    lastDayCount = lastDate.getDate();
    dayCount = 1;
    createCalendar();
}

function back() {
  month--; //1ヶ月ずつマイナス
  if (month < 1) { //1未満になったら
      year--; //年を1ずつ減らす
      month = 12; //12に戻る
  }
  NewCalendar();
  getTotalStudyTime();
  getEachDayStudyTime();
}
function next() {

    month++;
    if (month > 12) {
        year++;
        month = 1;
    }
    NewCalendar();
    getTotalStudyTime();
    getEachDayStudyTime();
}

function getTotalStudyTime() {
    let xhr = new XMLHttpRequest();
    //openの第三引数は非同期(true)で行うと言う指定
    xhr.open("GET",`../public/change-month.php?type=month&year=${year}&month=${month}`,true); 
    xhr.responseType = "text"; //結果をテキスト形式で取得
    xhr.addEventListener('load', function(event){
        console.log(xhr.response); //->本来のメインの出力
        // console.log(event.target.response); //->イベントにも入る
    });
    xhr.send(null);
}

function getEachDayStudyTime() {
    let xhr = new XMLHttpRequest();
    //openの第三引数は非同期(true)で行うと言う指定
    xhr.open("GET",`../public/change-month.php?type=each_day&year=${year}&month=${month}`,true); 
    xhr.responseType = "text"; //結果をテキスト形式で取得
    xhr.addEventListener('load', function(event){
        // console.log(xhr.response); //->本来のメインの出力
        // console.log(event.target.response); //->イベントにも入る
        var param = JSON.parse(xhr.response); //JSONデコード
        console.log(param);
    });
    xhr.send(null);
}
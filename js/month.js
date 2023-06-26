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
        createHtml += '<td class="disabled"><button class="button_click"><a href="../public/edit.php"></td></a>';
      } else if (dayCount > lastDayCount) {
        createHtml += '<td class="disabled"><button class="button_click"><a href="../public/edit.php"></td></a>';
      } else {
        createHtml += '<td class="disabled"><button class="button_click"><a href="../public/edit.php">' + dayCount + '</td></a>';
        dayCount++;
      }
    }
    createHtml += '</tr>';
  }
  createHtml += '</table>';

  document.querySelector('#calendar').innerHTML = createHtml;
}
createCalendar();

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
}
function next() {
  month++;
  if (month > 12) {
      year++;
      month = 1;
  }
  NewCalendar();
}
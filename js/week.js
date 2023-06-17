/*全然できてない*/
'use strict'

const date = new Date();//現在の日時
const year = date.getFullYear();
const month = date.getMonth() + 1;
const firstDate = new Date(year, month -1, 1); //-1←来月のデータになってしまう
const firstDay = firstDate.getDay(); //曜日のデータ
const lastDate = new Date(year,month,0);//今月の最終日
const lastDayCount = lastDate.getDate();

let dayCount = 1;
let createHtml = '';

createHtml = '<h1>' + year + '/' + month + '</h1>'
createHtml += '<table>' + '<tr>' //左の色を追加で足したい

const weeks = ['日', '月', '火', '水', '木', '金', '土'];
for (let i =0; i < weeks.length; i++){ //weeks.length←配列の個数のこと
  createHtml += '<td>' + weeks[i] + '</td>';//week[i] ０番目
}createHtml += '</tr>' //左の色を追加で足したい

for (let tab = 0; tab < 100; tab++){ //行をタブの数だけ作る
  createHtml += '<tr>';

  for (let d = 0; d < 7; d++){
    if (tab == 0 && d < firstDay){
      createHtml += '<td></td>'
    } else if (dayCount > lastDayCount) {
      createHtml += '<td></td>'
    } else {
      createHtml += '<td>' + dayCount + '</td>';
      dayCount++;
    }
  }

  createHtml += '</tr>';
}
createHtml += '</table>'

document.querySelector('#WeekCal').innerHTML = createHtml;

console.log(date);
console.log(year);
console.log(month);

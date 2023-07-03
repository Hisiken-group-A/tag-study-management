'use strict';

let date = new Date(); //現在の日時
let year = date.getFullYear(); //年のデータ
let month = date.getMonth() + 1; //月のデータ
let firstDate = new Date(year, month - 1, 1); //現在の日時
let firstDay = firstDate.getDay(); //曜日のデータ
let lastDate = new Date(year, month, 0); //今月の最終日
let lastDayCount = lastDate.getDate();

window.onload = function () {
    NewGraph();
    NewGraphCount();
};
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
}

function next_graph_month() {
    month++;
    if (month > 12) {
        year++;
        month = 1;
    }
    NewGraphCount();
}
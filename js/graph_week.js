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


window.onload = function () {
    WeekCountHtml = '<h1>' + StartDate + ' 〜 ' + endDate + '</h1>';
    let context_bar = document.querySelector("#graph_bar").getContext('2d');
    new Chart(context_bar, {
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
    new Chart(context_pie, {
        type: 'pie',
        data: {
            labels: ["数学", "英語", "プログラミング", "SPI", "ES"],
            datasets: [{
                data: [60, 20, 15, 10, 5]
            }]
        },
        options: {
            responsive: false,
        }
    }
    );
    document.querySelector('#Sunday_Saturday').innerHTML = WeekCountHtml;
};

function New_Graph_Week(startDate, endDate) {
    WeekCountHtml = '<h1>' + startDate + ' 〜 ' + endDate + '</h1>';
    document.querySelector('#Sunday_Saturday').innerHTML = WeekCountHtml;
  }

function back_graph_week() {
    StartSunday.setDate(StartSunday.getDate() - 7);
    EndSaturday.setDate(EndSaturday.getDate() - 7);
    let startDate = (StartSunday.getMonth() + 1) + "/" + StartSunday.getDate();
    let endDate = (EndSaturday.getMonth() + 1) + "/" + EndSaturday.getDate();
    New_Graph_Week(startDate, endDate);
}

function next_graph_week() {
    StartSunday.setDate(StartSunday.getDate() + 7);
    EndSaturday.setDate(EndSaturday.getDate() + 7);
    let startDate = (StartSunday.getMonth() + 1) + "/" + StartSunday.getDate();
    let endDate = (EndSaturday.getMonth() + 1) + "/" + EndSaturday.getDate();
    New_Graph_Week(startDate, endDate);
    
}
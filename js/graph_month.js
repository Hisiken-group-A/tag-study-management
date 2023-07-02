'use strict';

window.onload = function () {
    let context = document.querySelector("#graph").getContext('2d')
    new Chart(context, {
        type: 'pie',
        data: {
            label: ["数学","英語","プログラミング","SPI","ES"],
            datasets: [{
                data:[60, 20, 15, 10, 5]
            }]
        }
    });
}
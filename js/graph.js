'use strict';

function select_check() {
    let select = document.getElementsByName("graph");
    if(select[0].checked){
        document.getElementById('select_week').style.display = "";
        document.getElementById('select_month').style.display = "none";
    }else if(select[1].checked){
        document.getElementById('select_week').style.display = "none";
        document.getElementById('select_month').style.display = "";
    }else {
        document.getElementById('select_week').style.display = "none";
        document.getElementById('select_month').style.display = "none";
    }
}
window.addEventListener ('load', select_check());
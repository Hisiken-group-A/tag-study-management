<?php

require_once '../config/dbconnect.php'; 

$pdo = connect();
$type = $_GET['type'];

switch ($type){
    case 'month':
        get_total_study_time();
        break;
    case 'each_day':
        get_each_day_study_time();
        break;
    case 'month_tag':
        get_month_all_tag();
        break;
    default:
        break;
}

function get_total_study_time(){
    $pdo = connect();
    $date_start = $_GET['year']."-".sprintf('%02d', $_GET['month'])."-01";
    $objDateTime = new DateTime($_GET['year']."-".sprintf('%02d', $_GET['month']).' +1 month');//来月
    $date_end = $objDateTime->format('Y-m-d');
    $stmt = $pdo->query("SELECT * FROM study_time WHERE date BETWEEN '$date_start' AND '$date_end'");
    $studies = $stmt->fetchAll();
    $total = 0;

    foreach ($studies as $study_time) {
        $total += (int)$study_time["study_time"];
    }

    $hour = floor($total / 60);
    $minuits = $total % 60;

    echo $hour . "h" . $minuits . "m";
}

function get_each_day_study_time(){
    $pdo = connect();
    $date_start = $_GET['year']."-".sprintf('%02d', $_GET['month'])."-01";
    $objDateTime = new DateTime($_GET['year']."-".sprintf('%02d', $_GET['month']).' +1 month');//来月
    $date_end = $objDateTime->format('Y-m-d');

    $stmt = $pdo->query("SELECT * FROM study_time WHERE date BETWEEN '$date_start' AND '$date_end'");
    $studies = $stmt->fetchAll();

    $json_studies = json_encode($studies);
    echo $json_studies;
}

function get_month_all_tag(){
    $pdo = connect();
    $stmt = $pdo->query("SELECT * FROM tag");
    $tags = $stmt->fetchAll();
    $json_studies = json_encode($tags);
    echo $json_studies;
}
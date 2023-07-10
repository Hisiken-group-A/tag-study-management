<?php

require_once '../config/dbconnect.php'; 

$pdo = connect();
$type = $_GET['type'];

switch ($type){
    case 'week':
        get_total_study_time();
        break;
    case 'each_day':
        get_each_day_study_time();
        break;
    case 'get_tag':
        get_all_tag();
        break;
    default:
        break;
}

function get_each_day_study_time(){
    $pdo = connect();
    // $date_start = $_GET['']."-".sprintf('%02d', $_GET['month'])."-01";
    // $objDateTime = new DateTime($_GET['year']."-".sprintf('%02d', $_GET['month']).' +1 month');//来月
    // $date_end = $objDateTime->format('Y-m-d');

    $startDay = $_GET['StartDay'];
    $endDay = $_GET['EndDay'];

    $stmt = $pdo->query("SELECT * FROM study_time WHERE date BETWEEN '$startDay' AND '$endDay'");
    $studies = $stmt->fetchAll();

    $json_studies = json_encode($studies);
    echo $json_studies;
}

function get_all_tag(){
    $pdo = connect();
    $stmt = $pdo->query("SELECT * FROM tag");
    $tags = $stmt->fetchAll();
    $json_studies = json_encode($tags);
    echo $json_studies;
}
<?php
require_once '../config/dbconnect.php';
$pdo = connect();
//削除処理
$get_id = $_GET['id'];
//idに該当するデータの削除
// echo $get_id;
$stmt = $pdo->prepare("DELETE FROM study_time WHERE id = :id");
$stmt->bindValue(':id', $get_id);
$stmt->execute();
header('Location: month.php');
?>
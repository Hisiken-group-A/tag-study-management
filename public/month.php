<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カレンダー</title>
    <!-- <link rel="stylesheet" href="../css/common.css"> -->
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/month.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com"> 
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> 
    <link href="https://fonts.googleapis.com/css2?family=Edu+VIC+WA+NT+Beginner&family=M+PLUS+1&family=Zen+Maru+Gothic&display=swap" rel="stylesheet">
</head>
<body>

<?php include('../inc/tab.php'); ?>

<div class="main">

<div id="next_back_button">
    <button id="back" onclick="back()">＜</button>
    <button id="next" onclick="next()">＞</button>
</div>
<div id="calendar"></div>
<div class="add">
     <h2>TOTAL</h2>
     <div id="total"></div>
<script src="../js/month.js"></script>
</div>

</div>
</body>
</html>
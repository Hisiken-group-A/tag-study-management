<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カレンダー</title>
    <!-- <link rel="stylesheet" href="../css/common.css"> -->
    <link rel="stylesheet" href="../css/month.css">
</head>
<body>

<?php include('../inc/tab.php'); ?>

<div id="next_back_button">
    <button id="back" onclick="back()"><</button>
    <button id="next" onclick="next()">></button>
</div>
<div id="calendar"></div>
<div id="total"></div>
<script src="../js/month.js"></script>
</body>
</html>
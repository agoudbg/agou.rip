<?php
require("./define.php");
require("./mysql.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?php echo site_name; ?> 管理后台</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <meta name='apple-mobile-web-app-capable' content='yes'>
    <meta name='apple-mobile-web-app-status-bar-style' content='black'>
    <meta name='format-detection' content='telephone=no'>
    <link rel="stylesheet" type="text/css" href="src/css/card.css">
    <link rel="stylesheet" type="text/css" href="src/css/page.css">
</head>

<body class="cardBox">
    <div class="titleBox">
        <h1><?php echo site_name; ?> 管理后台</h1>
        <div class="buttons">
            <button onclick="window.location.href='index.php'"><i class="material-icons">home</i></button>
        </div>
    </div>
    <div class="card">
        <div class="content">开发中</div>
    </div>

</body>

</html>
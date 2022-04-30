<?php
require("./define.php");

$msgid = $_GET["msgid"];
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>弔 <?php echo my_name; ?> 成功</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <meta name='apple-mobile-web-app-capable' content='yes'>
    <meta name='apple-mobile-web-app-status-bar-style' content='black'>
    <meta name='format-detection' content='telephone=no'>
    <link rel="stylesheet" type="text/css" href="src/css/card.css">
    <link rel="stylesheet" type="text/css" href="src/css/page.css">
</head>

<body class="cardBox">
    <div class="titleBox">
        <h1>发送成功</h1>
        <div class="buttons">
            <button onclick="window.location.href='index.php'"><i class="material-icons">home</i></button>
        </div>
    </div>
    <form action="submit.php" method="post">
        <div class="card">
            <div class="header">
                <div class="name">已经成功发送消息给 <?php echo my_name; ?>。<?php echo my_name; ?> 会阅读你的消息，你可以通过此凭据查询<?php echo call; ?>的回复。</div>
            </div>
            <div class="content">
                <div class="msgid"><?php echo $msgid; ?></div>
            </div>
            <div class="bottom">
                <div class="word">
                    <p>点击即可快速选中凭据。</p>
                    <p>请妥善保管凭据，一旦丢失则无法查询回复，若泄露任何人都可以查看内容和回复。</p>
                    <p><b>回复查询方法：</b>在 <?php echo site_name; ?> 首页点击放大镜按钮即可。</p>
                    <p>不过若你只是想骂 <?php echo my_name; ?>，并不想看<?php echo call; ?>的回复，丢掉凭据也许不是一个坏选择。</p>
                </div>
            </div>
        </div>
    </form>

</body>

</html>
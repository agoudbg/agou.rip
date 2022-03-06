<?php
require("./define.php");
require("./mysql.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>查询吐槽历史</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <meta name='apple-mobile-web-app-capable' content='yes'>
    <meta name='apple-mobile-web-app-status-bar-style' content='black'>
    <meta name='format-detection' content='telephone=no'>
    <link rel="stylesheet" type="text/css" href="src/css/card.css">
    <link rel="stylesheet" type="text/css" href="src/css/page.css">
</head>

<body class="cardBox">
    <div class="titleBox">
        <h1>查询</h1>
        <div class="buttons">
            <button onclick="window.location.href='index.php'"><i class="material-icons">home</i></button>
        </div>
    </div>
    <form action="" method="get">
        <div class="card">
            <div class="header">
                <div class="name">请输入凭据</div>
            </div>
            <div class="content">
                <p class="status">
                    <?php if (isset($_GET["tip"])) echo $_GET["tip"]; ?>
                </p>
                <div class="editDiv">
                    <div class="editItem">
                        <input id="msgid" name="msgid" class="val" placeholder="凭据" value="<?php echo (isset($_GET["msgid"]) ? $_GET["msgid"] : ""); ?>">
                    </div>
                </div>
            </div>
            <div class="bottom">
                <div class="word">
                    <p></p>
                </div>
                <div class="buttons"><button class="bigButton" type="submit">查询</button></div>
            </div>
        </div>
    </form>
    <?php
    if (isset($_GET["msgid"]) && !empty($_GET["msgid"])) {
    ?>
        <div class="card">
            <div class="header">
                <div class="name">查询结果</div>
            </div>
            <div class="content">
                <?php
                $db = new CodyMySQL(mysql_host, mysql_port, mysql_user, mysql_pass, mysql_database);
                $sql = "SELECT * FROM `post` WHERE `id`='" . addslashes($_GET['msgid']) . "'";
                if (!$db->getrow($sql) || $db->getrow($sql)["deleted"] == 1) {
                    echo "未找到该记录。";
                } else {
                ?>
                    <div class="editDiv">
                        <div class="editItem">
                            <div class="name">昵称</div>
                            <input disabled id="nick" name="nick" class="val" placeholder="未提供" value="<?php echo $db->getrow($sql)["nick"]; ?>">
                        </div>
                        <div class="editItem">
                            <div class="name">邮箱</div>
                            <input disabled id="email" name="email" class="val" placeholder="未提供" value="<?php echo $db->getrow($sql)["email"]; ?>">
                        </div>
                        <div class="editItem">
                            <div class="name">内容</div>
                            <div id="text" name="text" class="val"><?php echo str_replace("\n", "<br />", $db->getrow($sql)["text"]); ?></div>
                        </div>
                        <div class="editItem">
                            <div class="name">回复后公开</div>
                            <input disabled id="public" name="public" class="val" value="<?php echo ($db->getrow($sql)["public"] == 1 ? "是" : "否"); ?>">
                        </div>
                        <div class="editItem">
                            <div class="name">发送时间</div>
                            <input disabled id="time" name="time" class="val" value="<?php echo date("Y-m-d H:i:s", $db->getrow($sql)["time"]); ?>">
                        </div>
                    </div>
                    <?php
                    if ($db->getrow($sql)["reply"] != "") {
                    ?>
                        <div class="editDiv">
                            <div class="editItem">
                                <div class="name">回复</div>
                                <div id="replytext" name="replytext" class="val"><?php echo str_replace("\n", "<br />", $db->getrow($sql)["reply"]); ?></div>
                            </div>
                            <div class="editItem">
                                <div class="name">回复时间</div>
                                <input disabled id="replytime" name="replytime" class="val" value="<?php echo date("Y-m-d H:i:s", $db->getrow($sql)["replytime"]); ?>">
                            </div>
                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    <?php
    } else {
    }
    ?>

</body>

</html>
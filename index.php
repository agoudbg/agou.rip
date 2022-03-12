<?php
require("./define.php");
require("./mysql.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?php echo site_name; ?></title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>
    <meta name='apple-mobile-web-app-capable' content='yes'>
    <meta name='apple-mobile-web-app-status-bar-style' content='black'>
    <meta name='format-detection' content='telephone=no'>
    <link rel="stylesheet" type="text/css" href="src/css/card.css">
    <link rel="stylesheet" type="text/css" href="src/css/page.css">
</head>

<body class="cardBox">
    <div class="titleBox">
        <h1><?php echo site_name; ?></h1>
        <div class="buttons">
            <button onclick="window.location.href='check.php'"><i class="material-icons">search</i></button>
        </div>
    </div>
    <form action="submit.php" method="post">
        <div class="card">
            <div class="header">
                <div class="name">发布新吐槽</div>
            </div>
            <div class="content">
                <p class="status">
                    <?php if (isset($_GET["tip"])) echo $_GET["tip"]; ?>
                </p>
                <div class="editDiv">
                    <div class="editItem">
                        <div class="name">昵称</div>
                        <input id="nick" name="nick" class="val" placeholder="选填，可化名" onkeydown="if(event.keyCode==13){return false;}">
                    </div>
                    <div class="editItem">
                        <div class="name">邮箱</div>
                        <input id="email" name="email" class="val" placeholder="选填，不会被公开" onkeydown="if(event.keyCode==13){return false;}">
                    </div>
                    <div class="editItem">
                        <textarea id="text" name="text" class="val" placeholder="吐槽什么呢…" autofocus></textarea>
                    </div>
                    <div class="editItem">
                        <label class="checkbox" for="public" tabindex="0" onkeydown="if(event.keyCode==32){public.click();return false;}">
                            <input id="public" name="public" type="checkbox">
                            <i class="material-icons false">check_box_outline_blank</i>
                            <i class="material-icons true">check_box</i>
                            <span>回复后公开</span></label>
                    </div>
                </div>
            </div>
            <div class="bottom">
                <div class="word">
                    <p>请在此尽情吐槽 <?php echo my_name; ?>，但请确保您的言论符合法律法规和相关规定。</p>
                </div>
                <div class="buttons"><button class="bigButton" type="submit">发送</button></div>
            </div>
        </div>
    </form>

    <div class="titleBox">
        <h1>最近动态</h1>

    </div>
    <?php
    $page = (isset($_GET['page']) && !is_nan($_GET['page']) && ($_GET['page'] > 1) ? addslashes($_GET['page']) : 1);
    $db = new CodyMySQL(mysql_host, mysql_port, mysql_user, mysql_pass, mysql_database);
    $sql = "SELECT * FROM `post` WHERE `deleted` = 0 AND `public` = 1 AND `reply_time` > 0 ORDER BY `time` DESC LIMIT " . (10 * $page - 10) . "," . (10 * $page);
    $ret = $db->get($sql);
    foreach ($ret as $key => $value) {
    ?>
        <div class="card">
            <div class="content">
                <p><b><?php echo $value["nick"]; ?></b></p>
                <p><?php echo str_replace("\n", "<br />", $value["text"]); ?></p>
                <?php if ($value["reply"] != "") { ?><p style="margin-top: .5em;"><b><?php echo my_name; ?> 回复</b></p>
                    <p><?php echo str_replace("\n", "<br />", $value["reply"]); ?></p><?php }; ?>
            </div>
            <div class="bottom">
                <div class="word">
                    <p>发布时间：<?php echo date("Y-m-d H:i:s", $value["time"]); ?></p>
                    <?php if ($value["reply"] != "") { ?><p>回复时间：<?php echo date("Y-m-d H:i:s", $value["reply_time"]); ?></p><?php }; ?>
                </div>
            </div>
        </div>
    <?php
    }
    if (count($ret) == 0) {
    ?>
        <div class="card">
            <div class="content">
                <p>
                    <center>恐怕没有更多消息了</center>
                </p>
            </div>
        </div>
    <?php
    }
    ?>
    <div class="card">
        <div class="bottom">
            <div class="word"></div>
            <div class="buttons">
                <button class="bigButton"><?php echo $page; ?></button>
                <?php
                if ($page > 1) {
                ?>
                    <button class="bigButton" onclick="window.location.href='?page=<?php echo $page - 1; ?>'">上一页</button>
                <?php
                }
                ?>
                <?php
                if (count($ret) == 10) {
                ?>
                    <button class="bigButton" onclick="window.location.href='?page=<?php echo $page + 1; ?>'">下一页</button>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="header">
            <div class="name">说明</div>
        </div>
        <div class="content">
            <p>为防止恶意提交，会将提交人的 IP 不可逆加密后存储至数据库。</p>
            <p>友情提示：此处的昵称输入不经验证，没有实际参考价值。</p>
        </div>
        <div class="bottom">
            <div class="word">
                <p></p>
            </div>
        </div>
    </div>

</body>

</html>
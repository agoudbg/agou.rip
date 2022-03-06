<?php
require("./define.php");
require("./mysql.php");

if (!isset($_POST["text"]) || $_POST["text"] == "") {
    header("Location:index.php?tip=请填入内容。");
    die();
} else if (!empty($_POST["email"]) && !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die(header("Location:index.php?tip=请输入正确的电子邮箱地址。"));
} else {
    $db = new CodyMySQL(mysql_host, mysql_port, mysql_user, mysql_pass, mysql_database);
    $sql = "SELECT `time` FROM `post` WHERE `ip`='" . sha256(getIP()) . "' ORDER BY time DESC";
    if (time() - $db->getrow($sql)["time"] < time_limit) {
        die(header("Location:index.php?tip=发送间隔过短，请稍后再发送。"));
    }
    $msgid = newRandomKey();
    print_r((array(
        "id" => $msgid,
        "nick" => cleanHTMLTag(addslashes($_POST["nick"])),
        "email" => cleanHTMLTag(addslashes($_POST["email"])),
        "text" => cleanHTMLTag(addslashes($_POST["text"])),
        "public" => ($_POST["public"] == "on" ? 1 : 0),
        "time" => time(),
        "ip" => sha256(getIP()),
        "reply" => "",
        "reply_time" => 0,
        "deleted" => 0
    )));
    $db->insert(
        array(
            "id" => $msgid,
            "nick" => cleanHTMLTag(addslashes($_POST["nick"])),
            "email" => cleanHTMLTag(addslashes($_POST["email"])),
            "text" => cleanHTMLTag(addslashes($_POST["text"])),
            "public" => ($_POST["public"] == "on" ? 1 : 0),
            "time" => time(),
            "ip" => sha256(getIP()),
            "reply" => "",
            "reply_time" => 0,
            "deleted" => 0
        ),
        "post"
    );
    // header("Location:success.php?msgid=" . $msgid);
}

function cleanHTMLTag($text)
{
    $text = preg_replace("/<[\/\s]*(?:(?!div|br)[^>]*)>/", '', $text);
    $text = preg_replace("/<\s*div[^>]*>/", '<div>', $text);
    $text = preg_replace("/<\s*div[^>]*>/", '<div>', $text);
    $text = preg_replace("/<[\/\s]*div[^>]*>/", '<br>', $text);
    $text = preg_replace("/<br><br>/", '<br>', $text);
    return $text;
}

function newRandomKey()
{
    $shortResult = "";
    $length = 8;
    $shortWith = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
    for ($i = 0; $i < $length; $i++) {
        $shortResult[$i] = $shortWith[mt_rand(0, mb_strlen($shortWith) - 1)];
    }
    return $shortResult;
}

function get_client_ip()
{
    $ip = $_SERVER['REMOTE_ADDR'];
    if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) and preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
        foreach ($matches[0] as $xip) {
            if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                $ip = $xip;
                break;
            }
        }
    }
    return $ip;
}

function sha256($str)
{
    return hash("sha256", $str);
}

function getIP()
{
    if (@$_SERVER["HTTP_X_FORWARDED_FOR"])
        $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    else if (@$_SERVER["HTTP_CLIENT_IP"])
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    else if (@$_SERVER["REMOTE_ADDR"])
        $ip = $_SERVER["REMOTE_ADDR"];
    else if (@getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if (@getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if (@getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else
        $ip = "Unknown";
    return $ip;
}

<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;

require("foundation/asession.php");
//require("foundation/fsession.php");
require("configuration.php");
require("includes.php");
require_once("foundation/asystem_info.php");
require("foundation/fstring.php");

/* URL信息处理 */
$goods_id = intval($_GET['gid']);
if (!$goods_id) {
    trigger_error("非法请求！");
}

/* 用户信息处理 */
if (get_sess_user_id()) {
    $USER['login'] = 1;
    $USER['user_name'] = get_sess_user_name();
    $USER['user_id'] = get_sess_user_id();
    $USER['user_email'] = get_sess_user_email();
    $USER['shop_id'] = get_sess_shop_id();
} else {
    $USER['login'] = 0;
    $USER['user_name'] = '';
    $USER['user_id'] = '';
    $USER['user_email'] = '';
    $USER['shop_id'] = '';
}

//当前可访问的应用工具
$appArray = array(
    'start' => 'shop/inquiry.php',
    'post' => 'shop/inquiry2.php'
);

$appId = getAppId();
$apptarget = $appArray[$appId];

if (isset($apptarget)) {
    require($apptarget);
} else {
    echo 'no pages!';
}
?>
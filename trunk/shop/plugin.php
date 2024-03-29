<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/plugin.html
 * 如果您的模型要进行修改，请修改 models/shop/plugin.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如您有问题请到官方论坛（）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if (!function_exists("tpl_engine")) {
    require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/shop/plugin.html") > filemtime(__file__) || (file_exists("models/shop/plugin.php") && filemtime("models/shop/plugin.php") > filemtime(__file__)) ) {
    tpl_engine("default", "shop/plugin.html", 1);
    include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if (!$IWEB_SHOP_IN) {
    trigger_error('Hacking attempt');
}

/* 公共信息处理 header, left, footer */
require("foundation/module_shop.php");
require("foundation/module_users.php");
require("foundation/flefttime.php");

//引入语言包
$s_langpackage = new shoplp;

/* 数据库操作 */
dbtarget('r', $dbServs);
$dbo = new dbex();

/* 定义文件表 */
$t_shop_info = $tablePreStr . "shop_info";
$t_user_info = $tablePreStr . "user_info";
$t_users = $tablePreStr . "users";
$t_shop_category = $tablePreStr . "shop_category";
$t_goods = $tablePreStr . "goods";
$t_shop_groupbuy = $tablePreStr . "groupbuy";

/* 商铺信息处理 */
$SHOP = get_shop_info($dbo, $t_shop_info, $shop_id);
if (!$SHOP) {
    exit($s_langpackage->s_shop_error);
}//无此商铺
$sql = "select rank_id,user_name,last_login_time from $t_users where user_id='" . $SHOP['user_id'] . "'";
$ranks = $dbo->getRow($sql);
$SHOP['rank_id'] = $ranks[0];

$header['title'] = $s_langpackage->s_plugin . "- " . $SHOP['shop_name'];
$header['keywords'] = $SHOP['shop_management'];
$header['description'] = sub_str(strip_tags($SHOP['shop_intro']), 100);


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $header['title']; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7"/>
    <meta name="keywords" content="<?php echo $header['keywords']; ?>"/>
    <meta name="description" content="<?php echo $header['description']; ?>"/>
    <base href="<?php echo $baseUrl; ?>"/>
    <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/shop_<?php echo $SHOP['shop_template']; ?>.css"
          rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="skin/<?php echo $SYSINFO['templates']; ?>/css/common.css">
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/changeStyle.js"></script>
    <style>
        .shop_header {
            background: #4A9DA5;
        }

        <?php if($SHOP['shop_template_img']){?>
        .shop_header {
            background: transparent url(<?php echo  $SHOP['shop_template_img'];?>) no-repeat scroll 0 0;
        }

        <?php }?>
    </style>
</head>
<body>
<div id="wrapper">
    <?php require("shop/header.php"); ?>
    <div class="clear"></div>
    <div class="shop_header">
        <h1><?php echo $SHOP['shop_name']; ?></h1>
        <?php require("shop/menu.php"); ?>
    </div>
    <?php require("shop/left.php"); ?>
    <div class="bigpart">
        <!-- plugins !-->
        <div id="shop_right">
            <?php echo isset($plugins['shop_right']) ? show_plugins($plugins['shop_right']) : ''; ?>
        </div>
        <!-- plugins !-->
    </div>
    <?php require("shop/footer.php"); ?>
</div>
</body>
</html><?php } ?>
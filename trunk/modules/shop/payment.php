<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/shop/payment.html
 * 如果您的模型要进行修改，请修改 models/modules/shop/payment.php
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
if(filemtime("templates/default/modules/shop/payment.html") > filemtime(__file__) || (file_exists("models/modules/shop/payment.php") && filemtime("models/modules/shop/payment.php") > filemtime(__file__)) ) {
    tpl_engine("default", "modules/shop/payment.html", 1);
    include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if (!$IWEB_SHOP_IN) {
    trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");
require("foundation/module_shop.php");
require("foundation/module_payment.php");
//引入语言包
$m_langpackage = new moduleslp;
$i_langpackage = new indexlp;
$s_langpackage = new shoplp;
//数据表定义区
$t_payment = $tablePreStr . "payment";
$t_shop_payment = $tablePreStr . "shop_payment";
$t_shop_info = $tablePreStr . "shop_info";
$t_users = $tablePreStr . "users";
//读写分离定义方法
$dbo = new dbex;
dbtarget('r', $dbServs);
/* 商铺信息处理 */
include("foundation/fshop_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql = "select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if ($row['locked'] == 1) {
    session_destroy();
    trigger_error($m_langpackage->m_user_locked); //非法操作
}
$payment = get_payment_info($dbo, $t_payment, 1);

$info = get_shop_payment_info($dbo, $t_shop_payment, $shop_id);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?php echo $m_langpackage->m_u_center; ?></title>
    <link rel="stylesheet" type="text/css" href="skin/<?php echo $SYSINFO['templates']; ?>/css/modules.css">
    <link rel="stylesheet" type="text/css" href="skin/<?php echo $SYSINFO['templates']; ?>/css/layout.css">
    <link rel="stylesheet" type="text/css" href="skin/<?php echo $SYSINFO['templates']; ?>/css/style.css">
    <link rel="stylesheet" type="text/css" href="skin/<?php echo $SYSINFO['templates']; ?>/css/common.css">
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/changeStyle.js"></script>
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/userchangeStyle.js"></script>

    <style type="text/css">
        .red {
            color: red;
        }
    </style>
</head>
<body onload="menu_style_change('shop_payment');changeMenu();">
<?php require("shop/index_header.php"); ?>
<div class="site_map">
    <?php echo $m_langpackage->m_current_position; ?><A href="index.php"><?php echo $SYSINFO['sys_name']; ?></A>/<a
        href="modules.php"><?php echo $m_langpackage->m_u_center; ?></a>/&nbsp;&nbsp;<?php echo $m_langpackage->m_payment_setting; ?>
</div>
<div class="clear"></div>
<?php require("modules/left_menu.php"); ?>
<div class="main_right">
    <div class="right_top"></div>
    <div class="cont">
        <div class="cont_title"><?php echo $m_langpackage->m_payment_setting; ?></div>
        <hr/>
        <form action="do.php?act=shop_payment" method="post" name="form_shop_pay" onsubmit="return checkForm();">
            <table width="100%" class="form_table">
                <tr class="center">
                    <th width="100"><?php echo $m_langpackage->m_payment_name; ?></th>
                    <th><?php echo $m_langpackage->m_payment_desc; ?></th>
                    <th width="30"><?php echo $m_langpackage->m_payment_enable; ?></th>
                    <th width="60"><?php echo $m_langpackage->m_manage; ?></th>
                </tr>
                <?php foreach ($payment as $value) { ?>
                    <tr>
                        <td class="center"><?php echo $value['pay_name']; ?></td>
                        <td><?php echo $value['pay_desc']; ?></td>
                        <td class="center"><?php if (isset($info[$value['pay_id']]['enabled']) && $info[$value['pay_id']]['enabled']) { ?>
                                <img src="skin/default/images/yes.gif"/><?php } else { ?><img
                                src="skin/default/images/no.gif"/><?php } ?></td>
                        <td class="center"><?php if (isset($info[$value['pay_id']]) && $info[$value['pay_id']]) { ?><a
                                href="modules.php?app=shop_payment_edit&pay_id=<?php echo $value['pay_id']; ?>"><?php echo $m_langpackage->m_payment_config; ?></a>
                                <br/><a href="do.php?act=shop_payment_del&pay_id=<?php echo $value['pay_id']; ?>"
                                        onclick="return confirm('<?php echo $m_langpackage->m_payment_suredel; ?>');"><?php echo $m_langpackage->m_payment_delete; ?></a><?php } else { ?>
                                <br/><a
                                href="modules.php?app=shop_payment_add&pay_id=<?php echo $value['pay_id']; ?>"><?php echo $m_langpackage->m_payment_install; ?></a><?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </form>
    </div>
    <div class="clear"></div>
    <div class="right_bottom"></div>
    <div class="back_top"><a href="#"></a></div>
</div>
<?php require("shop/index_footer.php"); ?>
</body>
</html><?php } ?>
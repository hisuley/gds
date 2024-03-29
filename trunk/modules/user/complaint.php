<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/user/complaint.html
 * 如果您的模型要进行修改，请修改 models/modules/user/complaint.php
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
if(filemtime("templates/default/modules/user/complaint.html") > filemtime(__file__) || (file_exists("models/modules/user/complaint.php") && filemtime("models/modules/user/complaint.php") > filemtime(__file__)) ) {
    tpl_engine("default", "modules/user/complaint.html", 1);
    include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}
require("foundation/module_complaint.php");

//引入语言包
$m_langpackage = new moduleslp;
$i_langpackage = new indexlp;

//数据表定义区
$t_order_info = $tablePreStr . "order_info";
$t_shop_info = $tablePreStr . "shop_info";
$t_complaint_type = $tablePreStr . "complaint_type";
$t_order_goods = $tablePreStr . "order_goods";
$t_complaints = $tablePreStr . "complaints";

//变量定义区
$order_id = intval(get_args('order_id'));

$dbo = new dbex;
//读写分离定义方法
dbtarget('r', $dbServs);
$sql = "select user_id from $t_complaints where user_id=$user_id and order_id='$order_id'";
$row = $dbo->getRow($sql);
if ($row) {
    trigger_error('您已经投诉过该商品，请不要重复投诉！');
}
$sql = "select a.order_id,a.payid,a.shop_id,og.goods_id,og.goods_name,a.order_amount,a.order_time,a.order_status,a.pay_status,a.transport_status,a.seller_reply,a.group_id,c.user_id,c.shop_name from `$t_order_info` as a, `$t_shop_info` as c,`$t_order_goods` as og where a.order_id=og.order_id and a.shop_id=c.shop_id and a.order_id='$order_id' ";
$order_rs = $dbo->getRow($sql);

$complaints_title = get_complaint_type_all($dbo, "*", $t_complaint_type);

//$complaints_title=array(
//	'1'=>'成交不卖',
//	'2'=>'收款不发货',
//	'3'=>'商品与描述不符',
//	'4'=>'评价纠纷',
//	'5'=>'卖家拒绝履行交易',
//	'6'=>'退款纠纷',
//	'7'=>'卖家要求买家先确认收货，卖家再发货',
//	'8'=>'诚保代充-未按时发货索赔',
//	'9'=>'卖家缺货无法交易',
//);

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

</head>
<body onload="menu_style_change('user_my_order');changeMenu();">
<?php require("shop/index_header.php"); ?>
<div class="site_map">
    <?php echo $m_langpackage->m_current_position; ?><A href="index.php"><?php echo $SYSINFO['sys_name']; ?></A>/<a
        href="modules.php"><?php echo $m_langpackage->m_u_center; ?></a>/&nbsp;&nbsp;<?php echo $m_langpackage->m_complaints; ?>
</div>
<div class="clear"></div>
<?php require("modules/left_menu.php"); ?>
<div class="main_right">
    <div class="right_top"></div>
    <div class="cont">
        <div class="cont_title"><?php echo $m_langpackage->m_complaints; ?></div>
        <hr/>
        <form action="do.php?act=user_complaint_add" method="post" name="form_profile" onsubmit="return checkform1();">
            <table width="100%" style="border:0" cellspacing="0">
                <tr>
                    <td class="textright" width="100px;"><?php echo $m_langpackage->m_by_complainant; ?>：</td>
                    <td class="textleft"><a href="shop.php?shopid=<?php echo $order_rs['shop_id']; ?>&app=index"
                                            target="_blank"><?php echo $order_rs['shop_name']; ?></a><input
                            type="hidden" name="shopid" value="<?php echo $order_rs['shop_id']; ?>"><input type="hidden"
                                                                                                           name="shop_name"
                                                                                                           value="<?php echo $order_rs['shop_name']; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="textright"><?php echo $m_langpackage->m_related_products; ?>：</td>
                    <td class="textleft"><a href="goods.php?id=<?php echo $order_rs['goods_id']; ?>"
                                            target="_blank"><?php echo $order_rs['goods_name']; ?></a><input
                            type="hidden" name="goods_id" value="<?php echo $order_rs['goods_id']; ?>"><input
                            type="hidden" name="goods_name" value="<?php echo $order_rs['goods_name']; ?>"></td>
                </tr>
                <tr>
                    <td class="textright"><?php echo $m_langpackage->m_of_complaint; ?>：</td>
                    <td class="textleft"><select name="complaints_title" id="complaints_title" require="true"
                                                 datatype="Require"
                                                 msg="<?php echo $m_langpackage->m_select_complaints_reason; ?>">
                            <option selected><?php echo $m_langpackage->m_select_complaints_reason; ?></option>
                            <?php foreach ($complaints_title as $val) { ?>
                                <option
                                    value="<?php echo $val['type_content']; ?>"><?php echo $val['type_content']; ?></option>
                            <?php } ?>
                        </select>
                        <span id="ShowTypeMsg"
                              style="padding-left:5px;"><?php echo $m_langpackage->m_choose_trade_complaints; ?></span>
                    </td>
                </tr>
                <tr>
                    <td class="textright" valign="top"><?php echo $m_langpackage->m_complaints_content; ?>：</td>
                    <td class="textleft"><textarea name="complaints_content" id="complaints_content" cols="60" rows="10"
                                                   require="true" datatype="Require"
                                                   msg="<?php echo $m_langpackage->m_please_enter_complaints; ?>"
                                                   class="inputmain"
                                                   onblur="cutSize(this,500);countShow2(this.value,'count');"
                                                   onkeyup="cutSize(this,500);countShow2(this.value,'count');"></textarea>
                        <br/>(<?php echo $m_langpackage->m_current; ?><span
                            id="count">0</span><?php echo $m_langpackage->m_upto_bytes; ?>)<br/><span
                            style="padding:10px; "><?php echo $m_langpackage->m_real_evidence_dispute; ?></span></td>
                </tr>
                <tr>
                    <td class="textright"><?php echo $i_langpackage->i_verifycode; ?>：</td>
                    <td class="textleft " style="vertical-align:middle"><input type="text" class="border_c"
                                                                               name="veriCode" id="veriCode"
                                                                               style="width:100px; *margin:0 15px  13px 0;"
                                                                               maxlength="4"/>
                        <img border="0" src="servtools/veriCodes.php" width="80" height="40" align="absmiddle"
                             id="verCodePic"><a style="display:inline-block;*margin:0 0 13px 10px" href="javascript:;"
                                                onclick="return getVerCode();"><?php echo $i_langpackage->i_change_img; ?></a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center"><input class="submit" type="submit" name="submit"
                                                          value="<?php echo $m_langpackage->m_send; ?>"/></td>
                </tr>
            </table>
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
        </form>
    </div>
    <div class="clear"></div>
    <div class="right_bottom"></div>
    <div class="back_top"><a href="#"></a></div>
</div>
<?php require("shop/index_footer.php"); ?>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
    <!--
    function cutSize(obj, len) {
        //obj.value = obj.value.replace(/(^[\s]*)|([\s]*$)/g, "");
        var str = obj.value;
        if (str.replace(/[^\x00-\xff]/g, '**').length <= len) {
            return;
        }
        str = str.substr(0, len);
        while (str.replace(/[^\x00-\xff]/g, '**').length > len) {
            str = str.substr(0, str.length - 1);
        }
        obj.blur();
        obj.value = str;
        obj.focus();
    }

    function countShow2(str, idName) {
        document.getElementById(idName).innerHTML = str.replace(/[^\x00-\xff]/g, '**').length;
    }
    function checkform1() {
        var type = document.getElementById('complaints_title').value;
        var content = document.getElementById('complaints_content').value;
        var veriCode = document.getElementById("veriCode").value;
        if (type.length == 0) {
            alert("请选择投诉原因！");
            return false;
        }
        if (content.length == 0) {
            alert("请输入投入内容！");
            return false;
        }
        if (!veriCode) {
            alert('<?php echo $i_langpackage->i_verifycode_notnone;?>');
            return false;
        }
    }
    function getVerCode() {
        document.getElementById("verCodePic").src = "servtools/veriCodes.php?vc=" + Math.random();
        return false;
    }
    //-->
</script>
</body>
</html><?php } ?>
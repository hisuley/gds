<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/modules/groupbuy/list.html
 * 如果您的模型要进行修改，请修改 models/modules/groupbuy/list.php
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
if(filemtime("templates/default/modules/groupbuy/list.html") > filemtime(__file__) || (file_exists("models/modules/groupbuy/list.php") && filemtime("models/modules/groupbuy/list.php") > filemtime(__file__)) ) {
    tpl_engine("default", "modules/groupbuy/list.html", 1);
    include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if (!$IWEB_SHOP_IN) {
    trigger_error('Hacking attempt');
}

require("foundation/acheck_shop_creat.php");
require("foundation/ashop_news_category.php");
require("foundation/module_category.php");
require("foundation/module_type.php");
require("foundation/module_shop.php");
require("foundation/module_groupbuy.php");

//引入语言包
$m_langpackage = new moduleslp;
$i_langpackage = new indexlp;
$s_langpackage = new shoplp;
$ucat_id = intval(get_args('ucat_id'));
$ctime = new time_class;
$now_time = $ctime->long_time();

//数据表定义区
$t_goods = $tablePreStr . "goods";
$t_brand = $tablePreStr . "brand";
$t_goods_types = $tablePreStr . "goods_types";
$t_shop_category = $tablePreStr . "shop_category";
$t_groupbuy = $tablePreStr . "groupbuy";
$t_groupbuy_log = $tablePreStr . "groupbuy_log";
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
$result = get_groupbuy_lst($dbo, $t_groupbuy, $t_goods, $shop_id, 10);
$shop_category = get_shop_category_list($dbo, $t_shop_category, $shop_id);
$html_shop_category = html_format_shop_category($shop_category, $ucat_id);
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
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/userchangeStyle.js"></script>
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/changeStyle.js"></script>
    <style type="text/css">
        th {
            background: #EFEFEF
        }

        .edit span {
            background: #efefef;
        }

        .search {
            margin: 5px;
            height: 20px;
            background: #fff;
            width: 90%;
            padding-left: 0px;
        }

        .search input {
            color: #444;
        }

        td.img img {
            cursor: pointer;
        }

        td div.goodsname {
            line-height: 18px;
            height: 36px;
            font-weight: bold;
        }

        td span.category {
            color: #FF6600;
        }
    </style>
</head>
<body onload="menu_style_change('groupbuy_list');changeMenu();">
<?php require("shop/index_header.php"); ?>
<div class="site_map">
    <?php echo $m_langpackage->m_current_position; ?><A href="index.php"><?php echo $SYSINFO['sys_name']; ?></A>/<a
        href="modules.php"><?php echo $m_langpackage->m_u_center; ?></a>/&nbsp;&nbsp;<?php echo $m_langpackage->m_groupbuy_list; ?>
</div>
<div class="clear"></div>
<?php require("modules/left_menu.php"); ?>
<div class="main_right">
    <div class="right_top"></div>
    <div class="cont">
        <div class="cont_title"><span class="tr_op"><a
                    href="modules.php?app=groupbuy_add"><?php echo $m_langpackage->m_group_add; ?></a></span><?php echo $m_langpackage->m_group_list; ?>
        </div>
        <hr/>

        <form action="do.php?act=goods_list" method="post" onsubmit="return submitform();">
            <table width="100%" cellspacing="0">
                <tr class="center">
                    <th width="20"><input type="checkbox" name="c" value="" onclick="checkall(this)"/></th>
                    <th width="82"></th>
                    <th><?php echo $m_langpackage->m_group_name; ?></th>
                    <th width="80"><?php echo $m_langpackage->m_group_status; ?></th>
                    <th width="100"><?php echo $m_langpackage->m_start_time; ?></th>
                    <th width="100"><?php echo $m_langpackage->m_order_num; ?></th>
                    <th width="80"><?php echo $m_langpackage->m_manage; ?></th>
                </tr>
                <?php
                if (!empty($result['result'])) {
                    foreach ($result['result'] as $v) {
                        ?>
                        <tr>
                            <td><input type="checkbox" name="checkbox[]" value="<?php echo $v['goods_id']; ?>"/></td>
                            <td class="center"><a href="goods.php?app=groupbuyinfo&id=<?php echo $v['group_id']; ?>"
                                                  target="_blank"><img src="<?php echo $v['goods_thumb']; ?>" width="80"
                                                                       height="80"
                                                                       onerror="this.src='skin/default/images/nopic.gif'"/></a>
                            </td>
                            <td class="center"><a href="goods.php?app=groupbuyinfo&id=<?php echo $v['group_id']; ?>"
                                                  target="_blank"><?php echo $v['group_name']; ?></a></td>
                            <td align="center">
                                <?php if ($v['examine'] != 0) { ?>
                                    <?php if ($v['recommended'] == 0) {
                                        if ($v['start_time'] <= $now_time and $v['end_time'] >= $now_time) {
                                            echo $m_langpackage->m_ing;
                                        }
                                        if ($v['start_time'] >= $now_time) {
                                            echo $m_langpackage->m_no_published;
                                        }
                                        if ($v['end_time'] <= $now_time) {
                                            echo $m_langpackage->m_end;
                                        }
                                    } else {
                                        echo $m_langpackage->m_end;
                                    } ?>
                                <?php } else { ?>
                                    <?php echo $i_langpackage->i_groupbuy_lock; ?>
                                <?php } ?>
                            </td>
                            <td class="name"><?php echo $m_langpackage->m_from; ?><?php echo $v['start_time']; ?>
                                <br/><?php echo $m_langpackage->m_to; ?><?php echo $v['end_time']; ?></td>
                            <td align="center"><?php echo $v['purchase_num']; ?>/<?php echo $v['min_quantity']; ?></td>
                            <td align="center">
                                <?php if ($v['examine'] != 0 && $v['recommended'] == 0 and $v['start_time'] >= $now_time) { ?>
                                    <a href="do.php?act=groupbuy_release&id=<?php echo $v['group_id']; ?>"
                                       onclick="return confirm('<?php echo $m_langpackage->m_confirm; ?>');"><?php echo $m_langpackage->m_published; ?></a>
                                    <br/>
                                <?php } ?>
                                <?php if ($v['examine'] != 0 && $v['recommended'] == 1 or $v['end_time'] <= $now_time) { ?>
                                    <a href="modules.php?app=shop_my_order&id=<?php echo $v['group_id']; ?>"><?php echo $m_langpackage->m_order_group; ?>
                                        (<?php echo $v['order_num']; ?>)</a><br/>
                                <?php } ?>
                                <?php if ($v['examine'] != 0) { ?>
                                    <a href="modules.php?app=groupbuy_login&id=<?php echo $v['group_id']; ?>"
                                       target="_blank"><?php echo $m_langpackage->m_order_status; ?></a><br/>
                                <?php } ?>
                                <?php if ($v['examine'] != 0 && $v['recommended'] == 0 and $v['start_time'] <= $now_time and $v['end_time'] >= $now_time) { ?>
                                    <a href="do.php?act=groupbuy_end&id=<?php echo $v['group_id']; ?>"
                                       onclick="return con(<?php echo $v['purchase_num']; ?>,<?php echo $v['min_quantity']; ?>);"><?php echo $m_langpackage->m_accomplish; ?></a>
                                    <br/>
                                <?php } ?>
                                <?php if ($v['examine'] == 0) { ?>
                                    <font color=red><?php echo $i_langpackage->i_groupbuy_lock; ?></font><br/>
                                <?php } ?>
                                <a href="do.php?act=groupbuy_del&id=<?php echo $v['group_id']; ?>"
                                   onclick="return confirm('<?php echo $m_langpackage->m_sure_delgoods; ?>');"><?php echo $m_langpackage->m_del; ?></a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="7" class="center">
                            <div class="page"><?php require("modules/page.php"); ?></div>
                        </td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td colspan="7" class="center"><?php echo $m_langpackage->m_nogoods_list; ?></td>
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
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
    <!--
    var inputs = document.getElementsByTagName("input");
    function submitform() {
        var status = document.getElementsByName("checkbox");
        var checknum = 0;
        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type == 'checkbox') {
                if (inputs[i].checked) {
                    checknum++;
                }
            }
        }
        if (checknum == 0) {
            alert("<?php echo  $m_langpackage->m_selceted_one;?>");
            return false;
        }
        return true;
    }

    function checkall(obj) {
        if (obj.checked) {
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type == 'checkbox') {
                    inputs[i].checked = true;
                }
            }
        } else {
            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type == 'checkbox') {
                    inputs[i].checked = false;
                }
            }
        }
    }
    function con(aa, bb) {
        if (aa < bb) {
            if (confirm('<?php echo  $m_langpackage->m_confirm_no;?>')) {
                return true;
            } else {
                return false;
            }

        } else {
            return confirm('<?php echo  $m_langpackage->m_confirm;?>')
        }
    }

    //-->
</script>
</body>
</html><?php } ?>
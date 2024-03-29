<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}
//require("foundation/acheck_shop_creat.php");
require("foundation/module_order.php");
require("foundation/module_goods.php");
//语言包引入
$m_langpackage = new moduleslp;
$s_langpackage = new shoplp;

//数据表定义区
$t_order_info = $tablePreStr . "order_info";
$t_users = $tablePreStr . "users";
$t_order_goods = $tablePreStr . "order_goods";
$t_goods = $tablePreStr . "goods";
$t_protect_rights = $tablePreStr . "protect_rights";
$t_shop_info = $tablePreStr . "shop_info";
$order_id = intval(get_args('id'));
if (!$order_id) {
    exit($m_langpackage->m_handle_err);
}

//定义写操作
dbtarget('w', $dbServs);
$dbo = new dbex;

//判断商品是否锁定，锁定则不许操作
$sql = "select b.goods_id,a.transport_type from $t_order_info as a join $t_order_goods as b on a.order_id=b.order_id where a.order_id=$order_id";
$row1 = $dbo->getRow($sql);
if ($row1) {
    $goods_id = $row1['goods_id'];
}
include("foundation/fgoods_locked.php");
//判断用户是否锁定，锁定则不许操作
$sql = "select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if ($row['locked'] == 1) {
    session_destroy();
    trigger_error($m_langpackage->m_user_locked); //非法操作
}

//判断订单是否存在，锁定则不许操作
$order_info = get_order_info($dbo, $t_order_info, $t_order_goods, $t_goods, $t_shop_info, $order_id, $user_id);
if (!$order_info) {
    action_return(0, $m_langpackage->m_noex_thisorder);
}

//判断订单状态，锁定则不许操作
if ($order_info['order_status'] == '0') {
    action_return(0, $m_langpackage->m_order_cancel);
} elseif ($order_info['order_status'] != '3') {
    action_return(0, '该订单还未确定收货!');
}

set_session("goodsvercode", md5(rand(10000, 999999)));

$sql = "select *from `$t_protect_rights` where order_id = $order_id order by protect_date desc";
$result = $dbo->getRs($sql);

$is_allow_service = 0;
$now_time = date("Y-m-d H:i:s", time() - (21 * 60 * 60));
$sql = "select protect_date from `$t_protect_rights` where order_id =$order_id and user_id=$user_id and user_type=0 order by protect_date limit 1";
$row = $dbo->getRow($sql);
if ($row) {
    if ($row['protect_date'] < $now_time) {
        $is_allow_service = 1;
    }
}

?>
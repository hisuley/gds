<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}
require('foundation/module_start.php');

//引入语言包
$m_langpackage = new moduleslp;
$i_langpackage = new indexlp;
$s_langpackage = new shoplp;

//数据表定义区
$t_order_info = $tablePreStr . "order_info";
$t_goods = $tablePreStr . "goods";
$t_shop_info = $tablePreStr . "shop_info";
$t_order_goods = $tablePreStr . "order_goods";
//读写分离定义方法
$dbo = new dbex;
dbtarget('r', $dbServs);
$state = intval(get_args('state'));
$order_id = short_check(get_args('order_id'));
$start_time = short_check(get_args('start_time'));
$end_time = short_check(get_args('end_time'));
$user_id = get_sess_user_id();
$result = get_myorder_info_with_search($dbo, $t_order_info, $t_shop_info, $t_goods, $t_order_goods, $user_id, $state, 10, $start_time, $end_time, $order_id);

?>
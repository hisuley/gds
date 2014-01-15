<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

//引入模块公共方法文件11
require 'foundation/module_order.php';

//语言包引入
$m_langpackage = new moduleslp;

//定义文件表
$t_order_info = $tablePreStr . "order_info";

// 处理post变量
$order_id = intval(get_args('order_id'));
$new_message = short_check1(get_args('new_message'));
$message = short_check1(get_args('message'));
$post['message'] = $message . "\n" . $new_message;

//数据库操作
dbtarget('w', $dbServs);
$dbo = new dbex();
$update = upd_order_info($dbo, $t_order_info, $post, $order_id);
if ($update) {
    action_return(1, $m_langpackage->m_adm_suc, 'modules.php?app=user_order_view&order_id=' . $order_id);
} else {
    action_return(0, $m_langpackage->m_adm_lose, 'modules.php?app=user_my_order');
}
exit;
?>
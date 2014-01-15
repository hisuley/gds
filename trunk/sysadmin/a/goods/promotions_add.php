<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}
require("../foundation/module_promotions.php");
require_once("../foundation/module_admin_logs.php");

//语言包引入
$a_langpackage = new adminlp;
//权限管理
$right = check_rights("promotions_add");
if (!$right) {
    action_return(0, $a_langpackage->a_privilege_mess, 'm.php?app=error');
}

/* post 数据处理 */
$post['content'] = short_check(get_args('content'));
$post['promote_price'] = short_check(get_args('promote_price'));
$post['goods_id'] = intval(get_args('goods_id'));
$post['start_time'] = short_check(get_args('start_time'));
$post['end_time'] = short_check(get_args('end_time'));
$post['is_enabled'] = intval(get_args('is_enabled'));
if (empty($post['promote_price'])) {
    action_return(0, $a_langpackage->a_promote_price_notnone, '-1');
    exit;
}

//数据表定义区
$t_goods_promotions = $tablePreStr . "goods_promotions";
$t_admin_log = $tablePreStr . "admin_log";

//定义写操作
dbtarget('w', $dbServs);
$dbo = new dbex;

$insert_id = insert_promotions_info($dbo, $t_goods_promotions, $post);

if ($insert_id) {
    admin_log($dbo, $t_admin_log, $a_langpackage->a_goods_promotions_add . "：$insert_id");
    action_return(1, $a_langpackage->a_add_suc);
} else {
    action_return(0, $a_langpackage->a_add_lose, '-1');
}
?>
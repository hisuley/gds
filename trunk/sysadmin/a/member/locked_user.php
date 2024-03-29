<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

require_once("../foundation/module_users.php");
require_once("../foundation/module_admin_logs.php");

//语言包引入
$a_langpackage = new adminlp;
//print_r($_POST);
$user_id = get_args('user_id');

//权限管理
$right = check_rights("user_lock");
if (!$right) {
    action_return(0, $a_langpackage->a_privilege_mess, 'm.php?app=error');
}

if ($user_id) {
    $user_id = implode(",", $user_id);
} else {
    $user_id = intval(get_args('id'));
}
if (!$user_id) {
    trigger_error($a_langpackage->a_error);
}

//数据表定义区
$t_users = $tablePreStr . "users";
$t_admin_log = $tablePreStr . "admin_log";
$t_goods = $tablePreStr . "goods";

//定义写操作
$dbo = new dbex;
dbtarget('w', $dbServs);

$sql = "update `$t_users` set locked='1' where user_id in($user_id)";

if ($dbo->exeUpdate($sql)) {
    admin_log($dbo, $t_admin_log, $sn = $a_langpackage->a_user_locked);
    $sql2 = "update $t_goods set is_on_sale='0' where shop_id in ($user_id)"; //将物品下架
    $dbo->exeUpdate($sql2);
    action_return(1, $a_langpackage->a_amend_suc, 'm.php?app=complaint_list');
} else {
    action_return(0, $a_langpackage->a_amend_lose, 'm.php?app=complaint_list');
}
?>
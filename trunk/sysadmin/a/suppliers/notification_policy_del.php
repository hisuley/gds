<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage = new adminlp;

//权限管理
$right = check_rights("notification_policy_del");
if (!$right) {
    action_return(0, $a_langpackage->a_privilege_mess, 'm.php?app=error');
}


/* get */
$policy_id = intval(get_args('id'));

if (!$policy_id) {
    action_return(0, $a_langpackage->a_error, '-1');
}

//数据表定义区
$t_notification_policy = $tablePreStr . "notification_policy";
$t_admin_log = $tablePreStr . "admin_log";

//定义写操作
dbtarget('w', $dbServs);
$dbo = new dbex;

$sql = "delete from `$t_notification_policy` where policy_id=$policy_id";

if ($dbo->exeUpdate($sql)) {
    admin_log($dbo, $t_admin_log, $a_langpackage->a_notification_policy_del . "：$policy_id");
    action_return(1, $a_langpackage->a_del_suc, 'm.php?app=notification_policy_list');
} else {
    action_return(0, $a_langpackage->a_del_lose, '-1');
}
?>
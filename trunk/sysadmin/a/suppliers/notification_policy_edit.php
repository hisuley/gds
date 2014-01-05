<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("../foundation/module_notification_policy.php");
require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("notification_policy_update");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
/* post 数据处理 */
$post['policy_title'] = short_check(get_args('policy_title'));
$post['policy_content'] = short_check(get_args('policy_content'));
$post['sort_order'] = intval(get_args('sort_order'));

if(empty($post['policy_title'])) {
	action_return(0,$a_langpackage->a_class_null,'-1');
	exit;
}

$policy_id = intval(get_args('policy_id'));
if(!$policy_id) {trigger_error($a_langpackage->a_error);}

//数据表定义区
$t_notification_policy = $tablePreStr."notification_policy";
$t_admin_log = $tablePreStr."admin_log";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$count = check_policy_title($dbo,$t_notification_policy,$post['policy_title']);
if($count[0]) {
	action_return(0,$a_langpackage->a_notification_policy_repeat,'-1');
	exit;
}
if(update_policy_info($dbo,$t_notification_policy,$post,$policy_id)) {
	admin_log($dbo,$t_admin_log,$a_langpackage->a_notification_policy_edit."：$policy_id");
	action_return(1,$a_langpackage->a_amend_suc,'m.php?app=notification_policy_edit&id='.$policy_id);
} else {
	action_return(0,$a_langpackage->a_amend_lose,'-1');
}
?>
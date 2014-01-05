<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("../foundation/module_distributor.php");
require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("distributor_update");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
/* post 数据处理 */
$post['distributor_name'] = short_check(get_args('distributor_name'));
$post['distributor_intro'] = short_check(get_args('distributor_intro'));
$post['sort_order'] = intval(get_args('sort_order'));

if(empty($post['distributor_name'])) {
	action_return(0,$a_langpackage->a_class_null,'-1');
	exit;
}

$distributor_id = intval(get_args('distributor_id'));
if(!$distributor_id) {trigger_error($a_langpackage->a_error);}

//数据表定义区
$t_distributor = $tablePreStr."distributor";
$t_admin_log = $tablePreStr."admin_log";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$count = check_distributor_name($dbo,$t_distributor,$post['distributor_name']);
if($count[0]) {
	action_return(0,$a_langpackage->a_distributor_name_repeat,'-1');
	exit;
}
if(update_distributor_info($dbo,$t_distributor,$post,$distributor_id)) {
	admin_log($dbo,$t_admin_log,$a_langpackage->a_distributor_edit."：$distributor_id");
	action_return(1,$a_langpackage->a_amend_suc,'m.php?app=distributor_edit&id='.$distributor_id);
} else {
	action_return(0,$a_langpackage->a_amend_lose,'-1');
}
?>
<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_users.php");
require_once("../foundation/module_admin_logs.php");

//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("user_level_del");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}

/* get */
$level_id=get_args('level_id');

if($level_id){
	$id=implode(",", $level_id);
}else{
	$id = intval(get_args('id'));
}
if(!$id) {
	action_return(0,$a_langpackage->a_error,'-1');
}

//数据表定义区
$t_user_level = $tablePreStr."user_level";
$t_admin_log = $tablePreStr."admin_log";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$sql="delete from $t_user_level where level_id in($id)";

if($dbo->exeUpdate($sql)) {
	admin_log($dbo,$t_admin_log,$a_langpackage->a_user_level_del.":".$id);
	action_return();
} else {
	action_return(0,$a_langpackage->a_del_lose,'-1');
}
?>
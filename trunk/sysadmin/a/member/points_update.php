<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_news.php");
require_once("../foundation/module_admin_logs.php");

//语言包引入
$a_langpackage=new adminlp;
//数据表定义区
$t_settings = $tablePreStr."settings";
$t_admin_log = $tablePreStr."admin_log";

$ctime = new time_class;

$right=check_rights("points_update");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
/*数据处理 */
dbtarget('r',$dbServs);
$dbo=new dbex;

$sql = "select * from `$t_settings`";
$result = $dbo->getRs($sql);
if($result) {
	foreach($result as $v) {
		$SYSINFO[$v['variable']] = $v['value'];
	}
}
$sysinfo = get_args('sysinfo');
$sysinfo['reg_points']=intval($sysinfo['reg_points']);
if($sysinfo['reg_points']==0){
	$sysinfo['reg_points']=10;
}
$sysinfo['info_points']=intval($sysinfo['info_points']);
if($sysinfo['info_points']==0){
	$sysinfo['info_points']=10;
}
$sysinfo['email_points']=intval($sysinfo['email_points']);
if($sysinfo['email_points']==0){
	$sysinfo['email_points']=10;
}
$sysinfo['phone_points']=intval($sysinfo['phone_points']);
if($sysinfo['phone_points']==0){
	$sysinfo['phone_points']=10;
}
$sysinfo['points_rate']=intval($sysinfo['points_rate']);
if($sysinfo['points_rate']==0){
	$sysinfo['points_rate']=100;
}
$sysinfo['rmb_rate']=intval($sysinfo['rmb_rate']);
if($sysinfo['rmb_rate']==0){
	$sysinfo['rmb_rate']=1;
}

//数据表定义区
$t_settings = $tablePreStr."settings";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$time = $ctime->long_time();

$sql = "REPLACE INTO `$t_settings` (variable,`value`) VALUES('lastupdate','$time')";
foreach($sysinfo as $k=>$v) {
	$sql .= ",('$k','$v')";
}

if($dbo->exeUpdate($sql)) {
	/** 添加log */
	$admin_log =$a_langpackage->a_update_points_set;
	admin_log($dbo,$t_admin_log,$admin_log);

	action_return(1,$a_langpackage->a_upd_suc);
} else {
	action_return(0,$a_langpackage->a_upd_lose,'-1');
}
?>
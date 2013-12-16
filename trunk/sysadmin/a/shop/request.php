<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_admin_logs.php");

//语言包引入
$a_langpackage=new adminlp;

/* post 数据处理 */
$request_id = intval(get_args('id'));
$s = intval(get_args('s'));

$requestid=get_args('request_id');

if($requestid){
	$request_id=implode(",", $requestid);
}else{
	$request_id = intval(get_args('id'));
}

if(!$request_id) {exit($a_langpackage->a_error);}


// 数据表定义区
$t_shop_request = $tablePreStr."shop_request";
$t_users = $tablePreStr."users";
$t_admin_log = $tablePreStr."admin_log";
$t_remind = $tablePreStr."remind_info";

// 定义读操作
dbtarget('r',$dbServs);
$dbo = new dbex;
$sql = "select user_id from `$t_shop_request` where request_id in($request_id)";
$rs = $dbo->getRs($sql);
error_reporting(E_ALL);
error_log('Refuse ID:'.$request_id." Refuse Type:".$s);
//if($row['status']==$s) {
//	action_return(1,$a_langpackage->a_handle_suc);
//}

//权限管理
$right=check_rights("company_oper");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}else{
	// 定义写操作
	dbtarget('w',$dbServs);
	$dbo = new dbex;
	$sql = "update `$t_shop_request` set status='$s' where request_id in($request_id)";
	$dbo->exeUpdate($sql);
	if($s=='1') {
		foreach($rs as $key=>$val){
			$userid_array[$key]=$val['user_id'];
		}
		$user_id=implode(",", $userid_array);
		$sql = "update `$t_users` set rank_id=2 where user_id in($user_id)";
		$dbo->exeUpdate($sql);
	}elseif($s == '2'){
		error_log('Refuse:'.print_r($rs, true));
		require_once("../foundation/module_remind.php");
		foreach($rs as $key=>$val){
			$rejectInfo = array(
				'user_id' => $val['user_id'],
				'remind_info' => '您的开店申请审核失败，请修改后提交',
				'remind_time' => date('Y-m-d h:i:s'),
				'isread' => 0
				);
			error_log('Reject Info:'.print_r($rejectInfo, true));
			$returnMsg = insert_remind_info($dbo, $t_remind, $rejectInfo);
			error_log('Insert Return:'.print_r($returnMsg, true));
		}
		
	}
	admin_log($dbo,$t_admin_log,$sn = $a_langpackage->a_audit_operate);
	action_return(1,$a_langpackage->a_handle_suc);
}
?>
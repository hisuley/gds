<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require_once("../foundation/module_users.php");
require_once("../foundation/module_admin_logs.php");
require_once("../foundation/module_remind.php");

//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("user_update");
$shop_right=check_rights("shop_update");
if(!$right and !$shop_right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

//定义文件表
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_admin_log = $tablePreStr."admin_log";
$t_remind_info = $tablePreStr."remind_info";

// 处理post变量
$post['user_truename'] = short_check(get_args('user_truename'));
$post['user_birthday'] = intval(get_args('Y')) . '-' .intval(get_args('M')) . '-' .intval(get_args('D'));
$post['user_gender'] = intval(get_args('user_gender'));
$post['user_marry'] = intval(get_args('user_marry'));
$post['user_mobile'] = short_check(get_args('user_mobile'));
$post['user_telphone'] = short_check(get_args('user_telphone'));
$post['user_zipcode'] = short_check(get_args('user_zipcode'));
$post['user_address'] = short_check(get_args('user_address'));
$post['user_qq'] = short_check(get_args('user_qq'));
$post['user_msn'] = short_check(get_args('user_msn'));
$post['user_skype'] = short_check(get_args('user_skype'));
$post['user_country'] = intval(get_args('country'));
$post['user_province'] = intval(get_args('province'));
$post['user_city'] = intval(get_args('city'));
$post['user_district'] = intval(get_args('district'));

$post2['email_check'] = intval(get_args('email_check'));
$post2['locked'] = intval(get_args('locked_status'));
$post2['rank_id'] = intval(get_args('rank_id'));
$post2['user_email'] = short_check(get_args('user_email'));
if(get_args('password')) {
	$post2['user_passwd'] = md5(get_args('password'));
}
$user_id = intval(get_args('user_id'));
if(!$user_id) { trigger_error($a_langpackage->a_error);}

//查询$t_users表中的数据，与原数据对比，如果修改了，则发送站内消息给用户
$sql = "select * from `$t_users` where user_id=$user_id";
$rs = $dbo->getRow($sql);

if($rs){
	$nowtime = $ctime->long_time();
	if(intval(get_args('rank_id'))) {
		if($rs['rank_id']!=$post['rank_id']){
			$array = array(
				'user_id' => $user_id,
				'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_mem_level,
				'remind_time' => $nowtime,
			);
			insert_remind_info($dbo,$t_remind_info,$array);
		}
	}
	if(get_args('password')) {
		if($rs['user_passwd']!=md5($post['user_passwd'])){
			$array = array(
				'user_id' => $user_id,
				'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_mi_ti,
				'remind_time' => $nowtime,
			);
			insert_remind_info($dbo,$t_remind_info,$array);
		}
	}
}

if(update_user_info($dbo,$t_users,$post2,$user_id) && update_user_info($dbo,$t_user_info,$post,$user_id)) {
	admin_log($dbo,$t_admin_log,$sn = $a_langpackage->a_modify_user_info);//'修改用户信息');
	action_return(1,$a_langpackage->a_amend_suc,'m.php?app=member_view&id='.$user_id);
} else {
	action_return(0,$a_langpackage->a_amend_lose,'-1');
}
?>
<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require_once("../foundation/module_users.php");
require_once("../foundation/module_admin_logs.php");
require_once("../foundation/module_remind.php");
require_once("../foundation/module_account.php");

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
$t_user_point = $tablePreStr."user_point";
$t_user_account = $tablePreStr."user_account";
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
$post['user_notes'] = short_check(get_args('user_notes'));
/* 图片上传处理 */
$cupload = new upload();
$cupload->set_dir("../uploadfiles/member_ico/","{y}/{m}/{d}");
$setthumb = array(
	'width' => array($SYSINFO['width1'],$SYSINFO['width2']),
	'height' => array($SYSINFO['height1'],$SYSINFO['height2']),
	'name' => array('thumb','m')
);
$cupload->set_thumb($setthumb);
$file = $cupload->execute();
	if(count($file)) {
		$insert_array = array();
		foreach($file as $k=>$v) {
			if($v['flag']==1) {
				if(!empty($v['dir'])){
					$post2['user_ico'] = str_replace('../', '', $v['dir']).$v['name'];
				}
			}
		}		
}

$post2['email_check'] = intval(get_args('email_check'));
$post2['locked'] = intval(get_args('locked_status'));
$post2['rank_id'] = intval(get_args('rank_id'));
$post2['user_email'] = short_check(get_args('user_email'));
if(get_args('password')) {
	$post2['user_passwd'] = md5(get_args('password'));
}
$post2['user_integral'] = intval(get_args('user_integral'));
$post2['user_integral_surplus'] = intval(get_args('user_integral_surplus'));
$post2['user_money'] = intval(get_args('user_money'));
$user_id = intval(get_args('user_id'));
$amount_notes = short_check(get_args('amount_notes'));
$point_notes = short_check(get_args('point_notes'));
if(!$user_id) { trigger_error($a_langpackage->a_error);}

//查询$t_users表中的数据，与原数据对比，如果修改了，则发送站内消息给用户
$sql = "select * from `$t_users` where user_id=$user_id";
$rs = $dbo->getRow($sql);

if($rs){
	$nowtime = $ctime->long_time();
	if(intval(get_args('rank_id'))) {
		if($rs['rank_id']!=$post2['rank_id']){
			$array = array(
				'user_id' => $user_id,
				'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_mem_level,
				'remind_time' => $nowtime,
			);
			insert_remind_info($dbo,$t_remind_info,$array);
		}
	}
	if(get_args('password')) {
		if($rs['user_passwd']!=md5($post2['user_passwd'])){
			$array = array(
				'user_id' => $user_id,
				'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_mi_ti,
				'remind_time' => $nowtime,
			);
			insert_remind_info($dbo,$t_remind_info,$array);
		}
	}
        
        //修改用户积分时提醒备注
        if($post2['user_integral']){
            if($rs['user_integral'] != $post2['user_integral'] && empty($point_notes)){
                action_return(0,$a_langpackage->a_memeber_nonote_point,'-1');
            }
        }
        if($post2['user_integral_surplus']){
            if($post2['user_integral_surplus'] - $rs['user_integral_surplus'] > 0){
                $post2['user_integral'] += ($post2['user_integral_surplus'] - $rs['user_integral_surplus']);
                $point_notes  .= "\n增加可用积分[".$post2['user_integral_surplus']."]";
            }

        }
        //修改余额时提醒备注
        if($post2['user_money']){
            if($rs['user_money'] != $post2['user_money'] && empty($amount_notes)){
                action_return(0,$a_langpackage->a_memeber_nonote_amount,'-1');
            }
        }
        //修改用户余额时更新现金账户表
        if(get_args('user_money')) {
            if($rs['user_money'] > $post2['user_money']){
                $array = array(
                        'user_id' => $user_id,
                        'admin_user' => $_SESSION['admin_name'],
                        'amount' => -($rs['user_money'] - $post2['user_money']),
                        'add_time' => $nowtime,
                        'paid_time' => $nowtime,
                        'admin_note' => $amount_notes,
                        'user_note' => $post['user_notes'],
                        'process_type' => 2,
                        'payment' => '',
                        'is_paid' => 1,
                );
                insert_account_info($dbo,$t_user_account,$array);
            }
            if($rs['user_money'] < $post2['user_money']){
                $array = array(
                        'user_id' => $user_id,
                        'admin_user' => $_SESSION['admin_name'],
                        'amount' => -($rs['user_money'] - $post2['user_money']),
                        'add_time' => $nowtime,
                        'paid_time' => $nowtime,
                        'admin_note' => $amount_notes,
                        'user_note' => $post['user_notes'],
                        'process_type' => 0,
                        'payment' => '',
                        'is_paid' => 0,
                );
                insert_account_info($dbo,$t_user_account,$array);
            }
        }
        //修改用户总积分时更新积分表
        if(get_args('user_integral')) {
            if($rs['user_integral'] > $post2['user_integral']){
                $array = array(
                        'user_id' => $user_id,
                        'admin_user' => $_SESSION['admin_name'],
                        'point' => -($rs['user_integral'] - $post2['user_integral']),
                        'add_time' => $nowtime,
                        'admin_note' => $point_notes,
                        'process_type' => 2,
                );
                insert_account_info($dbo,$t_user_point,$array);
            }
            if($rs['user_integral'] < $post2['user_integral']){
                $array = array(
                        'user_id' => $user_id,
                        'admin_user' => $_SESSION['admin_name'],
                        'point' => -($rs['user_integral'] - $post2['user_integral']),
                        'add_time' => $nowtime,
                        'admin_note' => $point_notes,
                        'process_type' => 1,
                );
                insert_account_info($dbo,$t_user_point,$array);
            }
        }
}

if(update_user_info($dbo,$t_users,$post2,$user_id) && update_user_info($dbo,$t_user_info,$post,$user_id)) {
	admin_log($dbo,$t_admin_log,$sn = $a_langpackage->a_modify_user_info.":".$user_id);//'修改用户信息');
	action_return(1,$a_langpackage->a_amend_suc,'m.php?app=member_view&id='.$user_id);
} else {
	action_return(0,$a_langpackage->a_amend_lose,'-1');
}
?>
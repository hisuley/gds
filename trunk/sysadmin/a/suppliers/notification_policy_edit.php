<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require("../foundation/module_notification_policy.php");
require_once("../foundation/module_admin_logs.php");
require_once("../foundation/module_remind.php");
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
$nowtime = $ctime->long_time();

if(empty($post['policy_title'])) {
	action_return(0,$a_langpackage->a_class_null,'-1');
	exit;
}

$policy_id = intval(get_args('policy_id'));
if(!$policy_id) {trigger_error($a_langpackage->a_error);}

//数据表定义区
$t_notification_policy = $tablePreStr."notification_policy";
$t_admin_log = $tablePreStr."admin_log";
$t_remind_info = $tablePreStr."remind_info";
$t_shop_info = $tablePreStr."shop_info";
$t_shop_request = $tablePreStr."shop_request";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$count = check_policy_title($dbo,$t_notification_policy,$post['policy_title'],$policy_id);
if($count[0]) {
	action_return(0,$a_langpackage->a_notification_policy_repeat,'-1');
	exit;
}
if(update_policy_info($dbo,$t_notification_policy,$post,$policy_id)) {
        $sql = "select a.user_id from `$t_shop_info` a left join `$t_shop_request` b on a.user_id=b.user_id where b.status=1";
        $users = $dbo->getRs($sql);
        foreach($users as $val){
            if($val['user_id']){
                $policy_remind['user_id'] = $val['user_id'];
                $policy_remind['remind_info'] = $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_notification_policy_edit.": ".$post['policy_content'];
                $policy_remind['remind_time'] = $nowtime;
                insert_remind_info($dbo,$t_remind_info,$policy_remind);
            }
        }
	admin_log($dbo,$t_admin_log,$a_langpackage->a_notification_policy_edit."：$policy_id");
	action_return(1,$a_langpackage->a_amend_suc,'m.php?app=notification_policy_edit&id='.$policy_id);
} else {
	action_return(0,$a_langpackage->a_amend_lose,'-1');
}
?>
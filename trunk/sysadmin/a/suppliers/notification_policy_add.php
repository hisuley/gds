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
$right=check_rights("notification_policy_add");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}

/* post 数据处理 */
$post['policy_title'] = short_check(get_args('policy_title'));
$post['policy_content'] = short_check(get_args('policy_content'));
$post['sort_order'] = intval(get_args('sort_order'));
$post['shop_cat_id'] = intval(get_args('shop_cat_id'));
$post['user_id'] = intval(get_args('user_id'));
if(empty($post['policy_title'])) {
	action_return(0,$a_langpackage->a_news_title_notnone,'-1');
	exit;
}
$nowtime = $ctime->long_time();
//数据表定义区
$t_notification_policy = $tablePreStr."notification_policy";
$t_admin_log = $tablePreStr."admin_log";
$t_remind_info = $tablePreStr."remind_info";
$t_shop_info = $tablePreStr."shop_info";
$t_shop_request = $tablePreStr."shop_request";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$count = check_policy_title($dbo,$t_notification_policy,$post['policy_title']);
if($count[0]) {
	action_return(0,$a_langpackage->a_notification_policy_repeat,'-1');
	exit;
}
$sql = "select a.user_id from `$t_shop_info` a left join `$t_shop_request` b on a.user_id=b.user_id where b.status=1";
if($post['user_id']){
    $sql .= " and a.user_id=". $post['user_id'];
}else{
    if($post['shop_cat_id'] && $post['shop_cat_id'] != -1){
        $sql .= " and a.shop_categories=". $post['shop_cat_id'];
    }
}
$users = $dbo->getRs($sql);
foreach($users as $val){
    if($val['user_id']){
        $policy_remind['user_id'] = $val['user_id'];
	$policy_remind['remind_info'] = $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_notification_policy_add.": ".$post['policy_content'];
	$policy_remind['remind_time'] = $nowtime;
        insert_remind_info($dbo,$t_remind_info,$policy_remind);
    }
}
$insert_id = insert_policy_info($dbo,$t_notification_policy,$post);

if($insert_id) {
        
	admin_log($dbo,$t_admin_log,$a_langpackage->a_notification_policy_add."：$insert_id");
	action_return(1,$a_langpackage->a_add_suc,'m.php?app=notification_policy_list');
} else {
	action_return(0,$a_langpackage->a_add_lose,'-1');
}
?>
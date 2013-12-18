<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_source.php");
require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("news_source_update");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');	
}

/* post 数据处理 */
$post['name'] = short_check(get_args('name'));
$source_id = intval(get_args('source_id'));

if(empty($source_id)) {
	action_return(0,$a_langpackage->a_title_null,'-1');
	exit;
}

//数据表定义区
$t_article_source = $tablePreStr."article_source";
$t_admin_log = $tablePreStr."admin_log";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

/* 检测来源名称唯一 */
$count = check_source_name($dbo,$t_article_source,$post['name']); 
if($count[0]) {
	action_return(0,$a_langpackage->a_news_source_repeat,'-1');
	exit;
}
if(update_source_info($dbo,$t_article_source,$post,$source_id)) {
	admin_log($dbo,$t_admin_log,$a_langpackage->a_news_source_edit."：$source_id");
	action_return(1,$a_langpackage->a_amend_suc);
} else {
	action_return(0,$a_langpackage->a_amend_lose,'-1');
}
?>
<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_source.php");
require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("news_source_del");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
/* get */
$source_id=get_args('source_id');
if($source_id){
	$id=implode(",", $source_id);
}else{
	$id = intval(get_args('id'));
}

if(!$id) {
	action_return(0,$a_langpackage->a_error,'-1');
}

//数据表定义区
$t_article_source = $tablePreStr."article_source";
$t_admin_log = $tablePreStr."admin_log";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

if(del_source_info($dbo, $t_article_source, $id)) {
	admin_log($dbo,$t_admin_log,$a_langpackage->a_news_source_del."：$id");
	action_return();
} else {
	action_return(0,$a_langpackage->a_del_lose,'-1');
}
?>
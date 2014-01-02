<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_admin_logs.php");

//语言包引入
$a_langpackage=new adminlp;
/* 数据处理 */
$id = intval(get_args('id'));
$audit = intval(get_args('audit'));
$draft = intval(get_args('draft'));
$audit_note = short_check(get_args('audit_note'));
if(!$id) {
	exit();
}

//数据表定义区
$t_article=$tablePreStr."article";
$t_admin_log = $tablePreStr."admin_log";
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

if($audit === 1){
    $sql = "update `$t_article`  set is_audit='$audit',is_draft=0 where article_id='$id'";
    $dbo->exeUpdate($sql);
    admin_log($dbo,$t_admin_log,$a_langpackage->a_news_first_audit_true."：$id");
    action_return(1,$a_langpackage->a_news_audit_true,'m.php?app=news_first_list');
}elseif($audit === 4){
    $sql = "update `$t_article`  set is_audit='$audit',is_draft=0 where article_id='$id'";
    $dbo->exeUpdate($sql);
    admin_log($dbo,$t_admin_log,$a_langpackage->a_news_recheck_audit_true."：$id");
    action_return(1,$a_langpackage->a_news_audit_true,'m.php?app=news_recheck_list');
}elseif ($audit === 2) {
    $sql = "update `$t_article`  set is_audit='$audit',audit_note='$audit_note',is_draft=0 where article_id='$id'";
    $dbo->exeUpdate($sql);
    admin_log($dbo,$t_admin_log,$a_langpackage->a_news_first_audit_false."：$id");
    action_return(1,$a_langpackage->a_news_audit_false,'m.php?app=news_first_list');
}elseif ($audit === 3){
    $sql = "update `$t_article`  set is_audit='$audit',audit_note='$audit_note',is_draft=0 where article_id='$id'";
    $dbo->exeUpdate($sql);
    admin_log($dbo,$t_admin_log,$a_langpackage->a_news_recheck_audit_false."：$id");
    action_return(1,$a_langpackage->a_news_audit_false,'m.php?app=news_recheck_list');
}elseif ($audit === 5 && $draft === 1){
    $sql = "update `$t_article`  set is_audit='$audit',is_draft='$draft' where article_id='$id'";
    $dbo->exeUpdate($sql);
    admin_log($dbo,$t_admin_log,$a_langpackage->a_news_retraction_log."：$id");
    action_return(1,$a_langpackage->a_news_retraction_suss,'m.php?app=news_list');
}
?>

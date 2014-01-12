<?php
if(!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}
require("../foundation/module_promotions.php");
require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("promotions_update");
if(!$right){
    action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
/* post 数据处理 */
//$post['id'] = short_check(get_args('id'));
$post['is_lock'] = 0;

$id = short_check(get_args('id'));
if(empty($id)) {
    action_return(0,'没有提供id','-1');
    exit;
}


if(!$id) {trigger_error($a_langpackage->a_error);}

//数据表定义区
$t_goods_promotions = $tablePreStr."goods_promotions";
$t_admin_log = $tablePreStr."admin_log";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

if(update_promotions_info($dbo,$t_goods_promotions,$post,$id)) {
    admin_log($dbo,$t_admin_log,$a_langpackage->a_goods_promotions_edit."：$id");
    action_return(1,'审核成功！','m.php?app=goods_promotions_list');
} else {
    action_return(0,'审核失败','-1');
}
?>
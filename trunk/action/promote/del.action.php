<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

//引入模块公共方法文件
require 'foundation/module_promote.php';

//语言包引入
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

//定义文件表
$t_promote = $tablePreStr."goods_promotions";

/* post 数据处理 */
$promote_id = intval(get_args('id'));

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

//判断sessionid和userid是不是同一个，如果不是则不需删除
$sql = "select shop_id from `$t_promote` where id='$promote_id'";
$rs = $dbo->getRow($sql);
if($rs['shop_id'] != get_sess_user_id()){
	action_return(1,$m_langpackage->m_not_del,'-1');
}


$suc=del_promote($dbo,$t_promote,$promote_id);

if($suc) {
	action_return(1,$m_langpackage->m_del_success,'-1');
} else {
	action_return(0,$m_langpackage->m_edit_fail,'-1');
}

exit;
?>
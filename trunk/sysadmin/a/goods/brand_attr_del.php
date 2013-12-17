<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_brand.php");
//权限管理
$right=check_rights("attr_del");
if(!$right){
	exit("-2");
}
/* get */
$id = intval(get_args('id'));

if(!$id) {
	exit("-1");
}

//数据表定义区
$t_brand_id = $tablePreStr."brand_attr";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

if(del_attr_info($dbo,$t_brand_id,$id)) {
	echo "1";
} else {
	echo "-1";
}
?>
<?php

//引入模块公共方法文件
require("foundation/module_order.php");
require("foundation/module_goods.php");
require("foundation/module_photo.php");

//语言包引入
$m_langpackage=new moduleslp;

//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

//定义文件表
$t_order_info = $tablePreStr."order_info";
$order_id = intval(get_args('order_id'));

$sql_order = "SELECT * FROM $t_order_info WHERE order_id = ".$order_id;
$result = $dbo->getRs($sql_order);
print_r($result);

?>

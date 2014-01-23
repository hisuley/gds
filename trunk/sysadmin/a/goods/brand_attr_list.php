<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

/* post 数据处理 */
$v = short_check(get_args('v'));

if(!$v) {
	exit("-1");
}

//数据表定义区
$t_brand_attr = $tablePreStr."brand_attr";;

//定义写操作
dbtarget('r',$dbServs);
$dbo=new dbex;

$sql_type = "select brand_attr_id,brand_id,attr_name,input_type,attr_values,sort_order, selectable, price from `$t_brand_attr` where attr_name='类型'";
$brand_type = $dbo->getRow($sql_type);

$sql_rank = "select brand_attr_id,brand_id,attr_name,input_type,attr_values,sort_order, selectable, price from `$t_brand_attr` where attr_name='级别'";
$brand_rank = $dbo->getRow($sql_rank);

$sql_area = "select brand_attr_id,brand_id,attr_name,input_type,attr_values,sort_order, selectable, price from `$t_brand_attr` where attr_name='区域'";
$brand_area = $dbo->getRow($sql_area);
if($v == '类型') {
	echo json_encode($brand_type);
} elseif($v == '级别') {
	echo json_encode($brand_rank);
}elseif($v == '区域') {
	echo json_encode($brand_area);
}else {
	exit("-1");
}
?>
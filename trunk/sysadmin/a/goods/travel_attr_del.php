<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

require_once("../foundation/module_attr.php");
//权限管理
$right=check_rights("travel_attr_del");
if(!$right){
	exit("-2");
}
/* get */
$index = intval(get_args('index'));
$cat_id = intval(get_args('cat_id'));
$attr_name = short_check(get_args('attr_values'));
if(!$index) {
	exit("-1");
}

//数据表定义区
$t_attribute = $tablePreStr."attribute";

//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;

$sql = "select attr_id,cat_id,attr_name,input_type,attr_values,sort_order, selectable, price from `$t_attribute` where cat_id=".$cat_id." and attr_name='$attr_name'";
$result = $dbo->getRs($sql);

foreach($result as $row){
    $tmp = explode("\n",$row['attr_values']);
    if(!empty($tmp)){
            unset($tmp[$index-1]);
    }
}
$post['attr_values'] = join("\n", $tmp);
if($tmp){
    $item_sql = get_update_item($post);
    $sql_travel = "update `$t_attribute` set $item_sql where cat_id=".$cat_id." and attr_name='$attr_name'";
    }else{
    $sql_travel = "delete from `$t_attribute` where cat_id=".$cat_id." and attr_name='$attr_name'";
}
if($dbo->exeUpdate($sql_travel)) {
        echo "1";
} else {
        echo "-1";
}
?>
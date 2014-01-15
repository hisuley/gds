<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

/* post 数据处理 */
$v = intval(get_args('v'));
$id = intval(get_args('id'));

if (!$v) {
    exit("-1");
}

require("foundation/module_attr.php");

//数据表定义区
$t_goods_attr = $tablePreStr . "goods_attr";

//定义写操作
dbtarget('r', $dbServs);
$dbo = new dbex;

$sql = "SELECT count(*) FROM $t_goods_attr WHERE attr_id =" . $id . " AND attr_values = " . $v;
$result = $dbo->getRow($sql);
$return = array('return_code' => 0, 'raw_info' => print_r($result, true));
if ($return) {
    $return['return_code'] = 1;
    echo json_encode($return);
} else {
    exit("-1");
}
?>
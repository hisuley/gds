<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}
require_once("../foundation/module_attr.php");
$a_langpackage = new adminlp;
//权限管理
$right = check_rights("travel_attr_edit");
if (!$right) {
    exit("-2");
}


/* post 数据处理 */

$post['attr_values'] = short_check(get_args('attr_name'));
$post['input_type'] = intval(get_args('input_type'));
$post['sort_order'] = intval(get_args('sort_order'));
$post['selectable'] = get_args('selectable');
$post['price'] = get_args('price');

$brand_id = intval(get_args('brand_id'));
$index = intval(get_args('index'));
$attr_name = short_check(get_args('attr_values'));
if (!$brand_id) {
    exit("-4");
}

if (empty($attr_name)) {
    exit("-1");
}

//数据表定义区
$t_brand_attr = $tablePreStr . "brand_attr";

//定义写操作
dbtarget('w', $dbServs);
$dbo = new dbex;

$sql = "select brand_attr_id,brand_id,attr_name,input_type,attr_values,sort_order, selectable, price from `$t_brand_attr` where brand_id=" . $brand_id . " and attr_name='$attr_name'";
$result = $dbo->getRs($sql);

foreach ($result as $row) {
    $tmp = explode("\n", $row['attr_values']);
    if (!empty($tmp)) {
        if ($index > 0) {
            $tmp[$index - 1] = $post['attr_values'];
        } else {
            array_push($tmp, $post['attr_values']);
        }

    }
}

if (count($tmp) == count(array_unique($tmp))) {
    $post['attr_values'] = join("\n", $tmp);
    $item_sql = get_update_item($post);
    $sql_travel = "update `$t_brand_attr` set $item_sql where brand_id=" . $brand_id . " and attr_name='$attr_name'";
    if ($dbo->exeUpdate($sql_travel)) {
        echo "1";
    } else {
        echo "-1";
    }
} else {
    echo "-3";
}
?>
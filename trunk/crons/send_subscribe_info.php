<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

require_once('foundation/module_category.php');

//数据表定义区
$t_user_rss = $tablePreStr . "user_rss";
$t_goods = $tablePreStr . "goods";
$t_goods_category = $tablePreStr . "category.php";

//定义操作
dbtarget('r', $dbServs);
$dbo = new dbex;


$allSubscribers_sql = "SELECT * FROM $t_user_rss WHERE is_enabled = 1 AND cat_id IS NOT NULL";
$allSubscribers = $dbo->getRs($allSubscribers_sql);

$allCats =
$allNewGoods = "SELECT goods FROM $"

dbtarget('w', $dbServs);
$dbo = new dbex;


function getSubCatId(&$dbo, $table, $cat_id)
{
    $sql = "SELECT * FROM $table WHERE parent_id = " . $cat_id;
    $result = $dbo->getRs($sql);
    $idList = array();
    foreach ($result as $v) {
        if (!in_array($v['cat_id'], $idList)) {
            array_push($idList, $v['cat_id']);
        }
        $subResult = getSubCatId($dbo, $table, $v['cat_id']);
        if (!empty($subResult)) {
            $idList = array_merge($idList, $subResult);
        }
    }
    return $idList;
}
?>
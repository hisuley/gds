<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;

require("foundation/asession.php");
require("configuration.php");
require("includes.php");
require_once("foundation/fstring.php");
require("foundation/module_brand.php");

/* 用户信息处理 */
//require 'foundation/alogin_cookie.php';
if (get_sess_user_id()) {
    $USER['login'] = 1;
    $USER['user_name'] = get_sess_user_name();
    $USER['user_id'] = get_sess_user_id();
    $USER['user_email'] = get_sess_user_email();
    $USER['shop_id'] = get_sess_shop_id();
} else {
    $USER['login'] = 0;
    $USER['user_name'] = '';
    $USER['user_id'] = '';
    $USER['user_email'] = '';
    $USER['shop_id'] = '';
}
$type = short_check(get_args("type"));
$rank = short_check(get_args("rank"));
$area = short_check(get_args("area"));
//引入语言包
$i_langpackage = new indexlp;

$header['title'] = $i_langpackage->i_index . " - " . $SYSINFO['sys_title'];
$header['keywords'] = $SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];

/* 定义文件表 */

$t_brand = $tablePreStr . "brand";
$t_brand_attr = $tablePreStr . "brand_attr";

/* 数据库操作 */
dbtarget('r', $dbServs);
$dbo = new dbex();

$page = 12;
$sql = "select * from `$t_brand` where is_show=1 and brand_logo!=''";

if ($type) {
    $sql .= " and brand_type like '%$type%'";
}
if ($rank) {
    $sql .= " and brand_rank like '%$rank%'";
}
if ($area) {
    $sql .= " and brand_area like '%$area%'";
}
$sql .= " ORDER BY brand_id DESC";
$result = $dbo->fetch_page($sql, $page);
//$result = get_brand_list($dbo,$t_brand,'',12);

$url_this = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$sql_type = "select brand_attr_id,brand_id,attr_name,input_type,attr_values,sort_order, selectable, price from `$t_brand_attr` where attr_name='类型'";
$brand_type = $dbo->getRs($sql_type);
foreach ($brand_type as $key => $value) {
    $values_after = str_replace(array("\r\n", "\r", "\n"), ',', $value['attr_values']);
    $type_info[$key]['attr_values'] = explode(',', $values_after);

    foreach ($type_info[$key]['attr_values'] as $k => $va) {
        $va = trim($va);
        $sql = "select count(*) AS attr_count from $t_brand where brand_type='$va' and is_show=1";
        $goods_attr_info = $dbo->getRow($sql);
        $type_info[$key]['values_count'][$k] = $goods_attr_info["attr_count"];
    }
}

$sql_rank = "select brand_attr_id,brand_id,attr_name,input_type,attr_values,sort_order, selectable, price from `$t_brand_attr` where attr_name='级别'";
$brand_rank = $dbo->getRs($sql_rank);
foreach ($brand_rank as $key => $value) {
    $values_after = str_replace(array("\r\n", "\r", "\n"), ',', $value['attr_values']);
    $rank_info[$key]['attr_values'] = explode(',', $values_after);

    foreach ($rank_info[$key]['attr_values'] as $k => $va) {
        $va = trim($va);
        $sql = "select count(*) AS attr_count from $t_brand where brand_rank='$va' and is_show=1";
        $goods_attr_info = $dbo->getRow($sql);
        $rank_info[$key]['values_count'][$k] = $goods_attr_info["attr_count"];
    }
}

$sql_area = "select brand_attr_id,brand_id,attr_name,input_type,attr_values,sort_order, selectable, price from `$t_brand_attr` where attr_name='区域'";
$brand_area = $dbo->getRs($sql_area);
foreach ($brand_area as $key => $value) {
    $values_after = str_replace(array("\r\n", "\r", "\n"), ',', $value['attr_values']);
    $area_info[$key]['attr_values'] = explode(',', $values_after);

    foreach ($area_info[$key]['attr_values'] as $k => $va) {
        $va = trim($va);
        $sql = "select count(*) AS attr_count from $t_brand where brand_area='$va' and is_show=1";
        $goods_attr_info = $dbo->getRow($sql);
        $area_info[$key]['values_count'][$k] = $goods_attr_info["attr_count"];
    }
}
?>
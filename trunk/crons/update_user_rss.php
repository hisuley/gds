<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

require("foundation/module_rss.php");
require("foundation/module_remind.php");

//数据表定义区
$t_user_rss = $tablePreStr . "user_rss";
$t_category = $tablePreStr . "category";
$t_goods = $tablePreStr . "goods";
$t_remind_info = $tablePreStr . "remind_info";

function join_child_cat($sub_category)
{
    foreach ($sub_category as $v) {
        if ($v['cat_id']) {
            $sub_catid .= $v['cat_id'] . ',';
        }
    }

    return $sub_catid;
}

//递归查询子分类ID
function get_sub_category_recursion(&$dbo, $table, $cat_id)
{
    $sql = "select cat_id from `$table` where parent_id in($cat_id)";
    $result = $dbo->getRsassoc($sql);
    foreach ($result as $val) {
        if ($val['cat_id']) {
            $sub_cat = get_sub_category_recursion($dbo, $table, $val['cat_id']);
        }
        $result = array_merge($result, $sub_cat);
    }

    return $result;
}

//定义操作
dbtarget('r', $dbServs);
$dbo = new dbex;
$nowtime = $ctime->long_time();
$sql = "select * from `$t_user_rss` where is_enabled = 1";
$result = $dbo->getRs($sql);
foreach ($result as $key => $val) {
    if ($val['cat_id']) {
        $sub_category = get_sub_category_recursion($dbo, $t_category, $val['cat_id']);
    }

    $sub_cat = join_child_cat($sub_category);

    $cat_id = trim($val['cat_id'] . ',' . $sub_cat, ',');

    //查询商品
    $sql = "select goods_id,goods_name,goods_intro,add_time from `$t_goods` where is_on_sale=1 and cat_id in($cat_id) order by add_time desc";
    $result = $dbo->getRs($sql);

    $rss = new RSS();
    foreach ($result as $info) {
        $rss->AddItem($info['goods_name'], $baseUrl . '/goods.php?id=' . $info['goods_id'], htmlspecialchars($info['goods_intro']), $info['add_time']);
    }

    $title = $i_langpackage->i_index . " - " . $SYSINFO['sys_title'];
    $description = $SYSINFO['sys_description'];
    $rss->RSS($title, $baseUrl, $description);
    $rss->BuildRSS();
    $rss->SaveToFile('crons/' . $val['user_id'] . '_rss.xml');

    if ($val['user_id']) {
        $post['user_id'] = $val['user_id'];
        $post['remind_info'] = $a_langpackage->a_zai . $nowtime . '，<a href=' . $baseUrl . '/crons/' . $val['user_id'] . '_rss.xml>您订阅的商品RSS，请点击</a>';
        $post['remind_time'] = $nowtime;
        insert_remind_info($dbo, $t_remind_info, $post);
    }
}


?>
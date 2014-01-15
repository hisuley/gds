<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

//引入公共方法

function insert_goods_info(&$dbo, $table, $insert_items)
{
    $item_sql = get_insert_item($insert_items);
    $sql = "insert `$table` $item_sql";
    if ($dbo->exeUpdate($sql)) {
        return mysql_insert_id();
    } else {
        return false;
    }
}

function update_goods_info(&$dbo, $table, $update_items, $goods_id, $shop_id)
{
    $item_sql = get_update_item($update_items);
    $sql = "update `$table` set $item_sql where goods_id='$goods_id' and shop_id='$shop_id'";
    return $dbo->exeUpdate($sql);
}

function get_goods_info(&$dbo, $table, $select_items, $goods_id, $shop_id = 0)
{
    $item_sql = get_select_item($select_items);
    if ($shop_id) {
        $sql = "select $item_sql from `$table` where goods_id='$goods_id' and shop_id='$shop_id'";
    } else {
        $sql = "select $item_sql from `$table` where goods_id='$goods_id'";
    }

    return $dbo->getRow($sql);
}

function get_goods_num(&$dbo, $table, $shop_id = 0)
{
    if ($shop_id) {
        $sql = "select count(*) from `$table` where shop_id='$shop_id'";
    } else {
        $sql = "select count(*) from `$table`";
    }
    $count = $dbo->getRow($sql);
    return $count[0];
}

function get_goods_openflg(&$dbo, $table, $ship_id)
{
    $sql = "select open_flg from `$table` where shop_id=$ship_id";
    $count = $dbo->getRow($sql);
    return $count[0];
}

function get_goods_isname_num(&$dbo, $table, $shop_id = 0, $isname)
{
//	if($shop_id) {
    $sql = "select count(*) from `$table` where shop_id='$shop_id' and is_" . $isname . "=1";
//		echo $sql;
//	} else {
//		$sql = "select count(*) from `$table`";
//	}
    $count = $dbo->getRow($sql);
    return $count[0];
}

function delete_goods(&$dbo, $table, $goods_id, $shop_id)
{
    $sql = "delete from `$table` where goods_id='$goods_id' and shop_id='$shop_id'";
    return $dbo->exeUpdate($sql);
}

function get_goods_attr(&$dbo, $table, $goods_id)
{
    $sql = "select * from `$table` where goods_id='$goods_id'";
    return $dbo->getRs($sql);
}

function get_isname_num(&$dbo, $table, $shop_id)
{
    $sql = "select goods_id,is_best,is_new,is_hot,is_promote from `$table` where shop_id='$shop_id'";
    return $dbo->getRs($sql);
}

function update_goods_attr(&$dbo, $table, $array, $goods_id)
{
    if (empty($array)) {
        return false;
    }
    $i = 0;
    foreach ($array as $key => $value) {
        if (is_array($value['attr_values'])) {
            $value['attr_values'] = implode("\n", $value['attr_values']);
            $value['price'] = implode("\n", $value['price']);
        }
        $sql = "update `$table` set attr_values='" . $value['attr_values'] . "',price='" . $value['price'] . "' where goods_id='$goods_id' and attr_id='$key'";
        //echo $sql;exit;
        if ($dbo->exeUpdate($sql)) {
            $i++;
        }
    }
    return $i;
}

function insert_goods_attr(&$dbo, $table, $array, $goods_id)
{
    if (empty($array)) {
        return false;
    }
    $dot = '';
    $sql = "insert into `$table` (goods_id,attr_id,attr_values,price) values";

    foreach ($array['price'] as $key => $val) {
        if (is_array($array['price'][$key])) {
            foreach ($array['price'][$key] as $k => $v) {
                $array['price'][$key][$k] = intval($v);
                for ($i = count($array['attr_values'][$key]), $j = count($array['price'][$key]); $i <= $j; $i++) {
                    unset($array['price'][$key][$i]);
                }
            }
        } else {
            $array['price'][$key] = intval($val);
        }
        if (!empty($array['attr_values'][$key])) {
            $tarray[$key]['attr_values'] = $array['attr_values'][$key];
            $tarray[$key]['price'] = $array['price'][$key];

            unset($array['attr_values'][$key]);
            unset($array['price'][$key]);
        }
    }
    foreach ($array['attr_values'] as $key => $val) {
        if (!is_array($array['price'][$key]) && !empty($array['attr_values'][$key])) {
            $tarray[$key]['attr_values'] = $array['attr_values'][$key];
            $tarray[$key]['price'] = $array['price'][$key];
        }
    }
    foreach ($tarray as $key => $value) {
        if ($value) {
            if (is_array($value['attr_values'])) {
                $attr_values = implode("\n", $value['attr_values']);
                $price = implode("\n", $value['price']);
                $sql .= $dot . " ('$goods_id','$key','$attr_values','$price')";
                $dot = ',';
            } else {
                $sql .= $dot . " ('$goods_id','$key','" . $value['attr_values'] . "','" . $value['price'] . "')";
                $dot = ',';
            }
        }
    }
    return $dbo->exeUpdate($sql);
}

function delete_goods_attr(&$dbo, $table, $array, $goods_id)
{
    if (empty($array)) {
        return false;
    }
    $attr_id = $dot = '';
    foreach ($array as $k => $v) {
        $attr_id .= $dot . $k;
        $dot = ',';
    }
    $sql = "delete from `$table` where attr_id in ($attr_id) and goods_id='$goods_id'";
    return $dbo->exeUpdate($sql);
}

function get_transport_template_list(&$dbo, $table, $shop_id = '')
{
    if (empty($shop_id)) {
        $shop_id = get_sess_shop_id();
    }

    $sql = "SELECT * FROM `$table` WHERE shop_id = '$shop_id' ORDER BY id DESC";
    return $dbo->getRs($sql);
}

function  update_default_transportprice(&$dbo, $goods_table, $transport_table, $goods_id)
{
    $sql = "SELECT transport_template_id,is_transport_template,transport_price FROM `$goods_table` WHERE goods_id='$goods_id'";
    $goods_info = $dbo->getRow($sql);
    $default_price = 0;
    if ($goods_info['is_transport_template']) {
        $sql = "SELECT content FROM $transport_table WHERE id='{$goods_info['transport_template_id']}'";
        $transport_info = $dbo->getRow($sql);
        $transport_content = $transport_info['content'];
        $transport_arr = unserialize($transport_content);
        if (isset($transport_arr['ems'])) {
            $default_price = $transport_arr['ems']['frist'];
        }
        if (isset($transport_arr['pst'])) {
            $default_price = $transport_arr['pst']['frist'];
        }
        if (isset($transport_arr['ex'])) {
            $default_price = $transport_arr['ex']['frist'];
        }
    } else {
        $default_price = $goods_info['transport_price'];
    }
    $sql = "UPDATE $goods_table SET transport_template_price='$default_price' WHERE goods_id='$goods_id'";
    return $dbo->exeUpdate($sql);
}

function get_shop_payment(&$dbo, $t_shop_payment, $t_payment, $shop_id)
{
    $sql = "SELECT b.pay_id,b.pay_code FROM $t_shop_payment AS a, $t_payment AS b WHERE a.pay_id=b.pay_id AND a.shop_id=$shop_id AND a.enabled=1";
    return $dbo->getRs($sql);
}

function export_csv_info(&$dbo, $table, $shop_id)
{
    $sql = "SELECT goods_id,goods_name FROM $table WHERE shop_id='$shop_id' ORDER BY goods_id DESC";
    return $dbo->getRs($sql);
}

function  get_goods_transport_price(&$dbo, $table, $area_id, $template_id, $arr_list, $goods_num = 1)
{
    $sql = "SELECT content FROM $table WHERE id='$template_id'";
    $arr = $dbo->getRow($sql);
    $content = unserialize($arr['content']);
    foreach ($arr_list as $v) {
        $transport_price[$v['tranid']] = 0;
    }
    if ($goods_num > 1) {
        foreach ($arr_list as $val) {
            if ($content[$val['tranid']]['frist'] != 0) {
                if (empty($content[$val['tranid']][$area_id]['frist'])) {
                    $transport_price[$val['tranid']] = $content[$val['tranid']]['frist'] + $content[$val['tranid']]['second'] * ($goods_num - 1);
                } else {
                    $transport_price[$val['tranid']] = $content[$val['tranid']][$area_id]['frist'] + $content[$val['tranid']][$area_id]['second'] * ($goods_num - 1);
                }
            }
        }
    } else {
        foreach ($arr_list as $val) {
            if ($content[$val['tranid']]['frist'] != 0) {
                if (empty($content[$val['tranid']][$area_id]['frist'])) {
                    $transport_price[$val['tranid']] = $content[$val['tranid']]['frist'];
                } else {
                    $transport_price[$val['tranid']] = $content[$val['tranid']][$area_id]['frist'];
                }
            }
        }
    }
    return $transport_price;
}

/* 推荐商品 */
function get_hot_goods(&$dbo, $table, $limit)
{
    $sql = "SELECT * FROM $table WHERE is_on_sale=1 AND is_hot=1 and lock_flg=0 order by pv desc limit $limit";
    return $dbo->getRs($sql);
}

/* 推荐商品 */
function get_hot_goods_by_cat(&$dbo, $table, $cat_id, $limit)
{
    $sql = "SELECT * FROM $table WHERE is_on_sale=1 AND is_admin_promote=1 and lock_flg=0 AND cat_id = $cat_id AND is_set_image = 1 order by pv desc limit $limit";
    return $dbo->getRs($sql);
}

/* 浏览记录 */
function get_good_shistory(&$dbo, $getcookie, $table)
{
    arsort($getcookie);
    $getcookie = array_keys($getcookie);
    $gethisgoodsid = implode(",", array_slice($getcookie, 0, 4));
    $sql = "select is_set_image,goods_id,goods_name,goods_thumb,goods_price from $table where goods_id in ($gethisgoodsid)";
    return $dbo->getRs($sql);
}

/* 查看该商品的网店是否为锁定 */
function get_shop_lock_flag(&$dbo, $t_goods, $t_shop_info, $good_id)
{
    $sql = "select b.lock_flg from $t_goods as a,$t_shop_info as b where a.shop_id=b.shop_id and a.goods_id=$good_id";
    $result = $dbo->getRow($sql);
    if (isset($result))
        return $result[0];
    else
        return -1;
}

?>
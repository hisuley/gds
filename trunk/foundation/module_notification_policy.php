<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

function insert_policy_info(&$dbo, $table, $insert_items)
{
    $item_sql = get_insert_item($insert_items);
    $sql = "insert `$table` $item_sql";
    $suc = $dbo->exeUpdate($sql);
    if ($suc) {
        return mysql_insert_id();
    } else {
        return false;
    }
}

function update_policy_info($dbo, $table, $update_items, $policy_id)
{
    $item_sql = get_update_item($update_items);
    $sql = "update `$table` set $item_sql where policy_id='$policy_id'";
    return $dbo->exeUpdate($sql);
}

function get_policy_info_item(&$dbo, $select_items, $table)
{
    $item_sql = get_select_item($select_items);
    $sql = "select $item_sql from `$table`";
    return $dbo->getRs($sql);
}

function get_policy_row(&$dbo, $table, $policy_id)
{
    $sql = "select * from `$table` where policy_id = $policy_id";
    return $dbo->getRow($sql);
}

function get_policy_info(&$dbo, $table)
{
    return get_policy_info_item($dbo, '*', $table);
}

function check_policy_title(&$dbo, $table, $policy_title, $policy_id = 0)
{
    $sql = "SELECT COUNT(*) FROM `$table` WHERE policy_title ='$policy_title'";
    if ($policy_id) {
        $sql .= " and policy_id <> $policy_id";
    }
    return $dbo->getRow($sql);
}

function getnbsp($i)
{
    $str = '';
    if ($i) {
        for ($j = 0; $j < $i; $j++) {
            $str .= "　";
        }
    }
    return $str;
}

function get_dg_category($array, $parentid = array(-1, 0), $level = 0, $add = 2)
{
    $str_pad = getnbsp($level);
    $newarray = array();
    $temp = array();
    foreach ($array as $v) {
        if (in_array($v['parent_id'], $parentid)) {
            $newarray[] = array(
                'cat_id' => $v['cat_id'],
                'cat_name' => $v['cat_name'],
                'parent_id' => $v['parent_id'],
                'sort_order' => $v['sort_order'],
                'str_pad' => $str_pad
            );
            $temp = get_dg_category($array, array($v['cat_id']), ($level + $add));
            if ($temp) {
                $newarray = array_merge($newarray, $temp);
            }
        }
    }
    return $newarray;
}

function get_shop_cat_list(&$dbo, $table)
{
    $sql = "select * from `$table`";
    $result = $dbo->getRs($sql);
    $array = array();
    foreach ($result as $value) {
        $array[$value['cat_id']] = $value;
    }
    return $array;
}

?>
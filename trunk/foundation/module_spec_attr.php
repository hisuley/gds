<?php
if(!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

require_once('module_category.php');

function get_spec_attr_info(&$dbo, $table_attr,$table_cat, $attr_name, $cat_id){
    $parent_id = get_sub_under($dbo, $table_cat, $cat_id);
    $sql = "select attr_id,cat_id,attr_name,input_type,attr_values,sort_order, selectable, price from `$table_attr` where $attr_name = '".$attr_name."' AND cat_id IN(".implode(',', $parent_id).")";
    $result = $dbo->getRs($sql);
    return $result;
}


?>
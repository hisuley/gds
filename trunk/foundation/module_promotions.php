<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

function insert_promotions_info(&$dbo,$table,$insert_items){
	$item_sql = get_insert_item($insert_items);
	$sql = "insert `$table` $item_sql";
	$suc=$dbo->exeUpdate($sql);
	if($suc){
		return mysql_insert_id();
	}else{
		return false;
	}
}
function update_promotions_info($dbo,$table,$update_items,$id) {
	$item_sql = get_update_item($update_items);
	$sql = "update `$table` set $item_sql where id='$id'";
	return $dbo->exeUpdate($sql);
}

function get_promotions_info_item(&$dbo,$select_items,$table)
{
	$item_sql = get_select_item($select_items);
	$sql = "select $item_sql from `$table`";
	return $dbo->getRs($sql);
}

function get_promotions_row(&$dbo,$table,$id)
{
	$sql = "select * from `$table` where id = $id";
	return $dbo->getRow($sql);
}

function get_promotions_info(&$dbo,$table)
{
	return get_promotions_info_item($dbo,'*',$table);
}
?>
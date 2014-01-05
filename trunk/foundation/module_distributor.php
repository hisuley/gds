<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

function insert_distributor_info(&$dbo,$table,$insert_items){
	$item_sql = get_insert_item($insert_items);
	$sql = "insert `$table` $item_sql";
	$suc=$dbo->exeUpdate($sql);
	if($suc){
		return mysql_insert_id();
	}else{
		return false;
	}
}
function update_distributor_info($dbo,$table,$update_items,$distributor_id) {
	$item_sql = get_update_item($update_items);
	$sql = "update `$table` set $item_sql where distributor_id='$distributor_id'";
	return $dbo->exeUpdate($sql);
}

function get_distributor_info_item(&$dbo,$select_items,$table)
{
	$item_sql = get_select_item($select_items);
	$sql = "select $item_sql from `$table`";
	return $dbo->getRs($sql);
}

function get_distributor_row(&$dbo,$table,$distributor_id)
{
	$sql = "select * from `$table` where distributor_id = $distributor_id";
	return $dbo->getRow($sql);
}

function get_distributor_info(&$dbo,$table)
{
	return get_distributor_info_item($dbo,'*',$table);
}

function check_distributor_name(&$dbo,$table,$distributor_name,$distributor_id=0){
    $sql = "SELECT COUNT(*) FROM `$table` WHERE distributor_name ='$distributor_name'";
    if($distributor_id){
        $sql .= " and distributor_id <> $distributor_id";
    }
    return $dbo->getRow($sql);
}
?>
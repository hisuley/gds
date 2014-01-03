<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

function insert_policy_info(&$dbo,$table,$insert_items){
	$item_sql = get_insert_item($insert_items);
	$sql = "insert `$table` $item_sql";
	$suc=$dbo->exeUpdate($sql);
	if($suc){
		return mysql_insert_id();
	}else{
		return false;
	}
}
function update_policy_info($dbo,$table,$update_items,$policy_id) {
	$item_sql = get_update_item($update_items);
	$sql = "update `$table` set $item_sql where policy_id='$policy_id'";
	return $dbo->exeUpdate($sql);
}

function get_policy_info_item(&$dbo,$select_items,$table)
{
	$item_sql = get_select_item($select_items);
	$sql = "select $item_sql from `$table`";
	return $dbo->getRs($sql);
}

function get_policy_row(&$dbo,$table,$policy_id)
{
	$sql = "select * from `$table` where policy_id = $policy_id";
	return $dbo->getRow($sql);
}

function get_policy_info(&$dbo,$table)
{
	return get_policy_info_item($dbo,'*',$table);
}

function check_policy_title(&$dbo,$table,$policy_title,$policy_id=0){
    $sql = "SELECT COUNT(*) FROM `$table` WHERE policy_title ='$policy_title'";
    if($policy_id){
        $sql .= " and policy_id <> $policy_id";
    }
    return $dbo->getRow($sql);
}
?>
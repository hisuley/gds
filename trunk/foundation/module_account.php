<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

function update_account(&$dbo,$table,$update_items,$id) {
	$item_sql = get_update_item($update_items);
	$sql = "update `$table` set $item_sql where user_id='$id'";
	return $dbo->exeUpdate($sql);
}

function update_account_sql(&$dbo,$sql) {
	return $dbo->exeUpdate($sql);
}


function get_account_user(&$dbo,$table,$user_id,$id) {
	$sql = "select * from `$table` where user_id=$user_id and id=$id";
	return $dbo->getRow($sql);
}

function insert_account_info(&$dbo,$table,$insert_items) {
	$item_sql = get_insert_item($insert_items);
	$sql = "INSERT INTO $table $item_sql";
	return $dbo->exeUpdate($sql);
}
?>
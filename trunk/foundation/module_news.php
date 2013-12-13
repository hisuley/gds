<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

function get_news_cat_list(&$dbo,$table) {
	$sql = "select * from `$table`";
	$result = $dbo->getRs($sql);
	$array = array();
	foreach($result as $value) {
		$array[$value['cat_id']] = $value;
	}
	return $array;
}

function get_news_list(&$dbo,$table,$cat_id=0) {
	$sql = "select * from `$table`";
	if($cat_id) {
		$sql .= " where cat_id='$cat_id' ";
	}
	$sql .= "order by article_id asc";
	$result = $dbo->getRs($sql);
	$array = array();
	foreach($result as $value) {
		$array[$value['article_id']] = $value;
	}
	return $array;
}

function insert_news_info(&$dbo,$table,$insert_items) {
	$item_sql = get_insert_item($insert_items);
	$sql = "insert into `$table` $item_sql ";
	$dbo->exeUpdate($sql);
	return mysql_insert_id();
}

function del_news_info(&$dbo,$table,$article_id) {
	$sql = "delete from `$table` where article_id='$article_id'";
	return $dbo->exeUpdate($sql);
}

function get_news_info(&$dbo,$table,$article_id) {
	$sql = "select * from `$table` where article_id='$article_id'";
	return $dbo->getRow($sql);
}

function update_news_info(&$dbo,$table,$update_items,$article_id) {
	$item_sql = get_update_item($update_items);
	$sql = "update `$table` set $item_sql where article_id='$article_id'";
	return $dbo->exeUpdate($sql);
}

function update_news_cat(&$dbo,$table,$update_items,$cat_id) {
	$item_sql = get_update_item($update_items);
	$sql = "update `$table` set $item_sql where cat_id='$cat_id'";
	return $dbo->exeUpdate($sql);
}

function getnbsp($i) {
	$str = '';
	if($i) {
		for($j=0; $j<$i; $j++) {
			$str .= "　";
		}
	}
	return $str;
}

function get_dg_category($array,$parentid=array(-1,0),$level=0,$add=2) {
	$str_pad = getnbsp($level);
	$newarray = array();
	$temp = array();
	foreach($array as $v) {
		if(in_array($v['parent_id'], $parentid)) {
			$newarray[] = array(
				'cat_id' => $v['cat_id'],
				'cat_name' => $v['cat_name'],
				'parent_id' => $v['parent_id'],
				'sort_order' => $v['sort_order'],
				'str_pad' => $str_pad
			);
			$temp = get_dg_category($array,array($v['cat_id']),($level+$add));
			if($temp) {
				$newarray = array_merge($newarray, $temp);
			}
		}
	}
	return $newarray;
}
?>

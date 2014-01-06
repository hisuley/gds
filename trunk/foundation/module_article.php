<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
/* 文章信息 */
function get_article_info(&$dbo,$table,$article_id){
	$sql = "SELECT * FROM `$table` WHERE is_show=1 and article_id='$article_id'";
	return $dbo->getRow($sql);
}
/* 文章信息翻页 */
function get_flip_info(&$dbo,$table,$article_id,$type){
	if ($type == 'up'){
		$sql="SELECT * FROM $table WHERE article_id < $article_id ORDER BY article_id DESC LIMIT 1";
		return $dbo->getRow($sql);
	}else if($type == 'down'){
		$sql="SELECT * FROM $table WHERE article_id > $article_id ORDER BY article_id ASC LIMIT 1";
		return $dbo->getRow($sql);
	}
}
/* header信息 */
function get_header_info($header_info){
	$header = array();
	if (is_array($header_info)){
		$header['title'] = $header_info['title'];
		$header['keywords'] = $header_info['title'];
		$header['description'] = sub_str(strip_tags($header_info['content']),100);
	}else {
		$header['title'] = $header_info;
		$header['keywords'] = $header_info;
		$header['description'] = sub_str(strip_tags($header_info),100);
	}
	return $header;
}
/* 文章信息列表 */
function get_article_list(&$dbo,$table,$cat_id,$page){
	$sql = "SELECT * FROM `$table` WHERE is_show=1 and is_audit = 4 and cat_id='$cat_id' order by add_time desc ";
	return $dbo->fetch_page($sql,$page);
}

function get_dg_category($array,$parentid=0,$level=0,$add=2) {
	$newarray = array();
	$temp = array();
	foreach($array as $v) {
		if($v['parent_id'] == $parentid) {
			$newarray[] = array(
				'cat_id' => $v['cat_id'],
				'cat_name' => $v['cat_name'],
				'parent_id' => $v['parent_id'],
				'sort_order' => $v['sort_order'],
                                'cat_icon'  => $v['cat_icon'],
                                'seo' => $v['seo']
			);
			$temp = get_dg_category($array,$v['cat_id'],($level+$add));
			if($temp) {
				$newarray = array_merge($newarray, $temp);
			}
		}
	}
	return $newarray;
}
?>
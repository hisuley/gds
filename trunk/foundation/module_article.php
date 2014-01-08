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
function page_url($id, $page){
        global $baseUrl;
        $urlrules_arr = array('article.php?id={$id}', 'article.php?id={$id}&page={$page}');
        if($page==1) {
                $urlrule = $urlrules_arr[0];
        } else {
                $urlrule = isset($urlrules_arr[1]) ? $urlrules_arr[1] : $urlrules_arr[0];
        }
        $urls = str_replace(array('{$year}','{$month}','{$day}','{$catid}','{$id}','{$page}'),array($year,$month,$day,$catid,$id,$page),$urlrule);
        $url_arr[0] = $url_arr[1] = $baseUrl.$urls;
        return $url_arr;
}
function content_pages($num, $curr_page,$pageurls) {
        $multipage = '';
        $page = 11;
        $offset = 4;
        $pages = $num;
        $from = $curr_page - $offset;
        $to = $curr_page + $offset;
        $more = 0;
        if($page >= $pages) {
                $from = 2;
                $to = $pages-1;
        } else {
                if($from <= 1) {
                        $to = $page-1;
                        $from = 2;
                } elseif($to >= $pages) {
                        $from = $pages-($page-2);
                        $to = $pages-1;
                }
                $more = 1;
        }
        if($curr_page>0) {
                $perpage = $curr_page == 1 ? 1 : $curr_page-1;
                $multipage .= '<a class="a1" href="'.$pageurls[$perpage][0].'">上一页</a>';
                if($curr_page==1) {
                        $multipage .= ' <span>1</span>';
                } elseif($curr_page>6 && $more) {
                        $multipage .= ' <a href="'.$pageurls[1][0].'">1</a>..';
                } else {
                        $multipage .= ' <a href="'.$pageurls[1][0].'">1</a>';
                }
        }
        for($i = $from; $i <= $to; $i++) {
                if($i != $curr_page) {
                        $multipage .= ' <a href="'.$pageurls[$i][0].'">'.$i.'</a>';
                } else {
                        $multipage .= ' <span>'.$i.'</span>';
                }
        }
        if($curr_page<$pages) {
                if($curr_page<$pages-5 && $more) {
                        $multipage .= ' ..<a href="'.$pageurls[$pages][0].'">'.$pages.'</a> <a class="a1" href="'.$pageurls[$curr_page+1][0].'">下一页</a>';
                } else {
                        $multipage .= ' <a href="'.$pageurls[$pages][0].'">'.$pages.'</a> <a class="a1" href="'.$pageurls[$curr_page+1][0].'">下一页</a>';
                }
        } elseif($curr_page==$pages) {
                $multipage .= ' <span>'.$pages.'</span> <a class="a1" href="'.$pageurls[$curr_page][0].'">下一页</a>';
        }
        return $multipage;
}
?>
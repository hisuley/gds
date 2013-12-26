<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_news.php");
require_once("../foundation/module_admin_logs.php");
//语言包引入
$a_langpackage=new adminlp;
$dbo=new dbex;

//权限管理
$right=check_rights("news_edit");
if(!$right){
	action_return(0,$a_langpackage->a_privilege_mess,'m.php?app=error');
}
$ctime = new time_class;

/* post 数据处理 */
$post['title'] = short_check(get_args('title'));
$post['cat_id'] = intval(get_args('cat_id'));
$post['is_link'] = intval(get_args('is_link'));
$post['is_show'] = intval(get_args('is_show'));
$post['link_url'] = short_check(get_args('link_url'));
$post['content'] = big_check(get_args('content'));

$post['short_order'] = intval(get_args('short_order'));
$post['is_blod'] = intval(get_args('is_blod'));
$post['tag_color'] = get_args('tag_color');

$post['admin_id'] = $_SESSION['admin_id'];
$post['add_time'] = $ctime->long_time();

$article_id = intval(get_args('article_id'));

if(!$article_id) {
	action_return(0,$a_langpackage->a_error,'-1');
	exit;
}

if(empty($post['title'])) {
	action_return(0,$a_langpackage->a_title_null,'-1');
	exit;
}
/* 图片上传处理 */
$cupload = new upload();
$cupload->set_dir("../uploadfiles/news/","{y}/{m}/{d}");
$setthumb = array(
	'width' => array($SYSINFO['width1'],$SYSINFO['width2']),
	'height' => array($SYSINFO['height1'],$SYSINFO['height2']),
	'name' => array('thumb','m')
);
$cupload->set_thumb($setthumb);
$file = $cupload->execute();
	if(count($file)) {
		$insert_array = array();
		foreach($file as $k=>$v) {
			if($v['flag']==1) {
				if(!empty($v['dir'])){
					$post['thumb'] = str_replace('../', '', $v['dir']).$v['name'];
				}
			}
		}		
}

//数据表定义区
$t_article = $tablePreStr."article";
$t_admin_log = $tablePreStr."admin_log";
$t_article_attr = $tablePreStr."article_attr";

//数据库操作
dbtarget('r',$dbServs);

$news_attr = get_goods_attr($dbo,$t_article_attr,$article_id);
$have_attr = array();
if($news_attr) {
	foreach($news_attr as $v) {
		$have_attr[$v['attr_id']] = $v['attr_values'];
	}
}

$post_attr = get_args('attr');
$filterAttr = filterAttr($have_attr,$post_attr);

$count = check_news_name($dbo,$t_article,$post['title']);
if($count[0]) {
	action_return(0,$a_langpackage->a_news_title_repeat,'-1');
	exit;
}
//定义写操作
dbtarget('w',$dbServs);

if(update_news_info($dbo,$t_article,$post,$article_id)) {
        if(isset($filterAttr['insert'])) {
		insert_news_attr($dbo,$t_article_attr,$filterAttr['insert'],$article_id);
	}

	if(isset($filterAttr['update'])) {
		update_news_attr($dbo,$t_article_attr,$filterAttr['update'],$article_id);
	}

	if(isset($filterAttr['delete'])) {
		delete_news_attr($dbo,$t_article_attr,$filterAttr['delete'],$article_id);
	}
	admin_log($dbo,$t_admin_log,$a_langpackage->a_modify_uml."：$article_id");
	action_return(1,$a_langpackage->a_amend_suc,'m.php?app=news_edit&id='.$article_id);
} else {
	action_return(0,$a_langpackage->a_amend_lose,'-1');
}

// 通过现有的属性与提交上来的属性进行比较
// 取得 需要更新，删除，添加的属性
function filterAttr($haveArray,$postArray) {
	$array = array();
	foreach($haveArray as $key=>$value) {
		if($postArray[$key]) {
			if($postArray[$key] != $value) {
				$array['update'][$key] = $postArray[$key];
			}
			unset($postArray[$key]);
		} else {
			$array['delete'][$key] = $value;
		}
	}
	$array['insert'] = $postArray;
	return $array;
}
?>
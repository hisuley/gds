<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
require_once("../foundation/module_news.php");
require_once("../foundation/module_admin_logs.php");
require("../foundation/module_gallery.php");
//语言包引入
$a_langpackage=new adminlp;

//权限管理
$right=check_rights("news_add");
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
$post['tag_color'] = get_args('tilte_color');

$post['admin_id'] = $_SESSION['admin_id'];
$post['add_time'] = $ctime->long_time();

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

/* 属性处理 */
$post_attr = get_args('attr');

//数据表定义区
$t_article = $tablePreStr."article";
$t_admin_log = $tablePreStr."admin_log";
$t_news_attr = $tablePreStr."article_attr";
//定义写操作
dbtarget('w',$dbServs);
$dbo=new dbex;
$article_id = insert_news_info($dbo,$t_article,$post);

if($article_id) {
	admin_log($dbo,$t_admin_log,$a_langpackage->a_add_uml."：$article_id");
        insert_news_attr($dbo,$t_news_attr,$post_attr,$article_id);
	action_return(1,$a_langpackage->a_add_suc);
} else {
	action_return(0,$a_langpackage->a_add_lose,'-1');
}
?>
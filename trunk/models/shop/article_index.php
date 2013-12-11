<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/module_shop.php");
require("foundation/module_users.php");
require("foundation/module_article.php");

//引入语言包
$s_langpackage=new shoplp;

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_shop_category = $tablePreStr."shop_category";
$t_goods = $tablePreStr."goods";
$t_article = $tablePreStr."article";
$t_article_cat = $tablePreStr."article_cat";

/*导航位置*/
$nav_selected=5;
$header['title'] = '资讯全览';
$header['keywords'] = '桂林,资讯';
$header['description'] = '桂林资讯网';
$baseUrl = '';

/*获取首页资讯列表*/

$latestNews_id = 11;
$scenic_id = 12;
$hotel_id = 13;
$line_id = 14;
$food_id = 15;
$traffic_id = 16;
$techan_id = 17;
$buy_id = 18;
$night_id = 19;
$holiday_id = 20;
$tutorial_id = 21;
$latestNews_result = get_article_list($dbo,$t_article,$latestNews_id,$SYSINFO['article_page']);
$scenic_result = get_article_list($dbo,$t_article,$scenic_id,$SYSINFO['article_page']);
$hotel_result = get_article_list($dbo,$t_article,$hotel_id,$SYSINFO['article_page']);
$line_result = get_article_list($dbo,$t_article,$line_id,$SYSINFO['article_page']);
$food_result = get_article_list($dbo,$t_article,$food_id,$SYSINFO['article_page']);
$traffic_result = get_article_list($dbo,$t_article,$traffic_id,$SYSINFO['article_page']);
$techan_result = get_article_list($dbo,$t_article,$techan_id,$SYSINFO['article_page']);
$buy_result = get_article_list($dbo,$t_article,$buy_id,$SYSINFO['article_page']);
$night_result = get_article_list($dbo,$t_article,$night_id,$SYSINFO['article_page']);
$holiday_result = get_article_list($dbo,$t_article,$holiday_id,$SYSINFO['article_page']);
$tutorial_result = get_article_list($dbo,$t_article,$tutorial_id,$SYSINFO['article_page']);



?>
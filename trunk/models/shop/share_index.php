<?php
if (!$IWEB_SHOP_IN) {
    trigger_error('Hacking attempt');
}

require("foundation/module_shop.php");
require("foundation/module_users.php");
require("foundation/module_article.php");

//引入语言包
$s_langpackage = new shoplp;

/* 数据库操作 */
dbtarget('r', $dbServs);
$dbo = new dbex();

/* 定义文件表 */
$t_shop_info = $tablePreStr . "shop_info";
$t_user_info = $tablePreStr . "user_info";
$t_users = $tablePreStr . "users";
$t_shop_category = $tablePreStr . "shop_category";
$t_goods = $tablePreStr . "goods";
$t_article = $tablePreStr . "article";
$t_article_cat = $tablePreStr . "article_cat";

/*导航位置*/
$nav_selected = 5;
$header['title'] = '分享乐园';
$header['keywords'] = '桂林,资讯';
$header['description'] = '桂林资讯网';
$baseUrl = 'test.com';

/* 获取资讯 */
$guilinren_id = 24;
$guilinren_result = get_article_list($dbo, $t_article, $guilinren_id, 1);
$meitu_id = 22;
$meitu_result = get_article_list($dbo, $t_article, $meitu_id, 1);
$weibo_id = 23;
$weibo_result = get_article_list($dbo, $t_article, $weibo_id, 1);
$comment_id = 25;
$comment_result = get_article_list($dbo, $t_article, $comment_id, 1);
$gonglue_id = 21;
$gonglue_result = get_article_list($dbo, $t_article, $gonglue_id, 1);

?>
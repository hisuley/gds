<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/module_shop.php");
require("foundation/module_users.php");
require("foundation/module_article.php");
require("foundation/module_goods.php");
require("foundation/flefttime.php");

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
$t_groupbuy = $tablePreStr."groupbuy";
$t_goods = $tablePreStr."goods";
$t_article = $tablePreStr."article";
$t_article_cat = $tablePreStr."article_cat";

/* 获取首页商品 */
$card_id = 437;
$promote_id = 438;
$goods_card = get_hot_goods_by_cat($dbo, $t_goods, $card_id, 6);
$goods_promote = get_hot_goods_by_cat($dbo, $t_goods, $promote_id, 6);

/* 获取首页优惠资讯 */
$news_promote_id = 26;
$news_promote_result = get_article_list($dbo,$t_article,$news_promote_id,1);

/* 时间处理 */
$now_time = new time_class();
$now_time = $now_time -> short_time();

$group_id=array();
$sql="select group_id from $t_groupbuy where group_condition ='-1' and examine='1'";
$groups_id = $dbo->getRs($sql);
foreach($groups_id as $key=>$val){
	$group_id[$key]=$val[0];
}
$group_id=implode(',',$group_id);

$sql="update $t_groupbuy set group_condition ='0' where  start_time <= '$now_time' and '$now_time' <= end_time ";
if($group_id){
	$sql.=" and group_id in($group_id)";
}
$dbo->exeUpdate($sql);

$group_id=array();
$sql="select group_id from $t_groupbuy where group_condition ='0' and examine='1'";
$groups_id = $dbo->getRs($sql);
foreach($groups_id as $key=>$val){
	$group_id[$key]=$val[0];
}
$group_id=implode(',',$group_id);

$sql="update $t_groupbuy set group_condition ='1' where '$now_time' >= end_time ";
if($group_id){
	$sql.=" and group_id in($group_id)";
}
$dbo->exeUpdate($sql);


$sql = "SELECT b.*,g.* FROM `$t_groupbuy` b left join `$t_goods` g on b.goods_id = g.goods_id";
$sql .= " WHERE b.recommended = 0 and g.lock_flg =0 and b.group_condition ='0' and b.examine = '1'";
//$sql .= " and b.start_time <= '$now_time' and '$now_time' <= b.end_time";
$result = $dbo->fetch_page($sql,$SYSINFO['product_page']);
/*导航位置*/
$nav_selected=5;
$header['title'] = '分享乐园';
$header['keywords'] = '桂林,资讯';
$header['description'] = '桂林资讯网';
$baseUrl = 'test.com';
?>
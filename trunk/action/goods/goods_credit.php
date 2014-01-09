<?php
/*
	-----------------------------------------
	文件：goods_credit.php。
	功能: ajax方式获取商品评价。
	日期：2010-11-01
	-----------------------------------------
*/
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}

// post 数据处理
$page = intval(get_args('page'));
$goods_id = intval(get_args('goods_id'));

//数据表定义区
$t_credit = $tablePreStr."credit";
$t_users = $tablePreStr."users";
$t_level = $tablePreStr."user_level";
//定义写操作
dbtarget('r' , $dbServs);
$dbo = new dbex;

//查询商品评价
$sql = "select c.cid,c. buyer_evaltime, c.seller_evaltime, c.seller_evaluate, c.buyer_evaluate,c.buyer_credit,u.user_id,u.user_name,l.level_name,l.level_id,l.head_img from `$t_credit` as c join `$t_users` as u on c.buyer=u.user_id join $t_level as l on u.level_id = l.level_id  where c.goods_id = $goods_id AND c.seller_evaluate IS NOT NULL";
$result = $dbo->fetch_page($sql,10);

//返回json数据
if($result['result'])
{
	echo json_encode($result);
}
else
{
	exit('-1');
}
?>
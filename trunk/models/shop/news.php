<?php
if (!$IWEB_SHOP_IN) {
    trigger_error('Hacking attempt');
}

require("foundation/module_shop.php");
require("foundation/module_users.php");


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
$t_shop_article = $tablePreStr . "shop_article";

/* 商铺信息处理 */
$SHOP = get_shop_info($dbo, $t_shop_info, $shop_id);
if (!$SHOP) {
    trigger_error($s_langpackage->s_shop_error);
} //没有商铺
$sql = "select rank_id from $t_users where user_id='" . $SHOP['user_id'] . "'";
$ranks = $dbo->getRow($sql);
$SHOP['rank_id'] = $ranks[0];

$header['title'] = $s_langpackage->s_company_news . " - " . $SHOP['shop_name'];
$header['keywords'] = $SHOP['shop_management'];
$header['description'] = sub_str(strip_tags($SHOP['shop_intro']), 100);

$sql = "SELECT article_id,title,shop_id,add_time FROM `$t_shop_article` WHERE is_show=1 AND shop_id='$shop_id' and cat_id=1 ORDER BY add_time desc";
$result = $dbo->fetch_page($sql, 20);

?>
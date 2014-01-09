<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

//数据表定义区
$t_users = $tablePreStr."users";
$t_category = $tablePreStr."category";
$t_users_rss = $tablePreStr."user_rss";

$dbo=new dbex;
//读写分离定义方法
dbtarget('r',$dbServs);

$allCats_sql = "SELECT * FROM $t_category WHERE parent_id IS NULL OR parent_id = ''";
$allCats = $dbo->getRs($allCats_sql);


?>
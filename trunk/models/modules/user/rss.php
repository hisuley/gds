<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}
//引入语言包
$m_langpackage = new moduleslp;
$i_langpackage = new indexlp;

//数据表定义区
$t_users = $tablePreStr . "users";
$t_category = $tablePreStr . "category";
$t_user_rss = $tablePreStr . "user_rss";
//读写分离定义方法
dbtarget('r', $dbServs);
$dbo = new dbex;

$allCats_sql = "SELECT * FROM $t_category WHERE parent_id IS NULL OR parent_id = ''";
$allCats = $dbo->getRs($allCats_sql);

$sql = "SELECT * FROM $t_user_rss WHERE user_id = " . $user_id;
$result = $dbo->getRow($sql);
if (!empty($result['rss_id'])) {
    $myRss = explode(',', $result['cat_id']);
} else {
    $myRss = array();
    $result = array('is_enabled' => 0);
}

?>
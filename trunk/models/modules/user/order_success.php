<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

//引入语言包
$m_langpackage = new moduleslp;
$i_langpackage = new indexlp;

$payid = get_args('id');
if (!$payid) {
    exit($m_langpackage->m_handle_err);
}

//数据表定义区
$t_order_info = $tablePreStr . "order_info";

$dbo = new dbex;
//读写分离定义方法
<<<<<<< HEAD
dbtarget('r',$dbServs);
$sql = "select order_id from `$t_order_info` where payid='$payid'";
=======
dbtarget('r', $dbServs);
$sql = "select order_id,pay_id,shop_id from `$t_order_info` where payid='$payid'";
>>>>>>> remotes/origin/master
$row = $dbo->getRow($sql);
$order_id = $row['order_id'];

?>
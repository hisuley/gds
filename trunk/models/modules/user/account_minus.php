<?php
if (!$IWEB_SHOP_IN) {
    trigger_error('Hacking attempt');
}

//引入语言包
$m_langpackage = new moduleslp;

//获取Post数据
$start_time = short_check(get_args('start_time'));
$end_time = short_check(get_args('end_time'));
$order_id = short_check(get_args('order_id'));
//数据表定义区
$t_user_account = $tablePreStr . "user_account";
$t_users = $tablePreStr . "users";

//读写分离定义方法
$dbo = new dbex;
dbtarget('r', $dbServs);

//判断用户是否锁定，锁定则不许操作
$sql = "select locked from $t_users where user_id=$user_id";
$row = $dbo->getRow($sql);
if ($row['locked'] == 1) {
    session_destroy();
    trigger_error($m_langpackage->m_user_locked); //非法操作
}

$sql = "select a.id,a.amount,a.add_time,a.user_note,a.payment,b.user_name from `$t_user_account` as a left join `$t_users` as b on a.user_id=b.user_id where a.user_id='$user_id' and a.process_type=2";
if ($start_time) {
    $sql .= " and a.add_time >= '$start_time'";
}
if ($end_time) {
    $sql .= " and a.add_time <= '$end_time'";
}
$sql .= " order by a.add_time desc";
$result = $dbo->fetch_page($sql, 10);

?>
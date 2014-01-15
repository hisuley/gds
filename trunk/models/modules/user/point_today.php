<?php
if (!$IWEB_SHOP_IN) {
    trigger_error('Hacking attempt');
}

//引入语言包
$m_langpackage = new moduleslp;

//数据表定义区
$t_user_point = $tablePreStr . "user_point";
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
$time = $ctime->long_time();
$today = substr($time, 0, 10);
$sql = "select a.id,a.point,a.add_time,a.process_type,b.user_name from `$t_user_point` as a left join `$t_users` as b on a.user_id=b.user_id where a.user_id='$user_id' and a.add_time like '$today%'";
$sql .= " order by a.add_time desc";
$result = $dbo->fetch_page($sql, 10);
?>
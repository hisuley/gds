<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

//引入模块公共方法文件
require 'foundation/module_promote.php';


$ctime = new time_class;
$now_time = $ctime->long_time();

//语言包引入
$m_langpackage = new moduleslp;

//数据库操作
dbtarget('w', $dbServs);
$dbo = new dbex();

//定义文件表
$t_promote = $tablePreStr . "goods_promotions";

/* post 数据处理 */
$promote_id = intval(get_args('id'));
$post['start_time'] = $now_time;

//数据库操作
dbtarget('w', $dbServs);
$dbo = new dbex();

$suc = update_promote_release($dbo, $t_promote, $post, $promote_id);

if ($suc) {
    action_return(1, $m_langpackage->m_edit_success, '-1');
} else {
    action_return(0, $m_langpackage->m_edit_fail, '-1');
}

exit;
?>
<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

//引入模块公共方法文件
require 'foundation/module_promote.php';


if (empty($shop_id))
    $shop_id = $user_id;

//语言包引入
$m_langpackage = new moduleslp;

//数据库操作
dbtarget('w', $dbServs);
$dbo = new dbex();

//定义文件表
$t_promote = $tablePreStr . "goods_promotions";

/* post 数据处理 */
$post['start_time'] = short_check(get_args('start_time'));
$post['end_time'] = short_check(get_args('end_time') . ' 23:59:59');
$post['content'] = long_check(get_args('content'));
$post['goods_id'] = intval(get_args('goods_id'));
$post['type'] = short_check(get_args('type'));
$post['promote_price'] = floatval(get_args('promote_price'));
$post['shop_id'] = $shop_id;
$post['is_enabled'] = 1;
$post['is_lock'] = 1;

//数据库操作
dbtarget('w', $dbServs);
$dbo = new dbex();
$insert_id = insert_promote($dbo, $t_promote, $post);

if ($insert_id) {
    action_return(1, $m_langpackage->m_add_success);
} else {
    action_return(0, $m_langpackage->m_add_fail, '-1');
}

exit;
?>
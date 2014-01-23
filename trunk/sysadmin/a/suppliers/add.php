<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}
//引入模块公共方法文件
require_once("../foundation/module_users.php");
require("../foundation/module_shop.php");

//语言包引入
$a_langpackage = new adminlp;

//数据库操作
dbtarget('w', $dbServs);
$dbo = new dbex();

//数据表定义区
$t_users = $tablePreStr . "users";
$t_shop_request = $tablePreStr . "shop_request";
$t_shop_info = $tablePreStr . "shop_info";
$t_word = $tablePreStr . "word";
$t_shop_categories = $tablePreStr . "shop_categories";

// 处理post变量
$post_user['user_name'] = short_check(get_args('user_name'));
$post_user['email_check'] = intval(get_args('email_check'));
$post_user['user_email'] = short_check(get_args('user_email'));
$post_user['user_passwd'] = md5(short_check(get_args('password')));
$post_user['rank_id'] = intval(get_args('rank_id'));
$post_user['reg_time'] = $ctime->long_time();
$post_user['email_check_code'] = md5($post['user_name'] . $ctime->time_stamp());
$user_id = insert_user_info($dbo, $t_users, $post_user);
if (!$user_id) {
    action_return(0, $a_langpackage->a_suppliers_memeber_false, '-1');
}

$post_legal_person['company_name'] = short_check(get_args('company_name'));
$post_legal_person['person_name'] = short_check(get_args('person_name'));
$post_legal_person['credit_type'] = short_check(get_args('credit_type'));
$post_legal_person['credit_num'] = short_check(get_args('credit_num'));
$post_legal_person['company_area'] = short_check(get_args('company_area'));
$post_legal_person['company_address'] = short_check(get_args('company_address'));
$post_legal_person['zipcode'] = short_check(get_args('zipcode'));
$post_legal_person['mobile'] = short_check(get_args('mobile'));
$post_legal_person['telphone'] = short_check(get_args('telphone'));
$post_legal_person['user_id'] = $user_id;
$request_id = intval(get_args('request_id'));
$post_legal_person['add_time'] = $ctime->long_time();
// 图片上传处理
$cupload = new upload();
$cupload->set_dir("../uploadfiles/", "shop/request/$user_id");
$file = $cupload->execute();
if ($file) {
    $post_legal_person['credit_commercial'] = $file[0]['dir'] . $file[0]['name'];
}
if ($request_id) {
    $post_legal_person['status'] = 0;
    $item_sql = get_update_item($post_legal_person);
    $sql = "update `$t_shop_request` set $item_sql where request_id='$request_id'";
} else {
    $item_sql = get_insert_item($post_legal_person);
    $sql = "insert `$t_shop_request` $item_sql";
}
if (!$dbo->exeUpdate($sql)) {
    action_return(0, $a_langpackage->a_suppliers_legal_person_false, '-1');
}


$post_shop['shop_name'] = short_check1(get_args('shop_name'));
//判断商铺名称是否重复
$sql = "select * from $t_shop_info where shop_name='{$post_shop['shop_name']}'";
$array = $dbo->getRs($sql);
if ($array) {
    action_return(0, $a_langpackage->a_shop_yes, '-1');
}
//判断是否有敏感词
$sql = "select * from $t_word";
$row = $dbo->getRs($sql);

$post_shop['shop_address'] = long_check(get_args('shop_address'));
$post_shop['shop_template'] = short_check(get_args('shop_template'));
$post_shop['shop_country'] = intval(get_args('country'));
$post_shop['shop_province'] = intval(get_args('province'));
$post_shop['shop_city'] = intval(get_args('city'));
$post_shop['shop_district'] = intval(get_args('district'));
$post_shop['shop_intro'] = big_check(get_args('shop_intro'));
if ($row) {
    foreach ($row as $v) {
        if (stristr($post_shop['shop_name'], $v['word_name'])) {
            action_return(0, $a_langpackage->a_shop_no . $v['word_name'], '-1');
        }
        if (stristr($post_shop['shop_intro'], $v['word_name'])) {
            action_return(0, $a_langpackage->a_shop_intro_no . $v['word_name'] . $a_langpackage->a_shop_intro_back1, '-1');
        }
    }
}
$post_shop['shop_management'] = short_check(get_args('shop_management'));
$post_shop['user_id'] = $user_id;
$post_shop['shop_id'] = $user_id;
$post_shop['shop_creat_time'] = $ctime->long_time();
$post_shop['shop_categories'] = short_check(get_args('categories'));
if ($post_shop['shop_categories'] == 0)
    $post_shop['shop_categories'] = short_check(get_args('categories_parent'));

if (insert_shop_info($dbo, $t_shop_info, $post_shop)) {
    $sql = "update $t_shop_categories set shops_num=shops_num+1 where cat_id={$post_shop['shop_categories']}";
    $dbo->exeUpdate($sql);
    set_sess_shop_id($post_shop['shop_id']);
    set_session('shop_lock', 0);
    set_session('shop_open', 0);
    action_return(1, $a_langpackage->a_put_suc, 'm.php?app=suppliers_list');
} else {
    action_return(0, $a_langpackage->a_put_lose, '-1');
}
exit;
?>
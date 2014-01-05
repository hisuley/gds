<?php
if(!$IWEB_SHOP_IN) {
	die('Hacking attempt');
}
//引入模块公共方法文件
require_once("../foundation/module_users.php");
require("../foundation/module_shop.php");
require("../foundation/module_admin_logs.php");
require("../foundation/module_remind.php");

//语言包引入
$a_langpackage=new adminlp;
	
//数据库操作
dbtarget('w',$dbServs);
$dbo=new dbex();

//数据表定义区
$t_users = $tablePreStr."users";
$t_shop_request = $tablePreStr."shop_request";
$t_shop_info = $tablePreStr."shop_info";
$t_word= $tablePreStr."word";
$t_shop_categories = $tablePreStr."shop_categories";
$t_remind_info = $tablePreStr."remind_info";
$t_admin_log = $tablePreStr."admin_log";

// 处理post变量
$post_user['user_name'] = short_check(get_args('user_name'));
$post_user['email_check'] = intval(get_args('email_check'));
$post_user['user_email'] = short_check(get_args('user_email'));
if(get_args('password')) {
    $post_user['user_passwd'] = md5(short_check(get_args('password')));
}
$post_user['rank_id'] = intval(get_args('rank_id'));
$user_id = intval(get_args('user_id'));
if(!update_user_info($dbo,$t_users,$post_user,$user_id)) {
	action_return(0,$a_langpackage->a_suppliers_memeber_false,'-1');
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
$cupload->set_dir("../uploadfiles/","shop/request/$user_id");
$file = $cupload->execute();
if($file) {
	$post_legal_person['credit_commercial'] = $file[0]['dir'].$file[0]['name'];
}
if($request_id) {
	$post_legal_person['status'] = 0;
	$item_sql = get_update_item($post_legal_person);
	$sql = "update `$t_shop_request` set $item_sql where request_id='$request_id'";
} else {
	$item_sql = get_insert_item($post_legal_person);
	$sql = "insert `$t_shop_request` $item_sql";
}
if(!$dbo->exeUpdate($sql)) {
	action_return(0,$a_langpackage->a_suppliers_legal_person_false,'-1');
} 

//查询出shop_info的内容
$info = get_shop_info($dbo,$t_shop_info,$user_id);
//判断是否有敏感词
$sql="select * from $t_word";
$row = $dbo->getRs($sql);
$nowtime = $ctime->long_time();
$post_shop['shop_name'] = short_check1(get_args('shop_name'));
if($post_shop['shop_name'] != $info['shop_name']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_name.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);//发送站内信
}
$post_shop['shop_address'] = long_check(get_args('shop_address'));
if($post_shop['shop_address'] != $info['shop_address']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_address.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
$post_shop['shop_template'] = short_check(get_args('shop_template'));
if($post_shop['shop_template'] != $info['shop_template']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_mode.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
$post_shop['shop_country'] = intval(get_args('country'));
if($post_shop['shop_country'] != $info['shop_country']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shopcountry.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
$post_shop['shop_province'] = intval(get_args('province'));
if($post_shop['shop_province'] != $info['shop_province']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_province.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
$post_shop['shop_city'] = intval(get_args('city'));
if($post_shop['shop_city'] != $info['shop_city']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_city.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
$post_shop['shop_district'] = intval(get_args('district'));
if($post_shop['shop_district'] != $info['shop_district']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_district.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
$post_shop['shop_intro'] = big_check(get_args('shop_intro'));
if($post_shop['shop_intro'] != $info['shop_intro']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_intro.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
if($row){
	foreach ($row as $v){
		if(stristr($post_shop['shop_name'],$v['word_name'])){
			action_return(0, $a_langpackage->a_shop_no.$v['word_name'],'-1');
		}
		if(stristr($post_shop['shop_intro'],$v['word_name'])){
			action_return(0, $a_langpackage->a_shop_intro_no.$v['word_name'].$a_langpackage->a_shop_intro_back1,'-1');
		}
	}
}
$post_shop['shop_management'] = short_check(get_args('shop_management'));
if($post_shop['shop_management'] != $info['shop_management']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_shop_range.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
$post_shop['shop_creat_time'] = $ctime->long_time();
$post_shop['shop_categories'] =short_check(get_args('categories'));
if($post_shop['shop_categories']==0)
	$post_shop['shop_categories'] =short_check(get_args('categories_parent'));
if($post_shop['shop_categories'] != $info['shop_categories']){
	$array = array(
		'user_id' => $info['user_id'],
		'remind_info' => $a_langpackage->a_zai.$nowtime."，".$a_langpackage->a_categories_parent.$a_langpackage->a_be_modified,
		'remind_time' => $nowtime,
	);
	insert_remind_info($dbo,$t_remind_info,$array);
}
if(update_shop_info($dbo,$t_shop_info,$post_shop,$user_id)) {
	admin_log($dbo,$t_admin_log,"供应商内容被修改");//'修改店铺内容');
	action_return(1,$a_langpackage->a_put_suc,'m.php?app=suppliers_list');
} else {
	action_return(0,$a_langpackage->a_put_lose,'-1');
}
exit;
?>
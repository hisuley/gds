<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/index_nav.html
 * 如果您的模型要进行修改，请修改 models/shop/index_nav.php
 *
 * 修改完成之后需要您进入后台重新编译，才会重新生成。
 * 如果您开启了debug模式运行，那么您可以省去上面这一步，但是debug模式每次都会判断程序是否更新，debug模式只适合开发调试。
 * 如果您正式运行此程序时，请切换到service模式运行！
 *
 * 如您有问题请到官方论坛（）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if(!function_exists("tpl_engine")) {
	require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/shop/index_nav.html") > filemtime(__file__) || (file_exists("models/shop/index_nav.php") && filemtime("models/shop/index_nav.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop/index_nav.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

if($USER['shop_id']) {
	$url=shop_url($USER['shop_id']);
} else {
	$url='modules.php?app=shop_info';
}
$search_header_type = short_check(get_args("search_type"));
//引入语言包
if(!isset($i_langpackage)){
	$i_langpackage = new indexlp;
}
$ksearch=short_check(get_args("k"));
if($i_langpackage->i_search_keyword==$ksearch){
	$ksearch="";
}
?><div class="header-nav">
	wfjiw
</div><?php } ?>
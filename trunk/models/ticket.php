<?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;
require("foundation/asession.php");
require("configuration.php");
require("includes.php");
require_once("foundation/fstring.php");
error_reporting(0);
/* URL信息处理 */
$cat_id = 1;
//引入语言包
$i_langpackage = new indexlp;

if(empty($cat_id)) {
	trigger_error($i_langpackage->i_illegal);
}

/**
 * 本DEMO仅供SDK的调用测试   携程  技术研发中心 2012年
 */
//定义本系统的相对路径根部

include_once ('union_ticket/SDK.config.php');//配置文件加载--必须加载这个文件
include_once ('union_ticket/sdk/API/Ticket/D_FlightSearch.php');//加载D_FlightSearch这个接口的封装类
include_once ('union_ticket/translate.php');


//构造请求
$ticket=new get_D_FlightSearch();

if(isset($_POST['DepartCity']) && isset($_POST['DepartDate'])){
	$ticket->DepartCity = findCity($_POST['DepartCity']);
	$ticket->DepartDate = $_POST['DepartDate'];
	$requestXML = $ticket->main();
	$returnXML=$ticket->ResponseXML;//返回的数据是一个XML
	$ticket_list = $returnXML->FlightSearchResponse->FlightRoutes->DomesticFlightRoute->FlightsList->DomesticFlightData;
}


/* 用户信息处理 */

require 'foundation/alogin_cookie.php';
if(get_sess_user_id()) {
	$USER['login'] = 1;
	$USER['user_name'] = get_sess_user_name();
	$USER['user_id'] = get_sess_user_id();
	$USER['user_email'] = get_sess_user_email();
	$USER['shop_id'] = get_sess_shop_id();
} else {
	$USER['login'] = 0;
	$USER['user_name'] = '';
	$USER['user_id'] = '';
	$USER['user_email'] = '';
	$USER['shop_id'] = '';
}
?>
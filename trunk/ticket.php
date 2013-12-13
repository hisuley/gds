<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/ticket.html
 * 如果您的模型要进行修改，请修改 models/ticket.php
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
if(filemtime("templates/default/ticket.html") > filemtime(__file__) || (file_exists("models/ticket.php") && filemtime("models/ticket.php") > filemtime(__file__)) ) {
	tpl_engine("default","ticket.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;
require("foundation/asession.php");
require("configuration.php");
require("includes.php");
require_once("foundation/fstring.php");
error_reporting(1);
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
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<meta name="keywords" content="机票预订" />
<meta name="description" content="机票预订" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/parts.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="skin/<?php echo $SYSINFO['templates'];?>/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<title>机票购买</title>
</head>
<body>
<!-- wrapper -->
<div id="wrapper">
  <!-- header -->
  <?php  include("shop/index_header.php");?>
  <!-- /header -->
  <!-- contents -->
  <div id="contents" class="clearfix" >
    <!-- leftColumn -->
    <div id="leftColumn" style="width:960px;">
      <div class="content-common-box">
        <div class="title">
          <h2>机票预订</h2>
        </div>
        <div class="content" style="height:70px;">
	            <form class="pretty-form ticket-form" method="POST">
	              
	              <div class="column-1">
	                <div class="radio-group">
	                  <input type="radio" name="SearchType" value="S" id="singleRadio" checked/>
	                  <label for="singleRadio">单程</label>
	                </div>

	                <div class="radio-group">
	                  <input type="radio" name="SearchType" value="D" id="doubleRadio"/>
	                  <label for="doubleRadio">双程</label>
	                </div>
	              </div>
	              <div class="column-3">
	                <div class="column-2">
	                  <label for="none">城市：</label>
	                </div>
	                <div class="column-8">
	                  <input class="column-10" type="text" name="DepartCity" value=""/>
	                  <input class="column-10" type="text" name="ArriveCity" value=""/>
	                </div>
	              </div>
	              <div class="column-1" style="height:1px;width:5%;"></div>
	              <div class="column-3">
	                <div class="column-2">
	                  <label for="none">日期：</label>
	                </div>
	                <div class="column-8">
	                  <input class="column-10" type="text" name="DepartDate" value=""/>
	                  <input class="column-10" type="text" name="ArriveDate" value=""/>
	                </div>
	              </div>
	              <div class="column-2">
	                <input style="width:70px" type="submit" class="common-button"  value="搜索"/>
	              </div>
	            </form>
        </div>
      </div>
      <div id="leftMian" class="content-common-box">
        <div class="title">
          <h2><?php echo $i_langpackage->i_choice_good;?></h2>
        </div>
        <div id="listItems" class="c_m search_box" style="position:relative">
          <ul class="list_view">
         <?php if(!empty($ticket_list)){?>
         <?php foreach($ticket_list as $v){?>
            <li id="showli_<?php echo (string)$v->AirlineCode;?>" class="clearfix" style="padding:0px;">
            	<table class="search_table_header">
				    <tbody><tr>
				        <td class="logo">
				            <div class="clearfix">
				                <span class="pubFlights_<?php echo strtolower((string)$v->AirlineCode);?> flight_logo"><?php echo translateAirline((string)$v->AirlineCode);?></span>
				                <strong><?php echo (string)$v->Flight;?></strong></div>
				            <div class="low_text">

				    <span class="model">计划机型：<span><?php echo translateCraft((string)$v->CraftType);?></span>
				    </span>
				            </div>
				        </td>
				        <td class="right">
				            <div>
				                <strong class="time"><?php echo date('H:i',strtotime((string)$v->TakeOffTime));?></strong></div>
				            <div>
				                <?php echo translateAirport((string)$v->DPortCode);?></div>
				        </td>
				        <td class="center">
				                <div class="arrow">
				                </div>
				        </td>
				        <td class="left">
				            <div>
				                <strong class="time"><?php echo date('H:i',strtotime((string)$v->ArriveTime));?></strong>
				            </div>
				            <div>
				                <?php echo translateAirport((string)$v->APortCode);?></div>
				        </td>
				        <td>
				            <div class="low_text">
				                <label>燃油+机建：</label><?php echo (string)$v->AdultOilFee;?>元+<?php echo (string)$v->AdultTax;?>元</div>
				            <div class="low_text">
				                    <label>历史准点率：</label>97%</div>
				        </td>
				        <td class="price" style="padding-top:0px;">
				            <span class="base_price02 flightLowestPrice"><dfn>¥</dfn><?php echo intval((string)$v->StandardPrice);?></span><i>起</i>
				        </td>
				        <td class="special">
				        	<a class="itembuy common-button" title="<?php echo $i_langpackage->i_buy;?>" style="width:60px;" href="">购买</a>
				        </td>
				    </tr>
				</tbody></table>
            </li>
             <?php }?>
             <?php }?>
          </ul>
        </div>
        <div class="clearfix"></div>
      </div>
      <!-- leftColumn -->
    </div>
    <!-- rightColumn -->
    <div id="rightColumn">
   
    <!-- /rightColumn -->
    </div>
    <!-- /contents -->
</div>
  <!-- footer -->
 <?php  require("shop/index_footer.php");?>
    <!-- /footer -->
  </div>
  <!-- /wrapper -->
</div>
</body>
</html>
<?php } ?>
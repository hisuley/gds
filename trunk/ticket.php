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
 * 如您有问题请到官方论坛（http://tech.jmlvyou.com/bbs/）提问，谢谢您的支持。
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
<div id="contrastbox" style="z-index:999;position:absolute;right:0;border:1px solid #ccc; background:#FFF; display:none; width:188px;">
	<form action="modules.php?app=contrast" method="post" target="_blank" id="contrastform">
		<input type="hidden" name="contrast_goods_num" id="contrast_goods_num" value="0" />
		<input type="hidden" name="contrast_goods_id" id="contrast_goods_id" value="" />
		<input type="hidden" name="contrast_cid" id="contrast_cid" value="" />
		<input type="hidden" name="contrast_goods_name" id="contrast_goods_name" value="" />
		<div style="padding-bottom:12px;">
  <h2 style="padding:6px 10px;display:block;background:url(skin/default/images/ttlm_01_bg.gif) repeat-x left top;font-size:14px;font-weight:bolder;color:#F77A07;border-bottom:1px solid #ccc"><?php echo $i_langpackage->i_contract_goods;?></h2> <a onclick="clearItems()" style="float:right; position:relative; top:-23px;right:10px" href="javascript:void(0);"><?php echo $i_langpackage->i_close;?></a>
  <div id="contrast_goods_name_show"></div>
  </div>
		<!--<input type="submit" name="sub" value="对比" /> -->
        <a onclick="document.getElementById('contrastform').submit();return false;" href="javascript:;" class="button_4" style=" position:relative;top:25px;display:block;margin-left:100px; width:76px;height:24px;"><img src="skin/default/images/icon_contrast.gif" alt="<?php echo $i_langpackage->i_start_compare;?>"   onerror="this.src='skin/default/images/nopic.gif'"/></a>
	</form>
</div>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
function clearItems(){
	document.getElementById('contrast_goods_id').value ="";
	document.getElementById('contrast_goods_name').value="";
	document.getElementById("contrastbox").style.display='none';
	document.getElementById("contrast_goods_name_show").innerHTML='';
	document.getElementById('contrast_cid').value = '';
}
function delNow(linkitem){
	linkitem.parentNode.parentNode.removeChild(linkitem.parentNode);
	}
function showbox(id) {
	document.getElementById("showbox_"+id).style.display = '';
	var showimg = document.getElementById("showimg_"+id);
	if(showimg.alt=='<?php echo $i_langpackage->i_loading_img;?>') {
		ajax("do.php?act=goods_get_imgurl","POST","id="+id,function(data){
			if(data) {
				showimg.src = data;
				showimg.alt = '';
			}
		});
	}
}
function hidebox(id) {
	document.getElementById("showbox_"+id).style.display = 'none';
}
function addFavorite(id,sid,uid) {
	if(uid=='0'){
		alert("<?php echo  $i_langpackage->i_g_addfailed;?>");
		return;
		}
	if (sid == uid){
		alert('<?php echo $i_langpackage->i_mygoods_error;?>');
	}else {
		ajax("do.php?act=goods_add_favorite","POST","id="+id,function(data){
			if(data == 1) {
				alert("<?php echo  $i_langpackage->i_g_addedfavorite;?>");
			} else if(data == -1) {
				alert("<?php echo  $i_langpackage->i_g_stayfavorite;?>");
			} else {
				alert("<?php echo  $i_langpackage->i_g_addfailed;?>");
			}
		});
	}
}
</script>
<script language="JavaScript" type="text/javascript">
var tips; var theTop = 145/*这是默认高度,越大越往下*/;
var old = theTop;
function initFloatTips(goodsid,goodsname,action,cid) {
	tips = document.getElementById('contrastbox');
	document.getElementById('contrastbox').style.display="";
	var goods_cid = document.getElementById('contrast_cid').value;
	if(goods_cid!=''&& goods_cid!=cid&&action==1){
		alert("<?php echo $i_langpackage->i_compare_error1;?>");
		return;
	}else{
		document.getElementById('contrast_cid').value=cid;
	}
	var goods_num = parseInt(document.getElementById('contrast_goods_num').value);
	var goods_id = document.getElementById('contrast_goods_id').value;
	var goods_name= document.getElementById('contrast_goods_name').value;
	var goods_name_show= document.getElementById('contrast_goods_name_show');
	var goods_id_arr = goods_id.split(",");
	var goods_name_arr = goods_name.split(",");
	if(action==1){
		if(goods_num<5){
			var same_num=0;
			for(i=0;i<goods_id_arr.length;i++){
				if(goods_id_arr[i]==goodsid){
					same_num++;
				}
			}
			if(same_num>0){
				alert("<?php echo $i_langpackage->i_compare_error2;?>");
			}else{
				document.getElementById('contrast_goods_id').value+=goodsid+",";
				document.getElementById('contrast_goods_name').value+=goodsname+",";
				document.getElementById('contrast_goods_num').value=parseInt(goods_num+1);
			}
		}else{
			alert("<?php echo $i_langpackage->i_compare_error3;?>");
		}
	}
	if(action==0){
		var str="";
		var namestr="";
		for(i=0;i<goods_id_arr.length;i++){
			if(goods_id_arr[i]!=goodsid&&goods_id_arr[i]!=''){
				str+=goods_id_arr[i]+",";
				namestr+=goods_name_arr[i]+",";
			}
		}
		document.getElementById('contrast_goods_id').value=str;
		document.getElementById('contrast_goods_name').value=namestr;
	}

	var goods_id_arr = document.getElementById('contrast_goods_id').value.split(",");
	var goods_name_arr = document.getElementById('contrast_goods_name').value.split(",");
	goods_name_show.innerHTML="";
	for(i=0;i<goods_id_arr.length-1;i++){
		goods_name_show.innerHTML+="<li style='padding:8px 0 5px 10px; _padding:8px 0 5px;position:relative;border-bottom:1px solid #f1f1f1;margin-right:10px'>"+"<a href='javascript:;' style='position:absolute;right:0;_right:10px;top:8px;' onclick=\"initFloatTips('"+goods_id_arr[i]+"','"+goods_name_arr[i]+"',0)\"><?php echo $i_langpackage->i_remove;?></a>" + goods_name_arr[i]+"</li>";
	}
	document.getElementById('contrast_goods_num').value=goods_id_arr.length-1;
	if(document.getElementById('contrast_goods_num').value==0){
		document.getElementById('contrastbox').style.display="none";
		document.getElementById('contrast_cid').value="";
	}
	moveTips();
}
function moveTips() {
	var tt=55;
	if (window.innerHeight) {
		pos = window.pageYOffset
	}else if (document.documentElement && document.documentElement.scrollTop) {
		pos = document.documentElement.scrollTop
	}else if (document.body) {
		pos = document.body.scrollTop;
	}
	pos=pos-tips.offsetTop+theTop;
	pos=tips.offsetTop+pos/10;
	if (pos < theTop) {
		pos = theTop
	}
	if (pos != old) {
		tips.style.top = pos+"px";
		tt=10;
	}
	old = pos;
	setTimeout(moveTips,tt);
}
</script>
</html>
<?php } ?>
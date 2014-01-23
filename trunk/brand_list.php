<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/brand_list.html
 * 如果您的模型要进行修改，请修改 models/brand_list.php
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
if(filemtime("templates/default/brand_list.html") > filemtime(__file__) || (file_exists("models/brand_list.php") && filemtime("models/brand_list.php") > filemtime(__file__)) ) {
	tpl_engine("default","brand_list.html",1);
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
require("foundation/module_brand.php");

/* 用户信息处理 */
//require 'foundation/alogin_cookie.php';
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
$type=short_check(get_args("type"));
$rank=short_check(get_args("rank"));
$area=short_check(get_args("area"));
//引入语言包
$i_langpackage=new indexlp;

$header['title'] = $i_langpackage->i_index." - ".$SYSINFO['sys_title'];
$header['keywords'] = $SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];

/* 定义文件表 */

$t_brand = $tablePreStr."brand";
$t_brand_attr = $tablePreStr."brand_attr";

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

$page = 12;
$sql = "select * from `$t_brand` where is_show=1 and brand_logo!=''";

if($type){
    $sql .= " and brand_type like '%$type%'";
}
if($rank){
    $sql .= " and brand_rank like '%$rank%'";
}
if($area){
    $sql .= " and brand_area like '%$area%'";
}
$sql .= " ORDER BY brand_id DESC";
$result =$dbo->fetch_page($sql,$page);
//$result = get_brand_list($dbo,$t_brand,'',12);

$url_this = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$sql_type = "select brand_attr_id,brand_id,attr_name,input_type,attr_values,sort_order, selectable, price from `$t_brand_attr` where attr_name='类型'";
$brand_type = $dbo->getRs($sql_type);
foreach($brand_type as $key => $value){
	$values_after=str_replace(array("\r\n","\r","\n"),',',$value['attr_values']);
	$type_info[$key]['attr_values']=explode(',',$values_after);

	foreach($type_info[$key]['attr_values'] as $k => $va){
		$va=trim($va);
		$sql = "select count(*) AS attr_count from $t_brand where brand_type='$va' and is_show=1";
		$goods_attr_info = $dbo->getRow($sql);
		$type_info[$key]['values_count'][$k]=$goods_attr_info["attr_count"];
	}
}

$sql_rank = "select brand_attr_id,brand_id,attr_name,input_type,attr_values,sort_order, selectable, price from `$t_brand_attr` where attr_name='级别'";
$brand_rank = $dbo->getRs($sql_rank);
foreach($brand_rank as $key => $value){
	$values_after=str_replace(array("\r\n","\r","\n"),',',$value['attr_values']);
	$rank_info[$key]['attr_values']=explode(',',$values_after);

	foreach($rank_info[$key]['attr_values'] as $k => $va){
		$va=trim($va);
		$sql = "select count(*) AS attr_count from $t_brand where brand_rank='$va' and is_show=1";
		$goods_attr_info = $dbo->getRow($sql);
		$rank_info[$key]['values_count'][$k]=$goods_attr_info["attr_count"];
	}
}

$sql_area = "select brand_attr_id,brand_id,attr_name,input_type,attr_values,sort_order, selectable, price from `$t_brand_attr` where attr_name='区域'";
$brand_area = $dbo->getRs($sql_area);
foreach($brand_area as $key => $value){
	$values_after=str_replace(array("\r\n","\r","\n"),',',$value['attr_values']);
	$area_info[$key]['attr_values']=explode(',',$values_after);

	foreach($area_info[$key]['attr_values'] as $k => $va){
		$va=trim($va);
		$sql = "select count(*) AS attr_count from $t_brand where brand_area='$va' and is_show=1";
		$goods_attr_info = $dbo->getRow($sql);
		$area_info[$key]['values_count'][$k]=$goods_attr_info["attr_count"];
	}
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
  <link href="skin/<?php echo  $SYSINFO['templates'];?>/css/parts.css" type="text/css" rel="stylesheet" />
  <script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/jquery-1.8.0.min.js"></script>
  <script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
  <title>景区列表</title>
</head>
<body>
  <!-- wrapper -->
  <div id="wrapper">
    <?php  include("shop/index_header.php");?>
    <!-- contents -->
    <div id="contents" class="clearfix" >
      <div class="SubCategoryBox mg12b">
        <h3>景区筛选</h3>
        <ul>
          <li>
            <span>级别：</span>
            <?php  foreach($rank_info as $key => $value){?>
                    <?php if(get_args('rank'.$value['brand_attr_id'])) {?>
                    <a href=<?php echo preg_replace("/&rank".$value['brand_attr_id']."=([^&]+)/","",$url_this);?>><?php echo $i_langpackage->i_all;?></a>
                    <?php }else{?>
                    <font class="active"><?php echo $i_langpackage->i_all;?></font>
                    <?php }?>
                    <?php  foreach($value['attr_values'] as $k => $v){?>
                    <?php if(get_args('rank'.$value['brand_attr_id'])) {?>
                    <?php $url = preg_replace("/rank".$value['brand_attr_id']."=([^&]+)/","rank".$value['brand_attr_id']."=".urlencode($v),$url_this);?>
                    <?php }else {?>
                    <?php $url = $url_this."&rank".$value['brand_attr_id']."=".urlencode($v);?>
                    <?php }?>
                    <?php if(get_args('rank'.$value['brand_attr_id'])==$v) {?>
                    <a class="active" ><?php echo  $v;?></a>
                    <?php }else{?>
                    <a title="<?php echo  $v;?>" href="<?php echo $url;?>"><?php echo  $v;?></a>
                    <?php }?>
                    <?php }?>
            <?php }?>
          </li>
          
          <li>
            <span>区域:</span>
            <?php  foreach($area_info as $key => $value){?>
                    <?php if(get_args('area'.$value['brand_attr_id'])) {?>
                    <a href=<?php echo preg_replace("/&area".$value['brand_attr_id']."=([^&]+)/","",$url_this);?>><?php echo $i_langpackage->i_all;?></a>
                    <?php }else{?>
                    <font class="active"><?php echo $i_langpackage->i_all;?></font>
                    <?php }?>
                    <?php  foreach($value['attr_values'] as $k => $v){?>
                    <?php if(get_args('area'.$value['brand_attr_id'])) {?>
                    <?php $url = preg_replace("/area".$value['brand_attr_id']."=([^&]+)/","area".$value['brand_attr_id']."=".urlencode($v),$url_this);?>
                    <?php }else {?>
                    <?php $url = $url_this."&area".$value['brand_attr_id']."=".urlencode($v);?>
                    <?php }?>
                    <?php if(get_args('area'.$value['brand_attr_id'])==$v) {?>
                    <a class="active" ><?php echo  $v;?></a>
                    <?php }else{?>
                    <a title="<?php echo  $v;?>" href="<?php echo $url;?>"><?php echo  $v;?></a>
                    <?php }?>
                    <?php }?>
            <?php }?>
          </li>
          <li>
            <span>类型:</span>
            <?php  foreach($type_info as $key => $value){?>
                    <?php if(get_args('type'.$value['brand_attr_id'])) {?>
                    <a href=<?php echo preg_replace("/&type".$value['brand_attr_id']."=([^&]+)/","",$url_this);?>><?php echo $i_langpackage->i_all;?></a>
                    <?php }else{?>
                    <font class="active"><?php echo $i_langpackage->i_all;?></font>
                    <?php }?>
                    <?php  foreach($value['attr_values'] as $k => $v){?>
                    <?php if(get_args('type'.$value['brand_attr_id'])) {?>
                    <?php $url = preg_replace("/type".$value['brand_attr_id']."=([^&]+)/","type".$value['brand_attr_id']."=".urlencode($v),$url_this);?>
                    <?php }else {?>
                    <?php $url = $url_this."&type".$value['brand_attr_id']."=".urlencode($v);?>
                    <?php }?>
                    <?php if(get_args('type'.$value['brand_attr_id'])==$v) {?>
                    <a class="active" ><?php echo  $v;?></a>
                    <?php }else{?>
                    <a title="<?php echo  $v;?>" href="<?php echo $url;?>"><?php echo  $v;?></a>
                    <?php }?>
                    <?php }?>
            <?php }?>
          </li>
          <li><span>关键字：</span>无</li>
        </ul>
      </div>
      <div class="all_brand blank">
        <?php  foreach($result['result'] as $value){?>
        <div class="goodsbox clearfix">
          <h4><span><a href="<?php echo $value['site_url'];?>"><?php echo $value['brand_name'];?></a></span>&nbsp;</h4>
          <div class="imgbox"><a href="brand_info.php?brand_id=<?php echo $value['brand_id'];?>"><img alt=" " src="<?php echo $value['brand_logo'];?>" width="110" height="42"  onerror="this.src='skin/default/images/nopic.gif'"/></a> </div>
          <!--  <p class="phone"></p>-->
          <!-- 放介绍内容，截取32字符-->
          <p class="intro">
              <?php echo substr($value['brand_desc'],0,64);?>
          </p>
          <p class="internet">
            <a href="<?php echo $value['site_url'];?>"><?php echo $value['site_url'];?></a> </p>
        </div>
        <?php }?>
      </div>
      <!-- /contents -->
    </div>


    <div class="pagenav clearfix">
     <?php if($result['countpage']>0){?>
     <?php  include("modules/page.php");?>
     <?php  } else {?>
     <?php echo $i_langpackage->i_no_product;?>！
     <?php }?>
   </div>
   <?php  require("shop/index_footer.php");?>
   <!-- /wrapper -->
 </div>
</body>
<script language="JavaScript">
<!--
function showbox(id) {
	document.getElementById("showbox_"+id).style.display = '';
}
function hidebox(id) {
	document.getElementById("showbox_"+id).style.display = 'none';
}
</script>
</html>
<?php } ?>
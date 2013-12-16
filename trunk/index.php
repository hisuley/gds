<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/index.html
 * 如果您的模型要进行修改，请修改 models/index.php
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
if(filemtime("templates/default/index.html") > filemtime(__file__) || (file_exists("models/index.php") && filemtime("models/index.php") > filemtime(__file__)) ) {
	tpl_engine("default","index.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
header("content-type:text/html;charset=utf-8");
$IWEB_SHOP_IN = true;
require("foundation/asession.php");
require("configuration.php");
require("includes.php");
require("foundation/fstring.php");
require("foundation/module_tag.php");
require("foundation/module_nav.php");
require("foundation/module_goods.php");
require("foundation/module_brand.php");
// require("foundation/fcustom_domain.php");
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

//引入语言包
$i_langpackage=new indexlp;

$header['title'] = $i_langpackage->i_index." - ".$SYSINFO['sys_title'];
$header['keywords'] = $SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];

/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_category = $tablePreStr."category";
$t_goods = $tablePreStr."goods";
$t_index_images = $tablePreStr."index_images";
$t_brand = $tablePreStr."brand";
$t_article = $tablePreStr."article";
$t_users = $tablePreStr."users";
$t_flink= $tablePreStr."flink";
$t_tag = $tablePreStr."tag";
$t_nav = $tablePreStr."nav";
$t_shop_request = $tablePreStr."shop_request";
/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();

/* 处理系统分类 */
$sql_category = "select * from `$t_category` order by sort_order asc,cat_id asc,sort_order asc";
$result_category = $dbo->getRs($sql_category);

$CATEGORY = array();
if($result_category) {
	foreach($result_category as $v) {
		$CATEGORY[$v['parent_id']][$v['cat_id']] = $v;

	}
}

/* 轮显图片 */
$sql_images = "select * from `$t_index_images` where `status`=1 order by id asc limit 6";
$images_info = $dbo->getRs($sql_images);

if($images_info) {
	$images_order = '""';
	$images_array = '';
	$i = 1;
	foreach($images_info as $images) {
		$images_order .= ',"'.$i.'"';
		$images_array .= "imgLink[$i] = '$images[images_link]'; \n";
		$images_array .= "imgUrl[$i] = '$images[images_url]'; \n";
		$images_array .= "imgText[$i] = '$images[name]'; \n";
		$i++;
	}

}

/* 产品处理 */
$sql_promote = "SELECT * FROM $t_goods WHERE is_on_sale=1 AND is_admin_promote=1 and lock_flg=0 order by pv desc limit 10";
$sql_notice = "select * from $t_article where cat_id=3 and is_show=1 order by short_order desc limit 8;";
$sql_maller = "select * from $t_article where cat_id=6 and is_show=1 order by add_time desc limit 3;";
$sql_seller = "select * from $t_article where cat_id=7 and is_show=1 order by add_time desc limit 3;";
$sql_flink = "select * from $t_flink where is_show=1 and brand_logo!='' ORDER BY brand_id DESC limit 10";


$goods_promote = $dbo->getRs($sql_promote);
$goods_hot = get_hot_goods($dbo,$t_goods,8);
$brand_rs = get_brand_list($dbo,$t_brand,8);
$notice = $dbo->getRs($sql_notice);
$maller = $dbo->getRs($sql_maller);
$seller = $dbo->getRs($sql_seller);
$tag_list = get_tag_list($dbo,$t_tag,20);

/* 获取首页商品 */
$hotel_id = 433;
$scenic_id = 434;
$line_id = 435;
$meeting_id = 436;
$card_id = 437;
$promote_id = 438;
$goods_hotel = get_hot_goods_by_cat($dbo, $t_goods, $hotel_id, 6);
$goods_scenic = get_hot_goods_by_cat($dbo, $t_goods, $scenic_id, 6);
$goods_line = get_hot_goods_by_cat($dbo, $t_goods, $line_id, 6);
$goods_meeting = get_hot_goods_by_cat($dbo, $t_goods, $meeting_id, 6);
$goods_card = get_hot_goods_by_cat($dbo, $t_goods, $card_id, 6);
$goods_promote = get_hot_goods_by_cat($dbo, $t_goods, $promote_id, 6);

/* 友情链接 */
$flink_rs = $dbo->getRs($sql_flink);
/* 商家信息 */
$sql_shop = "SELECT a.*,b.user_name FROM $t_shop_info as a,$t_users as b,$t_shop_request as c  where a.user_id = b.user_id and a.user_id = c.user_id and c.status=1 and a.shop_commend=1 and a.lock_flg=0 and a.open_flg=0 order by shop_commend desc,a.shop_id desc limit 7;";
$shop_info = $dbo->getRs($sql_shop);

/*导航位置*/
$nav_selected=1;
$nav_list = get_nav_list($t_nav,$dbo);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title><?php echo  $header['title'];?></title>
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<script type="text/javascript" src="skin/<?php echo $SYSINFO['templates'];?>/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="skin/<?php echo $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script src="skin/<?php echo $SYSINFO['templates'];?>/js/slide.js" type="text/javascript"></script>
<script type='text/javascript' src='servtools/date/WdatePicker.js'></script>
</head>
<body>
<div id="wrapper">
<?php  include("shop/index_header.php");?>
  <!-- contents -->
  <div id="contents" >
    <!-- leftColumn-->
    <div id="leftColumn">
      
      <div class="left_top">
		<div class="slide_container" id="idTransformView">
			  <ul class="slider" id="idSlider">
			  <?php  foreach($images_info as  $key =>$value){?>
				<li><a href="<?php echo $value['images_link'];?>" target="_blank"><img src="<?php echo  $value['images_url'];?>" width="664" height="400" alt="" onerror="this.src='skin/default/images/nopic.gif'"/></a></li>
			  <?php }?>
			 </ul>
			 <ul class="slide_num2" id="idNum2">
				 <?php foreach($images_info as $key =>$value){?>
				 <li><?php echo intval($key+1);?></li>
				 <?php }?>
			 </ul>
        	
        </div>
 
        <ul class="list_adv clearfix">
          <li><script language="JavaScript" src="uploadfiles/asd/1.js"></script></li>
          <li><script language="JavaScript" src="uploadfiles/asd/2.js"></script></li>
          <li><script language="JavaScript" src="uploadfiles/asd/3.js"></script></li>
          <li class="lst"><script language="JavaScript" src="uploadfiles/asd/4.js"></script></li>
        </ul>
      </div>
       <div class="content-common-box content-left-big-box content-blue">
        <div class="title">
          <h2>景区预订</h2>

        </div>
        <?php  foreach($goods_scenic as $key=>$v){?>
         <div class="item-box" style="<?php if($key%3 == 0){?>margin-left:0px;<?php }?>">
          <div class="images">
            <a href="<?php echo  goods_url($v['goods_id']);?>"><img src="<?php echo $v['goods_thumb'];?>" /></a>
          </div>
          <div class="description">
            <a href="<?php echo  goods_url($v['goods_id']);?>"><h3><?php echo sub_str($v['goods_name'], 30);?><span class="stars">✮</span></h3></a>
            <p class="intro">
              <?php echo sub_str(strip_tags($v['goods_intro']), 40);?>
            </p>
            <span class="price">￥<?php echo $v['goods_price'];?></span>
          </div>
        </div>
        <?php }?>
      </div>

      <div class="content-common-box content-left-big-box content-orange">
        <div class="title">
          <h2>酒店预订</h2>

        </div>
       <?php  foreach($goods_hotel as $key=>$v){?>
         <div class="item-box" style="<?php if($key%3 == 0){?>margin-left:0px;<?php }?>">
          <div class="images">
            <a href="<?php echo  goods_url($v['goods_id']);?>"><img src="<?php echo $v['goods_thumb'];?>" /></a>
          </div>
          <div class="description">
            <a href="<?php echo  goods_url($v['goods_id']);?>"><h3><?php echo sub_str($v['goods_name'], 30);?><span class="stars">✮</span></h3></a>
            <p class="intro">
              <?php echo sub_str(strip_tags($v['goods_intro']), 40);?>
            </p>
            <span class="price">￥<?php echo $v['goods_price'];?></span>
          </div>
        </div>
        <?php }?>
      </div>
      <div class="content-common-box content-left-big-box">
        <div class="title">
          <h2>机票预订</h2>
        </div>
        <div class="content" style="height:70px;">
        <script type="text/javascript">
        function inputTxt2(obj,act, initVal){
          var str = initVal;
          if(obj.value==''&&act=='set')
          {
            obj.value=str;
            obj.style.color="#cccccc"
          }
          if(obj.value==str&&act=='clean')
          {
            obj.value='';
            obj.style.color="#000000"
          }
        }
        </script>
            <form class="pretty-form ticket-form" method="POST" action="ticket.php" onsubmit="return checkTicketForm(this);">
              
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
                  <input class="column-10 cityinput" id="startCity" type="text" name="DepartCity" onblur="inputTxt2(this,'set', '请输入城市名称');" onfocus="inputTxt2(this,'clean', '请输入城市名称');" style="color:#cccccc;" value="请输入城市名称" >
                  <input class="column-10 cityinput" id="endCity"  type="text" name="ArriveCity" value="桂林" readonly/>
                </div>
              </div>
              <div class="column-1" style="height:1px;width:5%;"></div>
              <div class="column-3">
                <div class="column-2">
                  <label for="none">日期：</label>
                </div>
                <div class="column-8">
                  <input class="column-10" type="text" id="departDateInput" name="DepartDate" onblur="inputTxt2(this,'set', '请选择出发日期');"  onFocus="WdatePicker({isShowClear:false,readOnly:true,minDate:'%y-%M-{%d}'});inputTxt2(this,'clean', '请选择出发日期');" style="color:#cccccc;" value="请选择出发日期" />
                  <input class="column-10" type="text" name="ArriveDate" onblur="inputTxt2(this,'set', '请选择回程日期');" onFocus="WdatePicker({isShowClear:false,readOnly:true,minDate:document.getElementById('departDateInput').value});inputTxt2(this,'clean', '请选择回程日期');" style="color:#cccccc;" value="请选择回程日期" />
                </div>
              </div>
              <div class="column-2">
                <input style="width:70px" type="submit" class="common-button"  value="搜索"/>
              </div>
              <script type="text/javascript">
              var startCity = new Vcity.CitySelector({input:'startCity'});
              </script>
            </form>
        </div>
      </div>
      <div class="content-common-box content-left-big-box content-orange">
        <div class="title">
          <h2>会议预订</h2>
        </div>
        <?php  foreach($goods_meeting as $key=>$v){?>
         <div class="item-box" style="<?php if($key%3 == 0){?>margin-left:0px;<?php }?>">
          <div class="images">
            <a href="<?php echo  goods_url($v['goods_id']);?>"><img src="<?php echo $v['goods_thumb'];?>" /></a>
          </div>
          <div class="description">
            <a href="<?php echo  goods_url($v['goods_id']);?>"><h3><?php echo sub_str($v['goods_name'], 30);?><span class="stars">✮</span></h3></a>
            <p class="intro">
              <?php echo sub_str(strip_tags($v['goods_intro']), 40);?>
            </p>
            <span class="price">￥<?php echo $v['goods_price'];?></span>
          </div>
        </div>
        <?php }?>
      </div>
      
     

      <div class="content-common-box content-left-big-box content-blue">
        <div class="title">
          <h2>线路预订</h2>

        </div>
       <?php  foreach($goods_line as $key=>$v){?>
         <div class="item-box" style="<?php if($key%3 == 0){?>margin-left:0px;<?php }?>">
          <div class="images">
            <a href="<?php echo  goods_url($v['goods_id']);?>"><img src="<?php echo $v['goods_thumb'];?>" /></a>
          </div>
          <div class="description">
            <a href="<?php echo  goods_url($v['goods_id']);?>"><h3><?php echo sub_str($v['goods_name'], 30);?><span class="stars">✮</span></h3></a>
            <p class="intro">
              <?php echo sub_str(strip_tags($v['goods_intro']), 40);?>
            </p>
            <span class="price">￥<?php echo $v['goods_price'];?></span>
          </div>
        </div>
        <?php }?>
      </div>
      <!-- /leftColumn -->
    </div>
    <!-- rightColumn -->
    <div id="rightColumn">
      <div class="slide-nav">
        <ul id="idNum">
         <?php foreach($images_info as $key =>$value){?>
         <li><a href="<?php echo $value['images_link'];?>"><?php echo $value['name'];?></a><b><?php echo $value['images_desc'];?></b></li>
         <?php }?>
         <script type="text/javascript">slide(400);</script>
       </ul>
      </div>
      <div class="help_guest clearfix">
      	<?php  if($USER['user_id']){?>
			<a title="<?php echo $i_langpackage->i_u_start;?>" href="<?php echo  article_url(11);?>">
	      		<span class="g_help"><?php echo $i_langpackage->i_u_start;?></span>
	      	</a>

	    <?php }else {?>
	      	<a title="<?php echo $i_langpackage->i_register_free;?>" href="modules.php?app=reg">
	      		<span class="g_regist" ><?php echo $i_langpackage->i_register_free;?></span>
	      	</a>
	      	<a title="<?php echo $i_langpackage->i_login;?>" href="login.php">
	      		<span class="g_login"><?php echo $i_langpackage->i_login;?></span>
	      	</a>
	    <?php }?>
      	<a title="<?php echo $i_langpackage->i_free_open;?>" href="modules.php?app=shop_info">
      		<span class="g_opedshop"><?php echo $i_langpackage->i_free_open;?></span>
      	</a>
      </div>
      <div class="rules">
        <ul>
          <li><a class="groupbuy" href="article.php?id=33"><?php echo  $i_langpackage->i_group_buy_small_shops;?></a></li>
          <li><a class="credit" href="article.php?id=34"><?php echo  $i_langpackage->i_credit_evaluation_system;?></a></li>
        </ul>
      </div>
      <div class="user_service mg12b">
        	<div class="top"><div class="line"></div><ul id="tab0"><li id="tab0_title0" class="active" onmouseover="nTabs('tab0',this);"><a href="" hidefocus="true"><?php echo $i_langpackage->i_ammall;?></a></li><li id="tab0_title1" onmouseover="nTabs('tab0',this);"><a href="" hidefocus="true"><?php echo $i_langpackage->i_amsell;?></a></li></ul></div>
            <div id="tab0_content0" class="content">
            	<ul>
                  	 <?php  foreach($maller as $key =>$value){?>
               			<li><a href="article.php?id=<?php echo $value['article_id'];?>"><?php echo  $value['title'];?></a></li>
               		 <?php }?>
                </ul>
            </div>
            <div id="tab0_content1" class="content" style="display:none">
            	<ul>
                	 <?php  foreach($seller as $key =>$value){?>
               			<li><a href="article.php?id=<?php echo $value['article_id'];?>"><?php echo  $value['title'];?></a></li>
            	   <?php }?>
                </ul>
            </div>
        </div>
      <div class="tagSet bg_gary mg12b content-common-box content-right-middle-box">
        <div class="title"><h2><?php echo $i_langpackage->i_hot_label;?></h2></div>
        <div class="tags">
        	<?php foreach($tag_list as $value){?>
        	<a href="<?php echo $value['url'];?>" style="color:<?php echo $value['tag_color'];?>;<?php if($value['is_blod']){?>font-weight:800;<?php }?>"><?php echo $value['tag_name'];?></a>
        	<?php }?>
		</div>
      </div>
      <div class="popularity bg_gary mg12b content-common-box content-right-middle-box">
        <div class="title"><h2><?php echo  $i_langpackage->i_goodsheader_category;?></h2></div>
        <div class="content">
          <ul id="promote_goods" class="cls">
        <?php $i=1;?>
		<?php   foreach($goods_hot as $value){?>
        <li onmouseover="promote_change(this)" <?php if($i==1){?> class="selected"<?php }?> >
        <span class="num"><?php echo $i;?></span><a title="<?php echo  $value['goods_name'];?>" target="_blank" href="<?php echo  goods_url($value['goods_id']);?>"><img src="<?php echo  $value['is_set_image'] ? $value['goods_thumb'] : 'skin/default/images/nopic.gif';?>" height="60" width="60" onerror="this.src='skin/default/images/nopic.gif'"><?php echo  sub_str($value['goods_name'],20,false);?></a><div class="price clearfix">
        <label><b><?php echo $i_langpackage->i_money_sign;?><?php echo $value['goods_price'];?><?php echo $i_langpackage->i_yan;?></b></label></div>
        </li>
        <?php $i++;?>
		<?php }?>
        </ul>
        </div>
      </div>
      <div class="shopLogo bg_gary content-common-box content-right-middle-box">
        <div class="title"><h2>景区导航</h2></div>
        <ul class="list_logos clearfix">
        <?php  foreach($brand_rs as $value){?>
          <li ><a href="brand_info.php?brand_id=<?php echo $value['brand_id'];?>"><img src="<?php echo $value['brand_logo'];?>" alt="<?php echo $value['brand_name'];?>"  width="110" height="42"  onerror="this.src='skin/default/images/no_page.jpg'"/></a></li>
        <?php }?>
        </ul>
      </div>
      <!-- /rightColumn -->
    </div>
    <div style="clear:both"></div>
    <div class="shopRecom bg content-common-box">
      <div class="title"><h2><?php echo $i_langpackage->i_better_shop;?></h2></div>
      <ul class="clearfix">
      <?php  foreach($shop_info as $value){?>
        <li>
          <p class="pic"><a href="<?php echo  shop_url($value['shop_id'],'index',$value['shop_domain']);?>"><img src="<?php echo  $value['shop_logo'] ? $value['shop_logo'] : 'skin/default/images/shop_nologo.gif';?>" alt="<?php echo  $value['shop_name'];?>" width="112" height="55" onerror="this.src='skin/default/images/shop_nologo.gif'"/></a></p>
          <p class="shopname"><a href="<?php echo  shop_url($value['shop_id'],'index',$value['shop_domain']);?>"><?php echo  $value['shop_name'];?></a></p>
          <p class="shopower"><?php echo  $i_langpackage->i_seller;?>：<a href="<?php echo  shop_url($value['shop_id'],'index');?>" ><?php echo  $value['user_name'];?></a></p>
        </li>
      <?php }?>
      </ul>
    </div>
    <!-- /contents -->
</div>
<?php  require("shop/index_footer.php");?>
</div>
</body>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<script language="JavaScript">
<!--


var d = new Date();
var t = d.getTime();
ajax("crons.php","POST","t="+t,function(data){});
//-->
</script>
</html>
<?php } ?>
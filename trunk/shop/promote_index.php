<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/promote_index.html
 * 如果您的模型要进行修改，请修改 models/shop/promote_index.php
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
if(filemtime("templates/default/shop/promote_index.html") > filemtime(__file__) || (file_exists("models/shop/promote_index.php") && filemtime("models/shop/promote_index.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop/promote_index.html",1);
	include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

require("foundation/module_shop.php");
require("foundation/module_users.php");
require("foundation/module_article.php");
require("foundation/module_goods.php");
require("foundation/flefttime.php");

//引入语言包
$s_langpackage=new shoplp;

/* 数据库操作 */
dbtarget('r',$dbServs);
$dbo=new dbex();


/* 定义文件表 */
$t_shop_info = $tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_shop_category = $tablePreStr."shop_category";
$t_groupbuy = $tablePreStr."groupbuy";
$t_goods = $tablePreStr."goods";
$t_article = $tablePreStr."article";
$t_article_cat = $tablePreStr."article_cat";

/* 获取首页商品 */
$card_id = 437;
$promote_id = 438;
$goods_card = get_hot_goods_by_cat($dbo, $t_goods, $card_id, 6);
$goods_promote = get_hot_goods_by_cat($dbo, $t_goods, $promote_id, 6);

/* 获取首页优惠资讯 */
$news_promote_id = 26;
$news_promote_result = get_article_list($dbo,$t_article,$news_promote_id,1);

/* 时间处理 */
$now_time = new time_class();
$now_time = $now_time -> short_time();

$group_id=array();
$sql="select group_id from $t_groupbuy where group_condition ='-1' and examine='1'";
$groups_id = $dbo->getRs($sql);
foreach($groups_id as $key=>$val){
	$group_id[$key]=$val[0];
}
$group_id=implode(',',$group_id);

$sql="update $t_groupbuy set group_condition ='0' where  start_time <= '$now_time' and '$now_time' <= end_time ";
if($group_id){
	$sql.=" and group_id in($group_id)";
}
$dbo->exeUpdate($sql);

$group_id=array();
$sql="select group_id from $t_groupbuy where group_condition ='0' and examine='1'";
$groups_id = $dbo->getRs($sql);
foreach($groups_id as $key=>$val){
	$group_id[$key]=$val[0];
}
$group_id=implode(',',$group_id);

$sql="update $t_groupbuy set group_condition ='1' where '$now_time' >= end_time ";
if($group_id){
	$sql.=" and group_id in($group_id)";
}
$dbo->exeUpdate($sql);


$sql = "SELECT b.*,g.* FROM `$t_groupbuy` b left join `$t_goods` g on b.goods_id = g.goods_id";
$sql .= " WHERE b.recommended = 0 and g.lock_flg =0 and b.group_condition ='0' and b.examine = '1'";
//$sql .= " and b.start_time <= '$now_time' and '$now_time' <= b.end_time";
$result = $dbo->fetch_page($sql,$SYSINFO['product_page']);
/*导航位置*/
$nav_selected=5;
$header['title'] = '分享乐园';
$header['keywords'] = '桂林,资讯';
$header['description'] = '桂林资讯网';
$baseUrl = 'test.com';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo  $header['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/article.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="skin/<?php echo $SYSINFO['templates'];?>/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/jquery.slides.js"></script>
</head>
<body>
<div id="wrapper">
   <?php  require("shop/index_header.php");?>

  <div id="contents" class="clearfix" >
  <div class="content-common-box">
      <img src="./skin/default/images/tehui.jpg" />
      <div class="clearfix"></div>
  </div>
  
  <div class="column-7">
    <div class="content-common-box content-left-big-box">
      <div class="title"><h2>旅游卡特惠</h2></div>
      <?php  foreach($goods_card as $v){?>
         <div class="item-box" style="margin-left:0px;">
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
      <div class="title"><h2>团购乐翻天</h2></div>
      <?php  if($result['result']) {
            foreach($result['result'] as $v){?>
            <div class="item-box" style="margin-left:0px;">
          <div class="images">
            <a href="goods.php?id=<?php echo  $v['group_id'];?>&app=groupbuyinfo"><img src="<?php echo  $v['is_set_image'] ? $v['goods_thumb'] : 'skin/default/images/nopic.gif';?>" width="200" height="150" alt="<?php echo  $v['goods_name'];?>"  onerror="this.src='skin/default/images/nopic.gif'"/></a>
          </div>
          <div class="description">
            <a href="goods.php?id=<?php echo  $v['group_id'];?>&app=groupbuyinfo"><h3><?php echo sub_str($v['goods_name'], 30);?><span class="stars">✮</span></h3></a>
            <p class="intro">
              <p><?php echo sub_str(strip_tags($v['goods_intro']), 40);?></p>
              <p>剩余时间：<?php echo  time_left(strtotime($v['end_time']));?></p>
            </p>
            <span class="price">￥<?php echo $v['spec_price'];?></span>
          </div>
        </div>
        <?php }?>
      <?php }?>
    </div>
    <div class="content-common-box content-left-big-box">
      <div class="title"><h2>秒杀超值购</h2></div>
      <?php  foreach($goods_promote as $v){?>
         <div class="item-box" style="margin-left:0px;">
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
  </div>
  <div class="column-3">
    <div class="content-common-box content-right-middle-box content-siver">
      <div class="title"><h2>优惠全掌握</h2></div>
      <div class="content">
        <ul>
          <?php foreach($news_promote_result['result'] as $val){?>
            <?php if($val['thumb'] != ''){?>
            <li>
              <a href="<?php echo article_url($val['article_id']);?>">
              <img src="<?php echo $val['thumb'];?>" alt="" />
              <div class="inner">
                <h3><font style="color:<?php echo  $val['tag_color'];?> "><?php echo $val['title'];?></font></h3>
                <p>
                  <?php echo sub_str($val['content'], 80);?>
                </p>
              </div>
              </a></li>
              <?php }?>
            <?php }?>
        </ul>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
<!-- main end -->
<?php  require("shop/index_footer.php");?>
<!--footer end-->
</div>
 <style>
    /* Prevents slides from flashing */
    #slides {
      display:none;
    }
    .slidesjs-navigation{display:none}
    .slidesjs-pagination{display:none}
  </style>
<script type="text/javascript">
var $ = jQuery.noConflict();
$(function(){
      $("#slides").slidesjs({
        width: 660,
        height: 200,
        play: {
          active: false,
          auto: true,
          interval: 4000,
          swap: true
        },
        navigation: {
          active: false,
            // [boolean] Generates next and previous buttons.
            // You can set to false and use your own buttons.
            // User defined buttons must have the following:
            // previous button: class="slidesjs-previous slidesjs-navigation"
            // next button: class="slidesjs-next slidesjs-navigation"
          effect: "slide"
            // [string] Can be either "slide" or "fade".
        },
        pagination: {
          active: false
        }
      });
    });

$(document).ready(function(){

  $('div.content-news-box div.title a').click(function(){
    return false;
  });
  $('div.content-news-box div.title a h2').hover(function(){
    /*
      $('div.content-news-box div.title a h2').removeClass('active');
      $(this).addClass('active');
      var targetDiv = $(this).parent('a').attr('href');
      $('div.content-news-box div.content').hide();
      $(targetDiv).show();
      */
    },function(){

    });
});
</script>
</body>
</html>
<?php } ?>
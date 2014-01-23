<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/article_index.html
 * 如果您的模型要进行修改，请修改 models/shop/article_index.php
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
if(filemtime("templates/default/shop/article_index.html") > filemtime(__file__) || (file_exists("models/shop/article_index.php") && filemtime("models/shop/article_index.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop/article_index.html",1);
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
$t_goods = $tablePreStr."goods";
$t_article = $tablePreStr."article";
$t_article_cat = $tablePreStr."article_cat";

/*导航位置*/
$nav_selected=5;
$header['title'] = '资讯全览';
$header['keywords'] = '桂林,资讯';
$header['description'] = '桂林资讯网';
$baseUrl = '';

/*获取首页资讯列表*/

$latestNews_id = 11;
$scenic_id = 12;
$hotel_id = 13;
$line_id = 14;
$food_id = 15;
$traffic_id = 16;
$techan_id = 17;
$buy_id = 18;
$night_id = 19;
$holiday_id = 20;
$tutorial_id = 21;
$latestNews_result = get_article_list($dbo,$t_article,$latestNews_id,$SYSINFO['article_page']);
$scenic_result = get_article_list($dbo,$t_article,$scenic_id,$SYSINFO['article_page']);
$hotel_result = get_article_list($dbo,$t_article,$hotel_id,$SYSINFO['article_page']);
$line_result = get_article_list($dbo,$t_article,$line_id,$SYSINFO['article_page']);
$food_result = get_article_list($dbo,$t_article,$food_id,$SYSINFO['article_page']);
$traffic_result = get_article_list($dbo,$t_article,$traffic_id,$SYSINFO['article_page']);
$techan_result = get_article_list($dbo,$t_article,$techan_id,$SYSINFO['article_page']);
$buy_result = get_article_list($dbo,$t_article,$buy_id,$SYSINFO['article_page']);
$night_result = get_article_list($dbo,$t_article,$night_id,$SYSINFO['article_page']);
$holiday_result = get_article_list($dbo,$t_article,$holiday_id,$SYSINFO['article_page']);
$tutorial_result = get_article_list($dbo,$t_article,$tutorial_id,$SYSINFO['article_page']);

$sql = "SELECT cat_id,cat_icon FROM `$t_article_cat`";
$article_cat_icon = $dbo->getRs($sql);

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
  <div class="content-news-box">
    <div class="title">
      <a href="#newest"><h2 class="active"><a href="news_list.php?id=11">
        <?php  foreach($article_cat_icon as $val){?>
            <?php if($val['cat_id'] == 11 && $val['cat_icon']){?>
                 <img src="<?php echo $val['cat_icon'];?>" width="30px" height="30px">
            <?php }?>
        <?php }?>最新资讯</h2></a></a>
    </div>
    <div class="content" id="newest">
      <div class="column-3">
        <div class="content-news-list">
          <h3>最新资讯</h3>
          <ul>
            <?php foreach($latestNews_result['result'] as $val){?>
            <li>
              <a href="<?php echo article_url($val['article_id']);?>"><font style="color:<?php echo  $val['tag_color'];?> "><?php echo  $val['title'];?></font></a></li>
            <?php }?>
          </ul>
        </div>
      </div>
      <div class="column-7">
         <div id="slides">
          <?php foreach($latestNews_result['result'] as $val){?>
          <?php if($val['thumb'] != ''){?>
          <img src="<?php echo $val['thumb'];?>">
          <?php }?>
          <?php }?>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="content"  style="display:none;" id="travel">
      test2
    </div>
    <div class="content"  style="display:none;" id="media">
      test3
    </div>
  </div>
  <div class="column-3">
    <div class="content-common-box content-left-middle-box content-siver">
      <div class="title"><h2><a href="news_list.php?id=20">
        <?php  foreach($article_cat_icon as $val){?>
            <?php if($val['cat_id'] == 20 && $val['cat_icon']){?>
                 <img src="<?php echo $val['cat_icon'];?>" width="30px" height="30px">
            <?php }?>
        <?php }?>节庆活动</a></h2><span><a href="news_list.php?id=20">更多&gt;&gt;</a></span></div>
      <div class="content">
        <ul>
          <?php foreach($holiday_result['result'] as $val){?>
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
    <div class="content-common-box content-left-middle-box content-siver">
      <div class="title">
        <h2><a href="news_list.php?id=14">
        <?php  foreach($article_cat_icon as $val){?>
            <?php if($val['cat_id'] == 14 && $val['cat_icon']){?>
                 <img src="<?php echo $val['cat_icon'];?>" width="30px" height="30px">
            <?php }?>
        <?php }?>桂林线路</a></h2>
        <span><a href="news_list.php?id=14">更多&gt;&gt;</a></span>
      </div>
       <?php  foreach($line_result['result'] as $v){?>
       <?php if($v['thumb'] != ''){?>
         <div class="item-box" style="margin-left:0px;">
          <div class="images">
            <a href="<?php echo  article_url($v['article_id']);?>"><img src="<?php echo $v['thumb'];?>" /></a>
          </div>
          <div class="description">
            <a href="<?php echo  article_url($v['article_id']);?>"><h3><?php echo sub_str($v['title'], 40);?></h3></a>
            <p class="intro">
              <?php echo sub_str(strip_tags($v['content']), 80);?>
            </p>
          </div>
        </div>
        <?php }?>
        <?php }?>
    </div>
  </div>
  <div class="column-7">
    <div class="content-common-box">
      <div class="title"><h2><a href="news_list.php?id=12">
        <?php  foreach($article_cat_icon as $val){?>
            <?php if($val['cat_id'] == 12 && $val['cat_icon']){?>
                 <img src="<?php echo $val['cat_icon'];?>" width="30px" height="30px">
            <?php }?>
        <?php }?>桂林景点</a></h2><span><a href="news_list.php?id=12">更多&gt;&gt;</a></span></div>
      <?php  foreach($scenic_result['result'] as $v){?>
       <?php if($v['thumb'] != ''){?>
         <div class="item-box" style="margin-left:0px;">
          <div class="images">
            <a href="<?php echo  article_url($v['article_id']);?>"><img src="<?php echo $v['thumb'];?>" /></a>
          </div>
          <div class="description">
            <a href="<?php echo  article_url($v['article_id']);?>"><h3><?php echo sub_str($v['title'], 40);?></h3></a>
            <p class="intro">
              <?php echo sub_str(strip_tags($v['content']), 80);?>
            </p>
          </div>
        </div>
        <?php }?>
        <?php }?>
    </div>
    <div class="content-common-box">
      <div class="title"><h2><a href="news_list.php?id=13">
        <?php  foreach($article_cat_icon as $val){?>
            <?php if($val['cat_id'] == 13 && $val['cat_icon']){?>
                 <img src="<?php echo $val['cat_icon'];?>" width="30px" height="30px">
            <?php }?>
        <?php }?>桂林酒店</a></h2><span><a href="news_list.php?id=13">更多&gt;&gt;</a></span></div>
      <?php  foreach($hotel_result['result'] as $v){?>
       <?php if($v['thumb'] != ''){?>
         <div class="item-box" style="margin-left:0px;">
          <div class="images">
            <a href="<?php echo  article_url($v['article_id']);?>"><img src="<?php echo $v['thumb'];?>" /></a>
          </div>
          <div class="description">
            <a href="<?php echo  article_url($v['article_id']);?>"><h3><?php echo sub_str($v['title'], 40);?></h3></a>
            <p class="intro">
              <?php echo sub_str(strip_tags($v['content']), 80);?>
            </p>
          </div>
        </div>
        <?php }?>
        <?php }?>
    </div>
    <div class="content-common-box">
      <div class="title"><h2><a href="news_list.php?id=15">
        <?php  foreach($article_cat_icon as $val){?>
            <?php if($val['cat_id'] == 15 && $val['cat_icon']){?>
                 <img src="<?php echo $val['cat_icon'];?>" width="30px" height="30px">
            <?php }?>
        <?php }?>桂林美食</a></h2><span><a href="news_list.php?id=15">更多&gt;&gt;</a></span></div>
      <?php  foreach($food_result['result'] as $v){?>
       <?php if($v['thumb'] != ''){?>
         <div class="item-box" style="margin-left:0px;">
          <div class="images">
            <a href="<?php echo  article_url($v['article_id']);?>"><img src="<?php echo $v['thumb'];?>" /></a>
          </div>
          <div class="description">
            <a href="<?php echo  article_url($v['article_id']);?>"><h3><?php echo sub_str($v['title'], 40);?></h3></a>
            <p class="intro">
              <?php echo sub_str(strip_tags($v['content']), 80);?>
            </p>
          </div>
        </div>
        <?php }?>
        <?php }?>
    </div>
     <div class="content-common-box">
      <div class="title"><h2><a href="news_list.php?id=19">
        <?php  foreach($article_cat_icon as $val){?>
            <?php if($val['cat_id'] == 19 && $val['cat_icon']){?>
                 <img src="<?php echo $val['cat_icon'];?>" width="30px" height="30px">
            <?php }?>
        <?php }?>夜美桂林</a></h2><span><a href="news_list.php?id=19">更多&gt;&gt;</a></span></div>
      <?php  foreach($night_result['result'] as $v){?>
       <?php if($v['thumb'] != ''){?>
         <div class="item-box" style="margin-left:0px;">
          <div class="images">
            <a href="<?php echo  article_url($v['article_id']);?>"><img src="<?php echo $v['thumb'];?>" /></a>
          </div>
          <div class="description">
            <a href="<?php echo  article_url($v['article_id']);?>"><h3><?php echo sub_str($v['title'], 40);?></h3></a>
            <p class="intro">
              <?php echo sub_str(strip_tags($v['content']), 80);?>
            </p>
          </div>
        </div>
        <?php }?>
        <?php }?>
    </div>
    <div class="content-common-box">
      <div class="title"><h2><a href="news_list.php?id=17">
        <?php  foreach($article_cat_icon as $val){?>
            <?php if($val['cat_id'] == 17 && $val['cat_icon']){?>
                 <img src="<?php echo $val['cat_icon'];?>" width="30px" height="30px">
            <?php }?>
        <?php }?>桂林特产</a></h2><span><a href="news_list.php?id=17">更多&gt;&gt;</a></span></div>
      <?php  foreach($techan_result['result'] as $v){?>
       <?php if($v['thumb'] != ''){?>
         <div class="item-box" style="margin-left:0px;">
          <div class="images">
            <a href="<?php echo  article_url($v['article_id']);?>"><img src="<?php echo $v['thumb'];?>" /></a>
          </div>
          <div class="description">
            <a href="<?php echo  article_url($v['article_id']);?>"><h3><?php echo sub_str($v['title'], 40);?></h3></a>
            <p class="intro">
              <?php echo sub_str(strip_tags($v['content']), 80);?>
            </p>
          </div>
        </div>
        <?php }?>
        <?php }?>
    </div>
     <div class="content-common-box">
      <div class="title"><h2><a href="news_list.php?id=18">
        <?php  foreach($article_cat_icon as $val){?>
            <?php if($val['cat_id'] == 18 && $val['cat_icon']){?>
                 <img src="<?php echo $val['cat_icon'];?>" width="30px" height="30px">
            <?php }?>
        <?php }?>购在桂林</a></h2><span><a href="news_list.php?id=18">更多&gt;&gt;</a></span></div>
      <?php  foreach($techan_result['result'] as $v){?>
       <?php if($v['thumb'] != ''){?>
         <div class="item-box" style="margin-left:0px;">
          <div class="images">
            <a href="<?php echo  article_url($v['article_id']);?>"><img src="<?php echo $v['thumb'];?>" /></a>
          </div>
          <div class="description">
            <a href="<?php echo  article_url($v['article_id']);?>"><h3><?php echo sub_str($v['title'], 40);?></h3></a>
            <p class="intro">
              <?php echo sub_str(strip_tags($v['content']), 80);?>
            </p>
          </div>
        </div>
        <?php }?>
        <?php }?>
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
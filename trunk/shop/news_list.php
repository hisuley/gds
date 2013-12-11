<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/news_list.html
 * 如果您的模型要进行修改，请修改 models/shop/news_list.php
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
if(filemtime("templates/default/shop/news_list.html") > filemtime(__file__) || (file_exists("models/shop/news_list.php") && filemtime("models/shop/news_list.php") > filemtime(__file__)) ) {
	tpl_engine("default","shop/news_list.html",1);
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

$cat_id = intval(get_args('id'));

$sql = "SELECT * FROM `$t_article_cat` order by sort_order asc";
$article_cat = $dbo->getRs($sql);
if(!$article_cat) {
	trigger_error($s_langpackage->s_no_category);
}

foreach ($article_cat as $val){
	if($val['cat_id']==$cat_id){
		$cat_name=$val['cat_name'];
	}
}
$result = get_article_list($dbo,$t_article,$cat_id,$SYSINFO['article_page']);

if(!$result) {
	trigger_error($s_langpackage->s_no_message);
}

$header = get_header_info($cat_name);

/*导航位置*/
$nav_selected=5;
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
</head>
<body>
<div id="wrapper">
   <?php  require("shop/index_header.php");?>

  <div id="contents" class="clearfix" >
  <?php if($cat_id == 12){?>
    <div class="filters">
      
    </div>
    <div class="content-common-box">
      <div class="item-box">
          <div class="images">
            <a href="#"><img src="http://images4.c-ctrip.com/target/hotel/3000/2874/10F2AED6-E09B-445A-B797-8E895F382E1D_130_130.jpg" /></a>
          </div>
          <div class="description">
            <a href="#"><h3>桂林漓江饭店<span class="stars">✮</span></h3></a>
            <p class="intro">
              叠彩区螺蛳山路1号（ 市中心地区 ，近老人山脚下 ）
            </p>
            <span class="price">￥ 29990</span>
          </div>
        </div>

        <div class="item-box">
          <div class="images">
            <a href="#"><img src="http://images4.c-ctrip.com/target/hotel/3000/2874/10F2AED6-E09B-445A-B797-8E895F382E1D_130_130.jpg" /></a>
          </div>
          <div class="description">
            <a href="#"><h3>桂林漓江饭店<span class="stars">✮</span></h3></a>
            <p class="intro">
              叠彩区螺蛳山路1号（ 市中心地区 ，近老人山脚下 ）
            </p>
            <span class="price">￥ 29990</span>
          </div>
        </div>

        <div class="item-box">
          <div class="images">
            <a href="#"><img src="http://images4.c-ctrip.com/target/hotel/3000/2874/10F2AED6-E09B-445A-B797-8E895F382E1D_130_130.jpg" /></a>
          </div>
          <div class="description">
            <a href="#"><h3>桂林漓江饭店<span class="stars">✮</span></h3></a>
            <p class="intro">
              叠彩区螺蛳山路1号（ 市中心地区 ，近老人山脚下 ）
            </p>
            <span class="price">￥ 29990</span>
          </div>
        </div>

        <div class="item-box">
          <div class="images">
            <a href="#"><img src="http://images4.c-ctrip.com/target/hotel/3000/2874/10F2AED6-E09B-445A-B797-8E895F382E1D_130_130.jpg" /></a>
          </div>
          <div class="description">
            <a href="#"><h3>桂林漓江饭店<span class="stars">✮</span></h3></a>
            <p class="intro">
              叠彩区螺蛳山路1号（ 市中心地区 ，近老人山脚下 ）
            </p>
            <span class="price">￥ 29990</span>
          </div>
        </div>
      </div>
    </div>
  <?php }else{ ;?>
  <div class="filters">
      
  </div>
  <div class="content-common-box">
    <div class="title"><h2><?php echo $cat_name;?><h2></div>
    <div class="content-news-box">
      <ul class="artlist_txt" >
        <?php if($result['result']){?>
        <?php foreach($result['result'] as $val){?>
            <li class="clearfix"><span class="right"><?php echo  $val['add_time'];?></span>
            <a href="<?php echo article_list_url($val['cat_id']);?>">[<?php echo $cat_name;?>]</a>
            <a class="ttls" href="<?php echo article_url($val['article_id']);?>"><font style="color:<?php echo  $val['tag_color'];?> "><?php echo  $val['title'];?></font></a></li>
        <?php }?>
        <?php }else{ ;?>
        <?php echo $i_langpackage->i_none_articles;?>
        <?php }?>
        </ul>
    </div>
  </div>
  <?php }?>

</div>
<!-- main end -->
<?php  require("shop/index_footer.php");?>
<!--footer end-->
</div>
</body>
</html>
<?php } ?>
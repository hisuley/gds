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
 * 如您有问题请到官方论坛（）提问，谢谢您的支持。
 */
?><?php
/*
 * 此段代码由debug模式下生成运行，请勿改动！
 * 如果debug模式下出错不能再次自动编译时，请进入后台手动编译！
 */
/* debug模式运行生成代码 开始 */
if (!function_exists("tpl_engine")) {
    require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/shop/news_list.html") > filemtime(__file__) || (file_exists("models/shop/news_list.php") && filemtime("models/shop/news_list.php") > filemtime(__file__)) ) {
    tpl_engine("default", "shop/news_list.html", 1);
    include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if (!$IWEB_SHOP_IN) {
    trigger_error('Hacking attempt');
}

require("foundation/module_shop.php");
require("foundation/module_users.php");
require("foundation/module_article.php");

//引入语言包
$s_langpackage = new shoplp;

/* 数据库操作 */
dbtarget('r', $dbServs);
$dbo = new dbex();

/* 定义文件表 */
<<<<<<< HEAD
$t_shop_info = $tablePreStr."shop_info";
$t_user_info = $tablePreStr."user_info";
$t_users = $tablePreStr."users";
$t_shop_category = $tablePreStr."shop_category";
$t_goods = $tablePreStr."goods";
$t_article = $tablePreStr."article";
$t_article_cat = $tablePreStr."article_cat";
$t_attribute = $tablePreStr."attribute";
$t_article_attr = $tablePreStr."article_attr";
=======
$t_shop_info = $tablePreStr . "shop_info";
$t_user_info = $tablePreStr . "user_info";
$t_users = $tablePreStr . "users";
$t_shop_category = $tablePreStr . "shop_category";
$t_goods = $tablePreStr . "goods";
$t_article = $tablePreStr . "article";
$t_article_cat = $tablePreStr . "article_cat";

>>>>>>> remotes/origin/master
$cat_id = intval(get_args('id'));
$keyword = short_check(get_args('keyword'));
$in = short_check(get_args('in'));
$attr_arr = get_args("attr");
$url_this = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$sql = "SELECT * FROM `$t_article_cat` order by sort_order asc";
$article_cat = $dbo->getRs($sql);
if (!$article_cat) {
    trigger_error($s_langpackage->s_no_category);
}

foreach ($article_cat as $val) {
    if ($val['cat_id'] == $cat_id) {
        $cat_name = $val['cat_name'];
    }
}
<<<<<<< HEAD

/* 根据属性搜索 */
if(isset($attr_arr)&&$attr_arr){
    foreach ($attr_arr as $k=>$v){
        $attr_arr[$k]=short_check($v);
        $attr_id_arr[]="attr[".$k."]";
    }
}
$get_arr = $_GET;
foreach($get_arr as $k=>$value){
    if(substr($k,0,4) == 'attr'){
        $num = substr($k,4,strlen($k));
        $and .= "aa".$num.".article_id and aa".$num.".article_id=";
        $where .= " and aa".$num.".attr_values = '$value'";
        $from .= "$t_article_attr as aa".$num.",";
    }
}
if($where){
    $sta_num = strpos($and,'and');
    $end_num = strrpos($and,'and');
    $and = substr($and,$sta_num,$end_num-$sta_num);
    $sql = "select * from ".substr($from,0,-1)." where aa".$num.".attr_values != ''".$where." ".$and." group by aa".$num.".article_id";
    $result = $dbo->getRs($sql);
    $news_id = '';
    foreach($result as $value){
        $news_id .= $value['article_id'].",";
    }
    if($news_id != ''){
        $news_id = substr($news_id,0,-1);
    }else{
        $news_id = 0;
    }
    $sql = "SELECT * FROM `$t_article` WHERE is_show=1 and is_audit = 4 and cat_id='$cat_id' AND article_id IN ($news_id) ";
}else{
    $sql = "SELECT * FROM `$t_article` WHERE is_show=1 and is_audit = 4 and cat_id='$cat_id'";
}

if($keyword && $in){
    if($in == 'title'){
        $sql .= " AND title like '%$keyword%'";
    } elseif ($in == 'content'){
        $sql .= " AND content like '%$keyword%'";
    } elseif ($in == 'both') {
        $sql .= " AND content like '%$keyword%' AND title like '%$keyword%'";
    }
}
$sql .= " order by add_time desc ";
$result = $dbo->fetch_page($sql,$SYSINFO['article_page']);

$cat_dg = get_dg_category($article_cat,$cat_id);    //子分类列表

/* 展示属性 */
$sql = "select * from $t_attribute where cat_id='$cat_id' and attr_type = 1 and input_type in(1,2,3) order by sort_order ";
$attr_info = $dbo->getRs($sql);
foreach($attr_info as $key => $value){
    $values_after=str_replace(array("\r\n","\r","\n"),',',$value['attr_values']);
    $attr_info[$key]['attr_values']=explode(',',$values_after);

    foreach($attr_info[$key]['attr_values'] as $k => $va){
        $va=trim($va);
        $sql = "select count(*) AS attr_count from $t_article_attr AS aa, $t_article AS a where aa.attr_values='$va' and
		a.article_id=aa.article_id ";
        $articles_attr_info = $dbo->getRow($sql);
        $attr_info[$key]['values_count'][$k]=$articles_attr_info["attr_count"];
    }
}
=======
$result = get_article_list($dbo, $t_article, $cat_id, $SYSINFO['article_page']);
>>>>>>> remotes/origin/master

if (!$result) {
    trigger_error($s_langpackage->s_no_message);
}
$hot_news = get_hot_news($dbo, $t_article, $cat_id);
$header = get_header_info($cat_name);

/*导航位置*/
$nav_selected = 5;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<<<<<<< HEAD
<title><?php echo  $header['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/index.css" rel="stylesheet" type="text/css" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/parts.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/article.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="skin/<?php echo $SYSINFO['templates'];?>/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
    <?php if($cat_name == '攻略分享' || $cat_name == '攻略'){?>
    <script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/jquery.slides.js"></script>
    <?php }?>
=======
    <title><?php echo $header['title']; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="<?php echo $header['keywords']; ?>"/>
    <meta name="description" content="<?php echo $header['description']; ?>"/>
    <base href="<?php echo $baseUrl; ?>"/>
    <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/index.css" rel="stylesheet" type="text/css"/>
    <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/import.css" type="text/css" rel="stylesheet"/>
    <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/parts.css" type="text/css" rel="stylesheet"/>
    <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/article.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/changeStyle.js"></script>
>>>>>>> remotes/origin/master
</head>
<body>
<div id="wrapper">
    <?php require("shop/index_header.php"); ?>

    <div id="contents" class="clearfix">
        <?php if ($cat_id == 12){ ?>
        <div class="filters">

        </div>
<<<<<<< HEAD
      <?php }?>
      <?php }?>
      </div>
    </div>
  <?php }else{ ;?>
  <div id="leftColumn">
    <div class="SubCategoryBox filters">
        <h3>资讯-新闻搜索</h3>
        <ul>
            <?php  foreach($attr_info as $key => $value){?>
            <li>
                <span><?php echo  $value['attr_name'];?>:</span>
                <?php if(get_args('attr'.$value['attr_id'])) {?>
                <a href=<?php echo preg_replace("/&attr".$value['attr_id']."=([^&]+)/","",$url_this);?>><?php echo $i_langpackage->i_all;?></a>
                <?php }else{?>
                <font class="active"><?php echo $i_langpackage->i_all;?></font>
                <?php }?>
                <?php  foreach($value['attr_values'] as $k => $v){?>
                <?php if(get_args('attr'.$value['attr_id'])) {?>
                <?php $url = preg_replace("/attr".$value['attr_id']."=([^&]+)/","attr".$value['attr_id']."=".urlencode($v),$url_this);?>
                <?php }else {?>
                <?php $url = $url_this."&attr".$value['attr_id']."=".urlencode($v);?>
                <?php }?>
                <?php if(get_args('attr'.$value['attr_id'])==$v) {?>
                <a class="active" ><?php echo  $v;?></a>
                <?php }else{?>
                <a title="<?php echo  $v;?>" href="<?php echo $url;?>"><?php echo  $v;?></a>
                <?php }?>
                <?php }?>
            </li>
            <?php }?>
        </ul>
        <form method="get">
          <input type="hidden" name="id" value="<?php echo $cat_id;?>">
          <input type="text" name="keyword" value="" placeholder="请输入搜索关键词"> 
          <select name="in">
            <option value="title">标题</option>
            <option value="content">内容</option>
            <option value="both">标题和内容</option>
          </select>
          <input type="submit" value="搜索"/>
        </form>
    </div>

    <div class="content-common-box">
      <div class="title"><h2><?php echo $cat_name;?><h2></div>
      <div id="listItems" class="c_m" style="position:relative">
        <ul class="list_view">
          <?php if($result['result']){?>
          <?php foreach($result['result'] as $val){?>
              <li class="clearfix">
                    <div class="photo"><a target="_blank" href="<?php echo article_url($val['article_id']);?>"><img onmouseout="hidebox(<?php echo $val['article_id'];?>)" onmouseover="showbox(<?php echo $val['article_id'];?>)" src="<?php echo  $val['thumb'] ? $val['thumb'] : 'skin/default/images/nopic.gif';?>"  width="<?php echo $SYSINFO['width1'];?>" height="<?php echo $SYSINFO['height1'];?>"  onerror="this.src='skin/default/images/nopic.gif'" /></a></div>
                    <div>
                    <span class="right"><?php echo  $val['add_time'];?></span>
                    <a href="<?php echo article_list_url($val['cat_id']);?>">[<?php echo $cat_name;?>]</a>
                    <a class="ttls" href="<?php echo article_url($val['article_id']);?>"><font style="color:<?php echo  $val['tag_color'];?> "><?php echo  $val['title'];?></font></a>
                    <p class="des"><br>[<?php echo $i_langpackage->i_description;?>]<?php echo  sub_str(strip_tags($val['content']),80);?></p>
                    </div>
                    <div style="display: none;" id="showbox_<?php echo $val['article_id'];?>" class="showbox">
                            <div class="subbox"><img id="showimg_<?php echo $val['article_id'];?>" src="<?php echo  $val['thumb'] ? $val['thumb'] : 'skin/default/images/nopic.gif';?>" width="234" height="234" alt="<?php echo $i_langpackage->i_loading_img;?>"   onerror="this.src='skin/default/images/nopic.gif'"/></div>
                    </div>
              </li>
          <?php }?>
          <?php }else{ ;?>
          <?php echo $i_langpackage->i_none_articles;?>
          <?php }?>
          </ul>
      </div>
    </div>
  </div>
  <div id="rightColumn">
     <?php if($cat_name == '攻略分享' || $cat_name == '攻略'){?>
      <div class="tagSet bg_gary mg12b content-common-box content-right-middle-box">
          <div class="title">
              <h2>图片</h2>
          </div>
          <div id="slides">

              <?php if($result['result']){?>
                  <?php foreach($result['result'] as $val){?>
                  <?php if($val['thumb'] != ''){?>
                  <a href="article.php?id=<?php echo $val['article_id'];?>"><img src="<?php echo $val['thumb'];?>"></a>
                  <?php }?>
                  <?php }?>
              <?php }?>
          </div>
      </div>
      <?php }?>
    <!-- @TODO 判断是否存在子分类，如果存在，则展示 -->
    <div class="tagSet bg_gary mg12b content-common-box content-right-middle-box">
        <div class="title">
          <h2>子分类</h2>
        </div>
        <div class="tags">
            <ul class="artlist_txt" >
            <?php if($cat_dg){?>
            <?php foreach($cat_dg as $val){?>
                <li class="clearfix">
                <a class="ttls" href="<?php echo article_list_url($val['cat_id']);?>"><?php echo  $val['cat_name'];?></a></li>
            <?php }?>
            <?php }else{ ;?>
            <?php echo $i_langpackage->i_none_child_cat;?>
            <?php }?>
            </ul>
=======
        <div class="content-common-box">
            <?php if ($result['result']) { ?>
                <?php foreach ($result['result'] as $val) { ?>
                    <div class="item-box">
                        <div class="images">
                            <a href="<?php echo article_url($val['article_id']); ?>"><img
                                    src="<?php echo $val['thumb']; ?>"/></a>
                        </div>
                        <div class="description">
                            <a href="<?php echo article_url($val['article_id']); ?>">
                                <h3><?php echo sub_str($val['title'], 40); ?></h3></a>

                            <p class="intro">
                                <?php echo sub_str(strip_tags($val['content']), 120); ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
<?php } else {
    ; ?>
    <div id="leftColumn">
        <!-- @TODO 完善搜索功能 -->
        <div class="SubCategoryBox filters">
            <h3>资讯-新闻搜索</h3>

            <form method="get">
                <input type="hidden" name="id" value="<?php echo $cat_id; ?>">
                <input type="text" name="keyword" value="" placeholder="请输入搜索关键词">
                <select name="in">
                    <option value="title">标题</option>
                    <option value="content">内容</option>
                    <option value="both">标题和内容</option>
                </select>
                <input type="submit" value="搜索"/>
            </form>
        </div>
        <div class="content-common-box">
            <div class="title">
                <h2><?php echo $cat_name; ?><h2>
            </div>
            <div class="content-news-box">
                <ul class="artlist_txt">
                    <?php if ($result['result']) { ?>
                        <?php foreach ($result['result'] as $val) { ?>
                            <li class="clearfix"><span class="right"><?php echo $val['add_time']; ?></span>
                                <a href="<?php echo article_list_url($val['cat_id']); ?>">[<?php echo $cat_name; ?>]</a>
                                <a class="ttls" href="<?php echo article_url($val['article_id']); ?>"><font
                                        style="color:<?php echo $val['tag_color']; ?> "><?php echo $val['title']; ?></font></a>
                            </li>
                        <?php } ?>
                    <?php } else {
                        ; ?>
                        <?php echo $i_langpackage->i_none_articles; ?>
                    <?php } ?>
                </ul>
            </div>
>>>>>>> remotes/origin/master
        </div>
    </div>
    <div id="rightColumn">
        <!-- @TODO 判断是否存在子分类，如果存在，则展示 -->
        <div class="tagSet bg_gary mg12b content-common-box content-right-middle-box">
            <div class="title">
                <h2>子分类</h2>
            </div>
            <div class="tags">
                <a href="search.php?k=Test" style="color:;">最美桂林之阳朔</a>
            </div>
        </div>
        <!-- 本分类下热门资讯 -->
        <div class="tagSet bg_gary mg12b content-common-box content-right-middle-box news-box">
            <div class="title">
                <h2>热门资讯</h2>
            </div>
            <ul>
                <li>
                    <a href="">象山区政府助力旅游生根发芽</a>
                </li>
                <li>
                    <a href="">象山区政府助力旅游生根发芽</a>
                </li>
                <li>
                    <a href="">象山区政府助力旅游生根发芽</a>
                </li>
                <li>
                    <a href="">象山区政府助力旅游生根发芽</a>
                </li>
                <li>
                    <a href="">象山区政府助力旅游生根发芽</a>
                </li>
            </ul>
        </div>
<<<<<<< HEAD
        <ul>
            <?php foreach($hot_news as $v){?>

          <li>
            <a href="article.php?id=<?php echo $v['article_id'];?>"><?php echo sub_str($v['title'], 40);?></a>
          </li>
            <?php }?>
        </ul>
     </div>
  </div>
  <?php }?>
=======
    </div>
<?php } ?>
>>>>>>> remotes/origin/master

</div>
<!-- main end -->
<?php require("shop/index_footer.php"); ?>
<!--footer end-->
</div>
</body>
</html>
<script language="JavaScript" src="servtools/ajax_client/ajax.js"></script>
<?php if($cat_name == '攻略分享' || $cat_name == '攻略'){?>
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
            width: 240,
            height: 240,
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
</script>
<?php }?>

    <script language="JavaScript">
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
</script><?php } ?>

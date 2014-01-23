<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/article.html
 * 如果您的模型要进行修改，请修改 models/shop/article.php
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
if (filemtime("templates/default/shop/article.html") > filemtime(__file__) || (file_exists("models/shop/article.php") && filemtime("models/shop/article.php") > filemtime(__file__))) {
    tpl_engine("default", "shop/article.html", 1);
    include(__file__);
} else {
    /* debug模式运行生成代码 结束 */
    ?><?php
    if (!$IWEB_SHOP_IN) {
        trigger_error('Hacking attempt');
    }
    error_reporting(0);
    require("foundation/module_shop.php");
    require("foundation/module_users.php");
    require("foundation/module_article.php");
//引入语言包
    $s_langpackage = new shoplp;

<<<<<<< HEAD
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
$t_attribute = $tablePreStr."attribute";
$t_article_attr = $tablePreStr."article_attr";
=======
    /* 数据库操作 */
    dbtarget('r', $dbServs);
    $dbo = new dbex();
    /* 定义文件表 */
    $t_shop_info = $tablePreStr . "shop_info";
    $t_user_info = $tablePreStr . "user_info";
    $t_users = $tablePreStr . "users";
    $t_shop_category = $tablePreStr . "shop_category";
    $t_goods = $tablePreStr . "goods";
    $t_article = $tablePreStr . "article";
    $t_article_cat = $tablePreStr . "article_cat";
>>>>>>> remotes/origin/master

    $sql = "SELECT * FROM `$t_article_cat` order by sort_order ";
    $article_cat = $dbo->getRs($sql);
    if (!$article_cat) {
        trigger_error($s_langpackage->s_no_category, E_USER_ERROR);
    }
    $article_info = get_article_info($dbo, $t_article, $article_id);
    if (!$article_info) {
        trigger_error($s_langpackage->s_no_news, E_USER_ERROR);
    }

<<<<<<< HEAD
//手动分页
$page = intval(get_args('page'));
$page = max($page,1);
$CONTENT_POS = strpos($article_info['content'], '<hr />');
if($CONTENT_POS !== false) {
        $contents = array_filter(explode('<hr />', $article_info['content']));
        $pagenumber = count($contents);
        for($i=1; $i<=$pagenumber; $i++) {
                $pageurls[$i] = page_url($article_info['article_id'], $i);
        }
        //当不存在 [/page]时，则使用下面分页
        $pages = content_pages($pagenumber,$page, $pageurls);

        $newArr['pages'] = $pages; //分页
        $newArr['contentfulltext'] = $contents[$page-1]; //正文
}else{
        $newArr['contentfulltext'] = $article_info['content']; //正文
}

/* 新闻属性 */
$sql = "SELECT * FROM $t_article_attr WHERE article_id='$article_id'";
$article_attr = $dbo->getRs($sql);
$attr = array();
$attr_ids = array();
$attr_status = false;
if($article_attr) {
	foreach($article_attr as $key=>$value) {
                $attr[$value['attr_id']]['attr_id'] = $value['attr_id'];
                $attr[$value['attr_id']]['attr_values'] = $value['attr_values'];
                $attr[$value['attr_id']]['price'] = $value['price'];
		$attr_ids[] = $value['attr_id'];
	}
	$sql = "SELECT attr_id,attr_name,input_type FROM $t_attribute WHERE attr_id IN (".implode(',',$attr_ids).")";
	$attribute_result = $dbo->getRs($sql);
	$attribute = array();
	foreach($attribute_result as $value) {
		$attribute[$value['attr_id']]['attr_values'] = $value['attr_name'];
                $attribute[$value['attr_id']]['input_type'] = $value['input_type'];
	}
	$attr_status = true;
}

foreach ($article_cat as $val){
	if($val['cat_id']==$article_info['cat_id']){
		$cat_name=$val['cat_name'];
	}
}
$up_article = get_flip_info($dbo,$t_article,$article_id,'up');
$down_article = get_flip_info($dbo,$t_article,$article_id,'down');

if($article_info['is_link'] && $article_info['link_url']) {
	echo "<script>location.href = '".$article_info['link_url']."'</script>";
	exit;
}
//@TODO 请检查为何失效，调用pscws_call.php的时候报错。
include('pscws23/pscws_call.php');
$segmentResult = generateString($article_info['title'],$article_info['article_id']);
$sql = "SELECT * FROM `$t_article` WHERE ".$segmentResult." LIMIT 10";
$relatedArticle = $dbo->getRs($sql);
$header = get_header_info($article_info);
=======
    foreach ($article_cat as $val) {
        if ($val['cat_id'] == $article_info['cat_id']) {
            $cat_name = $val['cat_name'];
        }
    }
    $up_article = get_flip_info($dbo, $t_article, $article_id, 'up');
    $down_article = get_flip_info($dbo, $t_article, $article_id, 'down');

    if ($article_info['is_link'] && $article_info['link_url']) {
        echo "<script>location.href = '" . $article_info['link_url'] . "'</script>";
        exit;
    }
//@TODO 请检查为何失效
//include('pscws23/pscws_call.php');
//$segmentResult = generateString($article_info['title']);
//$sql = "SELECT * FROM `$t_article` WHERE article_id NOT IN(".$article_info['article_id'].") AND (".$segmentResult.") LIMIT 10";
    $sql = "SELECT * FROM $t_article WHERE 1 AND ";
    $relatedArticle = $dbo->getRs($sql);
    $header = get_header_info($article_info);

    $sql = "SELECT article_id,title FROM $t_article WHERE  cat_id='8'";
    $left_article_list = $dbo->getRs($sql);

    ?><?php if ($article_info['cat_id'] == 8) {
        ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
            "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title><?php echo $header['title']; ?></title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <meta name="keywords" content="<?php echo $header['keywords']; ?>"/>
            <meta name="description" content="<?php echo $header['description']; ?>"/>
            <base href="<?php echo $baseUrl; ?>"/>
            <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/import.css" type="text/css" rel="stylesheet"/>
            <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/about.css" type="text/css" rel="stylesheet"/>
            <script type="text/javascript"
                    src="skin/<?php echo $SYSINFO['templates']; ?>/js/jquery-1.8.0.min.js"></script>
            <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/changeStyle.js"></script>
        </head>
        <body>
        <!-- wrapper -->
        <div id="wrapper">
            <?php require("shop/index_header.php"); ?>
            <!-- contents -->
            <div id="contents" class="clearfix">
                <div id="pkz"> <?php echo $s_langpackage->s_this_location; ?><a
                        href="index.php"><?php echo $i_langpackage->i_index; ?></a>> <?php echo $article_info['title']; ?>
                </div>
                <div class="top"><img src="skin/<?php echo $SYSINFO['templates']; ?>/images/about/about_img_top.jpg"
                                      alt="<?php echo $s_langpackage->s_mall_intro; ?>" width="960" height="160"/>
                </div>
                <div id="aboutContents" class="clearfix">
                    <div id="leftColumn">
                        <h3 class="ttlm_aboutMall"><?php echo $s_langpackage->s_mall_intro2; ?></h3>
                        <ul class="list_about">
                            <?php foreach ($left_article_list as $value) { ?>
                                <li <?php if ($value['article_id'] == $article_info['article_id']){ ?>class="now"<?php } ?> >
                                    <a href="article.php?id=<?php echo $value['article_id']; ?>"
                                       <?php if ($value['article_id'] == $article_info['article_id']){ ?>class="now"<?php } ?>><?php echo sub_str($value['title'], 10); ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div id="rightColumn">
                        <p><img class="float_l" src="images/about/about_img_01.jpg" alt="" width="220" height="177"/>
                        </p>
                        <?php echo $article_info['content']; ?>
                    </div>
                </div>
                <!-- /contents -->
            </div>
            <!-- footer -->
            <?php require("shop/index_footer.php"); ?>
            <!-- /footer -->
        </div>
        <!-- /wrapper -->
        </div>
        </body>
        <!-- InstanceEnd -->
        </html>
    <?php } else { ?>
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <title><?php echo $header['title']; ?></title>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <meta name="keywords" content="<?php echo $header['keywords']; ?>"/>
            <meta name="description" content="<?php echo $header['description']; ?>"/>
            <base href="<?php echo $baseUrl; ?>"/>
            <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/import.css" type="text/css" rel="stylesheet"/>
            <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/article.css" type="text/css" rel="stylesheet"/>
            <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/changeStyle.js"></script>
        </head>
        <body>
        <div id="wrapper">
            <?php require("shop/index_header.php"); ?>
            <!--search end -->
            <!-- contents -->
            <div id="contents" class="clearfix">
                <div id="pkz"> <?php echo $i_langpackage->i_location; ?>：<a
                        href="index.php"><?php echo $i_langpackage->i_index; ?></a> > <a
                        href="<?php echo article_list_url($article_info['cat_id']); ?>"><?php echo $cat_name; ?></a>
                    > <?php echo $article_info['title']; ?> </div>
                <div id="mall_banner" class="mg12b">
                    <script language="JavaScript" src="uploadfiles/asd/5.js"></script>
                </div>
                <!--  contents  -->
                <h3 class="ttlm_infoContents"><?php echo $s_langpackage->s_message_center; ?></h3>
>>>>>>> remotes/origin/master

                <div id="artContents" class=" clearfix">
                    <ul class="artlist_ttlm">
                        <?php foreach ($article_cat as $val) { ?>
                            <li <?php if ($val['cat_id'] == $article_info['cat_id']){ ?>class="now"<?php } ?>><a
                                    href="<?php echo article_list_url($val['cat_id']); ?>"><?php echo $val['cat_name']; ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="artpan">
                        <h4 class="artTitle"><font
                                style="color:<?php echo $article_info['tag_color']; ?> "><?php echo $article_info['title']; ?></font>
                        </h4>

<<<<<<< HEAD
?><?php if($article_info['cat_id']==8 ) {?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo  $header['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/about.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
</head>
<body>
<!-- wrapper -->
<div id="wrapper">
  <?php  require("shop/index_header.php");?>
  <!-- contents -->
  <div id="contents" class="clearfix" ><div id="pkz"> <?php echo $s_langpackage->s_this_location;?><a href="index.php"><?php echo $i_langpackage->i_index;?></a>> <?php echo  $article_info['title'];?></div>
    <div class="top"><img src="skin/<?php echo  $SYSINFO['templates'];?>/images/about/about_img_top.jpg" alt="<?php echo $s_langpackage->s_mall_intro;?>"  width="960" height="160" />
    </div>
    <div id="aboutContents" class="clearfix">
    	<div id="leftColumn">
       <h3 class="ttlm_aboutMall"><?php echo $s_langpackage->s_mall_intro2;?></h3>
       <ul class="list_about">
       <?php foreach($left_article_list as $value){?>
       <li <?php if($value['article_id']==$article_info['article_id']){?>class="now"<?php }?> ><a href="article.php?id=<?php echo $value['article_id'];?>" <?php if($value['article_id']==$article_info['article_id']){?>class="now"<?php }?>><?php echo sub_str($value['title'],10);?></a></li>
       <?php }?>
       </ul>
     </div>
     <div id="rightColumn">
     <p><img class="float_l" src="images/about/about_img_01.jpg" alt="" width="220" height="177" /></p>
     <?php echo $article_info['content'];?>
     </div>
    </div><!-- /contents -->
  </div>
  <!-- footer -->
  <?php  require("shop/index_footer.php");?>
    <!-- /footer -->
  </div>
  <!-- /wrapper -->
</div>
</body>
<!-- InstanceEnd -->
</html>
<?php }else{?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo  $header['title'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="<?php echo  $header['keywords'];?>" />
<meta name="description" content="<?php echo  $header['description'];?>" />
<base href="<?php echo  $baseUrl;?>" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/import.css" type="text/css" rel="stylesheet" />
<link href="skin/<?php echo  $SYSINFO['templates'];?>/css/article.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="skin/<?php echo  $SYSINFO['templates'];?>/js/changeStyle.js"></script>
</head>
<?php if($cat_name == '美食' || $cat_name == '桂林美食'){?>
<style>
div.artTxt img{float:right;clear:both;}
div.artTxt div.left{float:left;width:50%;margin-right:3%}
div.artTxt div.right{float:left;width:46%;}
div.artTxt div.right img{max-width: 100%}
</style>
<?php }?>
<body>
<div id="wrapper">
	<?php  require("shop/index_header.php");?>
<!--search end -->
  <!-- contents -->
  <div id="contents" class="clearfix" >
<div id="pkz"> <?php echo $i_langpackage->i_location;?>：<a href="index.php"><?php echo $i_langpackage->i_index;?></a> > <a href="<?php echo article_list_url($article_info['cat_id']);?>"><?php echo $cat_name;?></a> > <?php echo  $article_info['title'];?> </div>
    <div id="mall_banner"  class="mg12b"><script language="JavaScript" src="uploadfiles/asd/5.js"></script></div>
    <!--  contents  -->
    <h3 class="ttlm_infoContents"><?php echo $s_langpackage->s_message_center;?></h3>
    <div id="artContents" class=" clearfix">
        <ul class="artlist_ttlm">
        <?php foreach($article_cat as $val){?>
            <li <?php if($val['cat_id']==$article_info['cat_id']){?>class="now"<?php }?>><a href="<?php echo article_list_url($val['cat_id']);?>"><?php echo $val['cat_name'];?></a></li>
        <?php }?>
        </ul>
      <div class="artpan">
      <h4 class="artTitle"><font style="color:<?php echo  $article_info['tag_color'];?> "><?php echo  $article_info['title'];?></font></h4>
         <?php if(!empty($article_info['sub_title'])){?> <h5 class="artTitle"><font style="font-size:13px;font-weight:bold;"><?php echo  $article_info['sub_title'];?></font></h5><?php }?>
      <div class="artInfo">
        <span><?php echo  $s_langpackage->s_time;?>: <?php echo  substr($article_info['add_time'],0,10);?></span>

      </div>
      <div class="artTxt">
         <?php 
         if($cat_name == '桂林美食'){
            $content = str_replace('../uploadfiles', $SYSINFO['web'].'/uploadfiles', $newArr['contentfulltext']);
            preg_match_all('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$content,$images );
            $content = preg_replace('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i', ' ', $content);
            echo "<div class='left'>".$content."</div>";
            echo "<div class='right'>";
            foreach($images[0] as $v){
                echo $v;
            }
            echo "</div>";
         }else{
      	    echo "<p>".str_replace('../uploadfiles', $SYSINFO['web'].'/uploadfiles', $newArr['contentfulltext'])."</p>";
         }?>
      </div>
      <div class="facility_baseinfo clrfix"><span style="text-align:center;margin:0 auto;"><?php echo $newArr [pages];?></span>
            <ul class="telephoneinfo">
                <?php 
                if($attr_status) {
                foreach($attr as $key=>$value){?>
                    <?php if($attribute[$key]['input_type'] == 3 && !empty($attribute[$key]['attr_values'])) {
                        $valueArr = explode("\n", $value['attr_values']);
                        echo "<li>".$attribute[$key]['attr_values']."：";
                        foreach($valueArr as $subVal){
                            echo "<input type='checkbox' checked />".$subVal;
                        }
                        echo "</li>";
                    } else {
                        echo "<li>".$attribute[$key]['attr_values']."：".$value['attr_values']."</li>";
                    }
                } }?>
            </ul>
            <div class="clearfix"></div>
        </div>
      <!-- FIXED -->
      <div class="artRelated">
        <h3>相关文章</h3>
        <ul>
          <?php if(!empty($relatedArticle)){?>
            <?php foreach($relatedArticle as $val){?>
                <li><a href="article.php?id=<?php echo $val['article_id'];?>"><?php echo $val['title'];?></a></li>
            <?php }?>
           <?php }?>
        </ul>
      </div>
  <div class="clearfix"></div>
      </div>
      <div class="link">
       <p ><?php echo $i_langpackage->i_up_article;?>：<?php if(empty($up_article)){?> <?php echo $i_langpackage->i_none_article;?> <?php }?><a href="<?php echo article_url($up_article['article_id']);?>"><?php echo $up_article['title'];?></a><br/><?php echo $i_langpackage->i_down_article;?>：<?php if(empty($down_article)){?> <?php echo $i_langpackage->i_none_article;?> <?php }?><a href="<?php echo article_url($down_article['article_id']);?>"><?php echo $down_article['title'];?></a></p>
      </div>
      </div>
      <!--  contents  -->
    </div>
    <!-- /contents -->
  </div>
=======
                        <div class="artInfo">
                            <span><?php echo $s_langpackage->s_time; ?>
                                : <?php echo substr($article_info['add_time'], 0, 10); ?></span>

                        </div>
                        <div class="artTxt">
                            <p><?php echo $article_info['content']; ?></p>
                        </div>
                        <!-- FIXED -->
                        <div class="artRelated">
                            <h3>相关文章</h3>
                            <ul>
                                <?php if (!empty($relatedArticle)) { ?>
                                    <?php foreach ($relatedArticle as $val) { ?>
                                        <li>
                                            <a href="article.php?id=<?php echo $val['article_id']; ?>"><?php echo $val['title']; ?></a>
                                        </li>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="link">
                        <p><?php echo $i_langpackage->i_up_article; ?>
                            ：<?php if (empty($up_article)) { ?> <?php echo $i_langpackage->i_none_article; ?> <?php } ?>
                            <a href="<?php echo article_url($up_article['article_id']); ?>"><?php echo $up_article['title']; ?></a><br/><?php echo $i_langpackage->i_down_article; ?>
                            ：<?php if (empty($down_article)) { ?> <?php echo $i_langpackage->i_none_article; ?> <?php } ?>
                            <a href="<?php echo article_url($down_article['article_id']); ?>"><?php echo $down_article['title']; ?></a>
                        </p>
                    </div>
                </div>
                <!--  contents  -->
            </div>
            <!-- /contents -->
        </div>
>>>>>>> remotes/origin/master

        <!-- main end -->
        <?php require("shop/index_footer.php"); ?>
        <!--footer end-->
        </div>
        </body>
        </html>
    <?php } ?>
    </body>
    </html>
<?php } ?>
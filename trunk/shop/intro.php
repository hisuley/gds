<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/intro.html
 * 如果您的模型要进行修改，请修改 models/shop/intro.php
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
if(filemtime("templates/default/shop/intro.html") > filemtime(__file__) || (file_exists("models/shop/intro.php") && filemtime("models/shop/intro.php") > filemtime(__file__)) ) {
    tpl_engine("default", "shop/intro.html", 1);
    include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
if (!$IWEB_SHOP_IN) {
    trigger_error('Hacking attempt');
}
/* 公共信息处理 header, left, footer */
require("foundation/module_shop.php");
require("foundation/module_users.php");
require("foundation/module_shop_category.php");

//引入语言包
$s_langpackage = new shoplp;
$i_langpackage = new indexlp;

/* 数据库操作 */
dbtarget('r', $dbServs);
$dbo = new dbex();

/* 定义文件表 */
$t_shop_info = $tablePreStr . "shop_info";
$t_user_info = $tablePreStr . "user_info";
$t_users = $tablePreStr . "users";
$t_shop_category = $tablePreStr . "shop_category";
$t_goods = $tablePreStr . "goods";
$t_shop_categories = $tablePreStr . "shop_categories";

/* 商铺信息处理 */
$SHOP = get_shop_info($dbo, $t_shop_info, $shop_id);
if (!$SHOP) {
    trigger_error($s_langpackage->s_shop_error);
}//没有此商铺
//商铺分类
$shop_rank = $SHOP['shop_categories'];
$shop_rank_arr = get_categories_rank($shop_rank, $dbo, $t_shop_categories);
if ($shop_rank_arr) {
    $num = count($shop_rank_arr) - 1;
}
$sql = "select rank_id,user_name,last_login_time from $t_users where user_id='" . $SHOP['user_id'] . "'";
$ranks = $dbo->getRow($sql);
$SHOP['rank_id'] = $ranks[0];
/* 获取文章头部 */
$header = get_shop_header($s_langpackage->s_intro, $SHOP);

//$nav_selected=3;
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $header['title']; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="<?php echo $header['keywords']; ?>"/>
    <meta name="description" content="<?php echo $header['description']; ?>"/>
    <base href="<?php echo $baseUrl; ?>"/>
    <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/import.css" type="text/css" rel="stylesheet"/>
    <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/shop.css" rel="stylesheet" type="text/css"/>
    <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/shop_<?php echo $SHOP['shop_template']; ?>.css"
          rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/changeStyle.js"></script>
</head>
<body>
<!-- wrapper -->
<div id="wrapper"> <?php require("shop/index_header.php"); ?>
    <!-- contents -->
    <div id="contents" class="clearfix">
        <div id="pkz">
            <!--    	<?php echo $s_langpackage->s_this_location;?><a href="index.php"><?php echo  $SYSINFO['sys_name'];?></a> &gt; <a href="shop_list.php"><?php echo $s_langpackage->s_shop_category;?></a> &gt;-->
            <!--    	<?php foreach($shop_rank_arr as $k=>$value){?>-->
            <!--    		<?php  if($num == $k){?>-->
            <!--    			<a href="" ><?php echo $value['cat_name'];?></a>-->
            <!--    		<?php  } else{?>-->
            <!--    			<a href="" ><?php echo $value['cat_name'];?></a> &gt;-->
            <!--    		<?php }?>-->
            <!--    	<?php }?>-->
        </div>
        <div id="shopHeader" class=" mg12b clearfix">
            <!-- ���̶���ͼƬ-->
            <p><img src="<?php echo $SHOP['shop_template_img']; ?>" alt="" width="960" height="150"
                    onerror="this.src='skin/default/images/nopic.gif'"/></p>

            <p class="shopName"><?php echo $SHOP['shop_name']; ?></p>

            <div class="shop_nav"> <?php require("shop/menu.php"); ?> </div>
        </div>
        <?php require("shop/left.php"); ?>
        <div id="rightCloumn">
            <div class="wrp_b">
                <h3 class="ttlm_font"><?php echo $s_langpackage->s_shop_intro; ?></h3>

                <div class="shopIdc">
                    <?php echo $SHOP['shop_intro']; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require("shop/index_footer.php"); ?>
</div>
</body>
</html><?php } ?>
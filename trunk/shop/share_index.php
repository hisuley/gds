<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/share_index.html
 * 如果您的模型要进行修改，请修改 models/shop/share_index.php
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
if(filemtime("templates/default/shop/share_index.html") > filemtime(__file__) || (file_exists("models/shop/share_index.php") && filemtime("models/shop/share_index.php") > filemtime(__file__)) ) {
    tpl_engine("default", "shop/share_index.html", 1);
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
$t_shop_info = $tablePreStr . "shop_info";
$t_user_info = $tablePreStr . "user_info";
$t_users = $tablePreStr . "users";
$t_shop_category = $tablePreStr . "shop_category";
$t_goods = $tablePreStr . "goods";
$t_article = $tablePreStr . "article";
$t_article_cat = $tablePreStr . "article_cat";

/*导航位置*/
$nav_selected = 5;
$header['title'] = '分享乐园';
$header['keywords'] = '桂林,资讯';
$header['description'] = '桂林资讯网';
$baseUrl = 'test.com';

/* 获取资讯 */
$guilinren_id = 24;
$guilinren_result = get_article_list($dbo, $t_article, $guilinren_id, 1);
$meitu_id = 22;
$meitu_result = get_article_list($dbo, $t_article, $meitu_id, 1);
$weibo_id = 23;
$weibo_result = get_article_list($dbo, $t_article, $weibo_id, 1);
$comment_id = 25;
$comment_result = get_article_list($dbo, $t_article, $comment_id, 1);
$gonglue_id = 21;
$gonglue_result = get_article_list($dbo, $t_article, $gonglue_id, 1);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title><?php echo $header['title']; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="<?php echo $header['keywords']; ?>"/>
    <meta name="description" content="<?php echo $header['description']; ?>"/>
    <base href="<?php echo $baseUrl; ?>"/>
    <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/index.css" rel="stylesheet" type="text/css"/>
    <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/import.css" type="text/css" rel="stylesheet"/>
    <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/article.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/changeStyle.js"></script>
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/jquery.slides.js"></script>
</head>
<body>
<div id="wrapper">
    <?php require("shop/index_header.php"); ?>

    <div id="contents" class="clearfix">
        <div class="column-7">
            <div class="content-common-box content-left-big-box">
                <div class="title">
                    <h2>桂林人向导</h2>
                </div>
                <?php foreach ($guilinren_result['result'] as $v) { ?>
                    <?php if ($v['thumb'] != '') { ?>
                        <div class="item-box" style="margin-left:0px;">
                            <div class="images">
                                <a href="<?php echo article_url($v['article_id']); ?>"><img
                                        src="<?php echo $v['thumb']; ?>"/></a>
                            </div>
                            <div class="description">
                                <a href="<?php echo article_url($v['article_id']); ?>">
                                    <h3><?php echo sub_str($v['title'], 40); ?></h3></a>

                                <p class="intro">
                                    <?php echo sub_str(strip_tags($v['content']), 80); ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <div class="clearfix"></div>

            </div>
        </div>

        <div class="column-3">
            <img src="./skin/default/images/share_03.png" style="float:right"/>
        </div>
        <div class="clearfix"></div>
        <div class="column-3">
            <div class="content-common-box content-left-middle-box content-siver">
                <div class="title"><h2>美图分享</h2></div>
                <div class="content">
                    <ul>
                        <?php foreach ($meitu_result['result'] as $val) { ?>
                            <?php if ($val['thumb'] != '') { ?>
                                <li>
                                    <a href="<?php echo article_url($val['article_id']); ?>">
                                        <img src="<?php echo $val['thumb']; ?>" alt=""/>

                                        <div class="inner">
                                            <h3><font
                                                    style="color:<?php echo $val['tag_color']; ?> "><?php echo $val['title']; ?></font>
                                            </h3>

                                            <p>
                                                <?php echo sub_str($val['content'], 80); ?>
                                            </p>
                                        </div>
                                    </a></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="column-7">
            <div class="content-common-box">
                <div class="title"><h2>微博分享</h2></div>
                <?php foreach ($weibo_result['result'] as $v) { ?>
                    <?php if ($v['thumb'] != '') { ?>
                        <div class="item-box" style="margin-left:0px;">
                            <div class="images">
                                <a href="<?php echo article_url($v['article_id']); ?>"><img
                                        src="<?php echo $v['thumb']; ?>"/></a>
                            </div>
                            <div class="description">
                                <a href="<?php echo article_url($v['article_id']); ?>">
                                    <h3><?php echo sub_str($v['title'], 40); ?></h3></a>

                                <p class="intro">
                                    <?php echo sub_str(strip_tags($v['content']), 80); ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <div class="clearfix"></div>
            </div>
            <div class="content-common-box">
                <div class="title"><h2>评价汇总</h2></div>
                <?php foreach ($comment_result['result'] as $v) { ?>
                    <?php if ($v['thumb'] != '') { ?>
                        <div class="item-box" style="margin-left:0px;">
                            <div class="images">
                                <a href="<?php echo article_url($v['article_id']); ?>"><img
                                        src="<?php echo $v['thumb']; ?>"/></a>
                            </div>
                            <div class="description">
                                <a href="<?php echo article_url($v['article_id']); ?>">
                                    <h3><?php echo sub_str($v['title'], 40); ?></h3></a>

                                <p class="intro">
                                    <?php echo sub_str(strip_tags($v['content']), 80); ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <div class="clearfix"></div>
            </div>
            <div class="content-common-box">
                <div class="title"><h2>攻略分享</h2></div>
                <?php foreach ($gonglue_result['result'] as $v) { ?>
                    <?php if ($v['thumb'] != '') { ?>
                        <div class="item-box" style="margin-left:0px;">
                            <div class="images">
                                <a href="<?php echo article_url($v['article_id']); ?>"><img
                                        src="<?php echo $v['thumb']; ?>"/></a>
                            </div>
                            <div class="description">
                                <a href="<?php echo article_url($v['article_id']); ?>">
                                    <h3><?php echo sub_str($v['title'], 40); ?></h3></a>

                                <p class="intro">
                                    <?php echo sub_str(strip_tags($v['content']), 80); ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- main end -->
    <?php require("shop/index_footer.php"); ?>
    <!--footer end-->
</div>
<style>
    /* Prevents slides from flashing */
    #slides {
        display: none;
    }

    .slidesjs-navigation {
        display: none
    }

    .slidesjs-pagination {
        display: none
    }
</style>
<script type="text/javascript">
    var $ = jQuery.noConflict();
    $(function () {
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

    $(document).ready(function () {

        $('div.content-news-box div.title a').click(function () {
            return false;
        });
        $('div.content-news-box div.title a h2').hover(function () {
            /*
             $('div.content-news-box div.title a h2').removeClass('active');
             $(this).addClass('active');
             var targetDiv = $(this).parent('a').attr('href');
             $('div.content-news-box div.content').hide();
             $(targetDiv).show();
             */
        }, function () {

        });
    });
</script>
</body>
</html>
<?php } ?>
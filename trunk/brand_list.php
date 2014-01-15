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
if (!function_exists("tpl_engine")) {
    require("foundation/ftpl_compile.php");
}
if(filemtime("templates/default/brand_list.html") > filemtime(__file__) || (file_exists("models/brand_list.php") && filemtime("models/brand_list.php") > filemtime(__file__)) ) {
    tpl_engine("default", "brand_list.html", 1);
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
if (get_sess_user_id()) {
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
$i_langpackage = new indexlp;

$header['title'] = $i_langpackage->i_index . " - " . $SYSINFO['sys_title'];
$header['keywords'] = $SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];

/* 定义文件表 */

$t_brand = $tablePreStr . "brand";


/* 数据库操作 */
dbtarget('r', $dbServs);
$dbo = new dbex();

$result = get_brand_list($dbo, $t_brand, '', 12);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/import.css" type="text/css" rel="stylesheet"/>
    <link href="skin/<?php echo $SYSINFO['templates']; ?>/css/parts.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="skin/<?php echo $SYSINFO['templates']; ?>/js/changeStyle.js"></script>
    <title>景区列表</title>
</head>
<body>
<!-- wrapper -->
<div id="wrapper">
    <?php include("shop/index_header.php"); ?>
    <!-- contents -->
    <div id="contents" class="clearfix">
        <div class="SubCategoryBox mg12b">
            <h3>景区筛选</h3>
            <ul>
                <li>
                    <span>级别：</span>
                    <!-- 用提取到属性值进行替换 -->
                    <a class="active">全部</a>
                    <a title="漓江景区" href="http://202.103.241.239/test1225/category.php?id=434&amp;brand_id=23">AAA</a>
                    <a title="漓江景区" href="http://202.103.241.239/test1225/category.php?id=434&amp;brand_id=23">AA</a>
                    <a title="漓江景区" href="http://202.103.241.239/test1225/category.php?id=434&amp;brand_id=23">A</a>
                </li>

                <li>
                    <span>区域:</span>
                    <font class="active">全部</font>
                    <!-- 用提取到属性值进行替换 -->
                    <a title="七星区"
                       href="http://202.103.241.239/test1225/category.php?id=434&amp;attr47=%E4%B8%83%E6%98%9F%E5%8C%BA">七星区</a>
                    <a title="象山区"
                       href="http://202.103.241.239/test1225/category.php?id=434&amp;attr47=%E8%B1%A1%E5%B1%B1%E5%8C%BA">象山区</a>
                    <a title="秀峰区"
                       href="http://202.103.241.239/test1225/category.php?id=434&amp;attr47=%E7%A7%80%E5%B3%B0%E5%8C%BA">秀峰区</a>
                    <a title="叠彩区"
                       href="http://202.103.241.239/test1225/category.php?id=434&amp;attr47=%E5%8F%A0%E5%BD%A9%E5%8C%BA">叠彩区</a>
                </li>
                <li>
                    <span>类型:</span>
                    <font class="active">全部</font>
                    <!-- 用提取到属性值进行替换 -->
                    <a title="七星区"
                       href="http://202.103.241.239/test1225/category.php?id=434&amp;attr47=%E4%B8%83%E6%98%9F%E5%8C%BA">古代遗迹</a>
                    <a title="象山区"
                       href="http://202.103.241.239/test1225/category.php?id=434&amp;attr47=%E8%B1%A1%E5%B1%B1%E5%8C%BA">历史建筑</a>
                    <a title="秀峰区"
                       href="http://202.103.241.239/test1225/category.php?id=434&amp;attr47=%E7%A7%80%E5%B3%B0%E5%8C%BA">自然风景名胜区</a>
                    <a title="叠彩区"
                       href="http://202.103.241.239/test1225/category.php?id=434&amp;attr47=%E5%8F%A0%E5%BD%A9%E5%8C%BA">叠彩区</a>
                </li>
                <li><span>关键字：</span>无</li>
            </ul>
        </div>
        <div class="all_brand blank">
            <?php foreach ($result['result'] as $value) { ?>
                <div class="goodsbox clearfix">
                    <h4><span><a href="<?php echo $value['site_url']; ?>"><?php echo $value['brand_name']; ?></a></span>&nbsp;
                    </h4>

                    <div class="imgbox"><a href="brand_info.php?brand_id=<?php echo $value['brand_id']; ?>"><img alt=" "
                                                                                                                 src="<?php echo $value['brand_logo']; ?>"
                                                                                                                 width="110"
                                                                                                                 height="42"
                                                                                                                 onerror="this.src='skin/default/images/nopic.gif'"/></a>
                    </div>
                    <!--  <p class="phone"></p>-->
                    <!-- 放介绍内容，截取32字符-->
                    <p class="intro">
                        <?php echo substr($value['brand_desc'], 0, 64); ?>
                    </p>

                    <p class="internet">
                        <a href="<?php echo $value['site_url']; ?>"><?php echo $value['site_url']; ?></a></p>
                </div>
            <?php } ?>
        </div>
        <!-- /contents -->
    </div>


    <div class="pagenav clearfix">
        <?php if ($result['countpage'] > 0) { ?>
            <?php include("modules/page.php"); ?>
        <?php } else { ?>
            <?php echo $i_langpackage->i_no_product; ?>！
        <?php } ?>
    </div>
    <?php require("shop/index_footer.php"); ?>
    <!-- /wrapper -->
</div>
</body>
<script language="JavaScript">
    <
    !--
        function showbox(id) {
            document.getElementById("showbox_" + id).style.display = '';
        }
    function hidebox(id) {
        document.getElementById("showbox_" + id).style.display = 'none';
    }
</script>
</html>
<?php } ?>
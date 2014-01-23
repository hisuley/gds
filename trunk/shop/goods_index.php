<?php
/*
 * 注意：此文件由itpl_engine编译型模板引擎编译生成。
 * 如果您的模板要进行修改，请修改 templates/default/shop/goods_index.html
 * 如果您的模型要进行修改，请修改 models/shop/goods_index.php
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
if(filemtime("templates/default/shop/goods_index.html") > filemtime(__file__) || (file_exists("models/shop/goods_index.php") && filemtime("models/shop/goods_index.php") > filemtime(__file__)) ) {
    tpl_engine("default", "shop/goods_index.html", 1);
    include(__file__);
} else {
/* debug模式运行生成代码 结束 */
?><?php
$IWEB_SHOP_IN = true;
require("foundation/module_category.php");
require("foundation/module_tag.php");
require_once("foundation/fstring.php");
require_once("foundation/module_areas.php");
require("foundation/module_goods.php");
error_reporting(1);
/* URL信息处理 */
$cat_id = 433;
//引入语言包
$i_langpackage = new indexlp;

if (empty($cat_id)) {
    trigger_error($i_langpackage->i_illegal);
}

/* 用户信息处理 */
require 'foundation/alogin_cookie.php';
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
$brand_id = get_args("brand_id");
$attr_arr = get_args("attr");


/* 定义文件表 */
$t_shop_info = $tablePreStr . "shop_info";
$t_category = $tablePreStr . "category";
$t_goods = $tablePreStr . "goods";
$t_users = $tablePreStr . "users";
$t_areas = $tablePreStr . "areas";
$t_attribute = $tablePreStr . "attribute";
$t_goods_attr = $tablePreStr . "goods_attr";
$t_brand = $tablePreStr . "brand";
$t_brand_category = $tablePreStr . "brand_category";
$t_user_rank = $tablePreStr . "user_rank";
$t_tag = $tablePreStr . "tag";

$viewlist = "display:block";
$viewwindow = "display:none";

/* 数据库操作 */
dbtarget('r', $dbServs);
$dbo = new dbex();
/* 处理系统分类 */
$sql_category = "select * from `$t_category` order by sort_order asc,cat_id asc";
$result = $dbo->getRs($sql_category);
$CATEGORY = array();
$cat_info = array();
foreach ($result as $v) {
    $CATEGORY[$v['parent_id']][$v['cat_id']] = $v;
}
foreach ($result as $v) {
    $cat_info[$v['cat_id']] = $v;
}

/* 列表处理 */
if (!function_exists('getsubcats')) {
    function getsubcats($catinfo, $id)
    {
        $str = '';
        if (isset($catinfo[$id]) && $catinfo[$id]) {
            foreach ($catinfo[$id] as $v) {
                $str .= "," . $v['cat_id'];
                $str .= getsubcats($catinfo, $v['cat_id']);
            }
        }
        return $str;
    }
}
if ($cat_id) {
    $catids = $cat_id;
    $catids .= getsubcats($CATEGORY, $cat_id);
    $this_catinfo = $cat_info[$cat_id];
    $this_parent_info = '';
    if ($cat_info[$cat_id]['parent_id'] > 0) {
        $this_parent_info = $cat_info[$cat_info[$cat_id]['parent_id']];
    }
}
if (isset($attr_arr) && $attr_arr) {
    foreach ($attr_arr as $k => $v) {
        $attr_arr[$k] = short_check($v);
        $attr_id_arr[] = "attr[" . $k . "]";
    }
}
$areainfo = get_areas_kv($dbo, $t_areas);
/* 产品处理 */
$sql_best = "SELECT * FROM $t_goods WHERE is_on_sale=1 AND is_best=1 and lock_flg=0 order by pv desc limit 5";
$sql_hot = "SELECT * FROM $t_goods WHERE is_on_sale=1 AND is_hot=1 and lock_flg=0 order by pv desc limit 5";
$goods_best = $dbo->getRs($sql_best);
$goods_hot = $dbo->getRs($sql_hot);
$areainfo = get_areas_kv($dbo, $t_areas);
$get_arr = $_GET;
$where = "";
$from = "";

/* 获取商品 */
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


//print_r($get_arr);
$and = '';
foreach ($get_arr as $k => $value) {
    if (substr($k, 0, 4) == 'attr') {
        $num = substr($k, 4, strlen($k));
        $and .= "g" . $num . ".goods_id and g" . $num . ".goods_id=";
        $where .= " and g" . $num . ".attr_values = '$value'";
        $from .= "$t_goods_attr as g" . $num . ",";
    }
}
if ($where) {
    $sta_num = strpos($and, 'and');
    $end_num = strrpos($and, 'and');
    $and = substr($and, $sta_num, $end_num - $sta_num);
    $sql = "select * from " . substr($from, 0, -1) . " where g" . $num . ".attr_values != ''" . $where . " " . $and . " group by g" . $num . ".goods_id";
    $result = $dbo->getRs($sql);
    $goods_id = '';
    foreach ($result as $value) {
        $goods_id .= $value['goods_id'] . ",";
    }
    if ($goods_id != '') {
        $goods_id = substr($goods_id, 0, -1);
    } else {
        $goods_id = 0;
    }
    $sql = "SELECT g.pv,g.is_set_image,g.brand_id,g.transport_price,g.transport_template_price,g.goods_thumb,g.goods_id,g.cat_id,g.goods_name,g.goods_price,g.goods_intro,g.shop_id,s.shop_id,s.shop_name,s.user_id,u.user_id,u.rank_id,ur.rank_id,ur.rank_name,
			s.shop_province,s.shop_city	FROM `$t_goods` AS g,`$t_users` AS u,`$t_shop_info` AS s,`$t_user_rank` AS ur WHERE g.lock_flg<>1 and  
		g.goods_id IN ($goods_id) and g.is_on_sale=1 AND g.shop_id=s.shop_id AND s.user_id=u.user_id AND u.rank_id=ur.rank_id ";
} else {
    $sql = "SELECT g.pv,g.is_set_image,g.brand_id,g.transport_price,g.transport_template_price,g.goods_thumb,g.goods_id,g.cat_id,g.goods_name,g.goods_price,g.goods_intro,g.shop_id,s.shop_id,s.shop_name,s.user_id,u.user_id,u.rank_id,ur.rank_id,ur.rank_name,
			s.shop_province,s.shop_city	FROM `$t_goods` AS g,`$t_users` AS u,`$t_shop_info` AS s,`$t_user_rank` AS ur WHERE g.lock_flg<>1 and g.cat_id IN ($catids) AND g.is_on_sale=1 AND g.shop_id=s.shop_id AND s.user_id=u.user_id AND u.rank_id=ur.rank_id ";
}
if ($brand_id > 0) {
    $sql .= " AND g.brand_id='$brand_id'";
}
$k = short_check(get_args("k"));
$kk = $k;
//echo $k;

if ($k && $k != $i_langpackage->i_search_keyword) {
    $tag_sql = "SELECT distinct goods_id FROM $t_tag WHERE tag_name LIKE '%$k%'";
    $tag_list = $dbo->getRs($tag_sql);
    foreach ($tag_list as $key => $v) {
        $tag_list[$key] = $v['goods_id'];
    }
    $goods_sql = "SELECT distinct goods_id FROM $t_goods WHERE goods_name LIKE '%$k%'";
    $goods_list = $dbo->getRs($goods_sql);
    foreach ($goods_list as $key2 => $v2) {
        $goods_list[$key2] = $v2['goods_id'];
    }
    $goods_ids = implode(",", $goods_list);
    $goods_ids .= implode(",", $tag_list);
    $arr = explode(",", $goods_ids);
    $arr = array_unique($arr);
    $goods_ids = implode(",", $arr);
    if ($goods_ids == "") {
        $goods_ids = "0";
    }
    $sql .= " AND g.goods_id IN ($goods_ids) ";
//		$k_sql="select * from $t_keywords_count where keywords='$k'";
//		$id_row=$dbo->getRow($k_sql);

} else {
    $kk = '无';
}
if ($_POST) {
    $order_name = $_POST['name'];
    $order = $_POST['order'];
    if ($order_name) {
        $sql .= "ORDER BY g.$order_name $order,g.pv DESC ";
    } else {
        $sql .= "ORDER BY g.pv DESC ";
    }
} else {
    $sql .= "ORDER BY g.goods_price asc,g.pv DESC ";
}

if ($cat_id == '') {
    $sql = "SELECT g.pv,g.is_set_image,g.brand_id,g.transport_price,g.transport_template_price,g.goods_thumb,g.goods_id,g.cat_id,g.goods_name,g.goods_price,g.goods_intro,g.shop_id,s.shop_id,s.shop_name,s.user_id,u.user_id,u.rank_id,ur.rank_id,ur.rank_name,
			s.shop_province,s.shop_city	FROM `$t_goods` AS g WHERE g.is_on_sale=1 AND g.shop_id=s.shop_id AND s.user_id=u.user_id AND u.rank_id=ur.rank_id ";

}
$result = $dbo->fetch_page($sql, $SYSINFO['product_page']);
$goods_list = $result['result'];
unset($result['result']);
/* 浏览记录 */
$getcookie = get_hisgoods_cookie();
$goodshistory = array();
if ($getcookie) {
    arsort($getcookie);
    $getcookie = array_keys($getcookie);
    $gethisgoodsid = implode(",", array_slice($getcookie, 0, 4));
    $sql = "select is_set_image,goods_id,goods_name,goods_thumb,goods_price from $t_goods where goods_id in ($gethisgoodsid)";
    $goodshistory = $dbo->getRs($sql);
}
$header['title'] = "无忧预订 - " . $SYSINFO['sys_title'];
$header['keywords'] = $this_catinfo['cat_name'] . ',' . $SYSINFO['sys_keywords'];
$header['description'] = $SYSINFO['sys_description'];
$url_this = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
//print_r($_SERVER);
/* 属性 */
$sql = "select * from $t_attribute where cat_id='$cat_id' order by sort_order ";
$attr_info = $dbo->getRs($sql);
foreach ($attr_info as $key => $value) {
    $values_after = str_replace(array("\r\n", "\r", "\n"), ',', $value['attr_values']);
    $attr_info[$key]['attr_values'] = explode(',', $values_after);

    foreach ($attr_info[$key]['attr_values'] as $k => $va) {
        $va = trim($va);
        $sql = "select count(*) AS attr_count from $t_goods_attr AS ga, $t_goods AS g where ga.attr_values='$va' and g.is_on_sale=1 and
		g.goods_id=ga.goods_id ";
        $goods_attr_info = $dbo->getRow($sql);
        $attr_info[$key]['values_count'][$k] = $goods_attr_info["attr_count"];
    }
}
//品牌列表
$sql = "SELECT distinct brand_id FROM $t_brand_category WHERE cat_id='$cat_id'";
$list = $dbo->getRs($sql);
$brand_list = array();
if (is_array($list)) {
    foreach ($list as $value) {
        $sql = "SELECT brand_id,brand_name FROM $t_brand WHERE brand_id='{$value['brand_id']}'";
        $row = $dbo->getRow($sql);
        $brand_list[$row['brand_id']]['brand_id'] = $row['brand_id'];
        $brand_list[$row['brand_id']]['brand_name'] = $row['brand_name'];
        if (get_args('brand_id')) {
            $url = preg_replace("/brand_id=([^&]+)/", "brand_id=" . $row['brand_id'], $url_this);
        } else {
            $url = $url_this . "&brand_id=" . urlencode($row['brand_id']);
        }
        $brand_list[$row['brand_id']]['url'] = $url;
    }
}
array_push($brand_list, array("brand_id" => 0, "brand_name" => $i_langpackage->i_all, "url" => preg_replace("/&brand_id=([^&]+)/", "", $url_this)));
$brand_list = array_reverse($brand_list);
$nav_selected = 4;
$sub_category = get_parent_cats($cat_id, $dbo, $t_category);
$tag_list = get_tag_list($dbo, $t_tag, 15);

/* 处理系统分类 */
$sql_category = "select * from `$t_category` order by sort_order asc,cat_id asc,sort_order asc";
$result_category = $dbo->getRs($sql_category);

$CATEGORY = array();
if ($result_category) {
    foreach ($result_category as $v) {
        $CATEGORY[$v['parent_id']][$v['cat_id']] = $v;

    }
}

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
    <script type='text/javascript' src='servtools/date/WdatePicker.js'></script>
</head>
<body>
<div id="wrapper">
    <?php require("shop/index_header.php"); ?>
    <div class="content-common-box">
        <div class="title">
            <h2>机票预订</h2>
        </div>
        <div class="content" style="height:70px;">
            <script type="text/javascript">
                function inputTxt2(obj, act, initVal) {
                    var str = initVal;
                    if (obj.value == '' && act == 'set') {
                        obj.value = str;
                        obj.style.color = "#cccccc"
                    }
                    if (obj.value == str && act == 'clean') {
                        obj.value = '';
                        obj.style.color = "#000000"
                    }
                }
            </script>
            <form class="pretty-form ticket-form" method="POST" action="ticket.php"
                  onsubmit="return checkTicketForm(this);">

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
                        <input class="column-10 cityinput" style="background-position:200px 3px;" id="startCity"
                               type="text" name="DepartCity" onblur="inputTxt2(this,'set', '请输入城市名称');"
                               onfocus="inputTxt2(this,'clean', '请输入城市名称');" style="color:#cccccc;" value="请输入城市名称">
                        <input class="column-10 cityinput" id="endCity" style="background-position:200px 3px;"
                               type="text" name="ArriveCity" value="桂林" readonly/>
                    </div>
                </div>
                <div class="column-1" style="height:1px;width:5%;"></div>
                <div class="column-3">
                    <div class="column-2">
                        <label for="none">日期：</label>
                    </div>
                    <div class="column-8">
                        <input class="column-10" type="text" name="DepartDate"
                               onblur="inputTxt2(this,'set', '请选择出发日期');"
                               onFocus="WdatePicker({isShowClear:false,readOnly:true});inputTxt2(this,'clean', '请选择出发日期');"
                               style="color:#cccccc;" value="请选择出发日期"/>
                        <input class="column-10" type="text" name="ArriveDate"
                               onblur="inputTxt2(this,'set', '请选择回程日期');"
                               onFocus="WdatePicker({isShowClear:false,readOnly:true});inputTxt2(this,'clean', '请选择回程日期');"
                               style="color:#cccccc;" value="请选择回程日期"/>
                    </div>
                </div>
                <div class="column-2">
                    <input style="width:70px" type="submit" class="common-button" value="搜索"/>
                </div>
                <script type="text/javascript">
                    var startCity = new Vcity.CitySelector({input: 'startCity'});
                </script>
            </form>
        </div>
    </div>
    <div class="content-common-box content-orange">
        <div class="title">
            <h2>会议预订</h2>
            <span><a href="category.php?id=436">更多&gt;&gt;</a></span>
        </div>
        <?php foreach ($goods_meeting as $v) { ?>
            <div class="item-box" style="margin-left:0px;">
                <div class="images">
                    <a href="<?php echo goods_url($v['goods_id']); ?>"><img src="<?php echo $v['goods_thumb']; ?>"/></a>
                </div>
                <div class="description">
                    <a href="<?php echo goods_url($v['goods_id']); ?>"><h3><?php echo sub_str($v['goods_name'], 30); ?>
                            <span class="stars">✮</span></h3></a>

                    <p class="intro">
                        <?php echo sub_str(strip_tags($v['goods_intro']), 40); ?>
                    </p>
                    <span class="price">￥<?php echo $v['goods_price']; ?></span>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="content-common-box content-blue">
        <div class="title">
            <h2>景点预订</h2>
            <span><a href="category.php?id=434">更多&gt;&gt;</a></span>

        </div>
        <?php foreach ($goods_scenic as $v) { ?>
            <div class="item-box" style="margin-left:0px;">
                <div class="images">
                    <a href="<?php echo goods_url($v['goods_id']); ?>"><img src="<?php echo $v['goods_thumb']; ?>"/></a>
                </div>
                <div class="description">
                    <a href="<?php echo goods_url($v['goods_id']); ?>"><h3><?php echo sub_str($v['goods_name'], 30); ?>
                            <span class="stars">✮</span></h3></a>

                    <p class="intro">
                        <?php echo sub_str(strip_tags($v['goods_intro']), 40); ?>
                    </p>
                    <span class="price">￥<?php echo $v['goods_price']; ?></span>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="content-common-box content-orange">
        <div class="title">
            <h2>酒店预订</h2>
            <span><a href="category.php?id=433">更多&gt;&gt;</a></span>

        </div>
        <?php foreach ($goods_hotel as $v) { ?>
            <div class="item-box" style="margin-left:0px;">
                <div class="images">
                    <a href="<?php echo goods_url($v['goods_id']); ?>"><img src="<?php echo $v['goods_thumb']; ?>"/></a>
                </div>
                <div class="description">
                    <a href="<?php echo goods_url($v['goods_id']); ?>"><h3><?php echo sub_str($v['goods_name'], 30); ?>
                            <span class="stars">✮</span></h3></a>

                    <p class="intro">
                        <?php echo sub_str(strip_tags($v['goods_intro']), 40); ?>
                    </p>
                    <span class="price">￥<?php echo $v['goods_price']; ?></span>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="content-common-box content-blue">
        <div class="title">
            <h2>线路预订</h2>
            <span><a href="category.php?id=435">更多&gt;&gt;</a></span>

        </div>
        <?php foreach ($goods_line as $v) { ?>
            <div class="item-box" style="margin-left:0px;">
                <div class="images">
                    <a href="<?php echo goods_url($v['goods_id']); ?>"><img src="<?php echo $v['goods_thumb']; ?>"/></a>
                </div>
                <div class="description">
                    <a href="<?php echo goods_url($v['goods_id']); ?>"><h3><?php echo sub_str($v['goods_name'], 30); ?>
                            <span class="stars">✮</span></h3></a>

                    <p class="intro">
                        <?php echo sub_str(strip_tags($v['goods_intro']), 40); ?>
                    </p>
                    <span class="price">￥<?php echo $v['goods_price']; ?></span>
                </div>
            </div>
        <?php } ?>
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
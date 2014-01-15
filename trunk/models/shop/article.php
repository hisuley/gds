<?php
if (!$IWEB_SHOP_IN) {
    trigger_error('Hacking attempt');
}
error_reporting(0);
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
$t_attribute = $tablePreStr . "attribute";
$t_article_attr = $tablePreStr . "article_attr";

$sql = "SELECT * FROM `$t_article_cat` order by sort_order ";
$article_cat = $dbo->getRs($sql);
if (!$article_cat) {
    trigger_error($s_langpackage->s_no_category, E_USER_ERROR);
}
$article_info = get_article_info($dbo, $t_article, $article_id);
if (!$article_info) {
    trigger_error($s_langpackage->s_no_news, E_USER_ERROR);
}

//手动分页
$page = intval(get_args('page'));
$page = max($page, 1);
$CONTENT_POS = strpos($article_info['content'], '<hr />');
if ($CONTENT_POS !== false) {
    $contents = array_filter(explode('<hr />', $article_info['content']));
    $pagenumber = count($contents);
    for ($i = 1; $i <= $pagenumber; $i++) {
        $pageurls[$i] = page_url($article_info['article_id'], $i);
    }
    //当不存在 [/page]时，则使用下面分页
    $pages = content_pages($pagenumber, $page, $pageurls);

    $newArr['pages'] = $pages; //分页
    $newArr['contentfulltext'] = $contents[$page - 1]; //正文
} else {
    $newArr['contentfulltext'] = $article_info['content']; //正文
}

/* 新闻属性 */
$sql = "SELECT * FROM $t_article_attr WHERE article_id='$article_id'";
$article_attr = $dbo->getRs($sql);
$attr = array();
$attr_ids = array();
$attr_status = false;
if ($article_attr) {
    foreach ($article_attr as $key => $value) {
        $attr[$value['attr_id']]['attr_id'] = $value['attr_id'];
        $attr[$value['attr_id']]['attr_values'] = $value['attr_values'];
        $attr[$value['attr_id']]['price'] = $value['price'];
        $attr_ids[] = $value['attr_id'];
    }
    $sql = "SELECT attr_id,attr_name,input_type FROM $t_attribute WHERE attr_id IN (" . implode(',', $attr_ids) . ")";
    $attribute_result = $dbo->getRs($sql);
    $attribute = array();
    foreach ($attribute_result as $value) {
        $attribute[$value['attr_id']]['attr_values'] = $value['attr_name'];
        $attribute[$value['attr_id']]['input_type'] = $value['input_type'];
    }
    $attr_status = true;
}

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
//@TODO 请检查为何失效，调用pscws_call.php的时候报错。
include('pscws23/pscws_call.php');
$segmentResult = generateString($article_info['title'], $article_info['article_id']);
$sql = "SELECT * FROM `$t_article` WHERE " . $segmentResult . " LIMIT 10";
$relatedArticle = $dbo->getRs($sql);
$header = get_header_info($article_info);

$sql = "SELECT article_id,title FROM $t_article WHERE  cat_id='8'";
$left_article_list = $dbo->getRs($sql);

?>
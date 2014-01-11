<?php
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
$t_attribute = $tablePreStr."attribute";
$t_article_attr = $tablePreStr."article_attr";
$cat_id = intval(get_args('id'));
$keyword = short_check(get_args('keyword'));
$in = short_check(get_args('in'));
$attr_arr = get_args("attr");
$url_this = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
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

if(!$result) {
	trigger_error($s_langpackage->s_no_message);
}
$hot_news = get_hot_news($dbo, $t_article, $cat_id);
$header = get_header_info($cat_name);

/*导航位置*/
$nav_selected=5;
?>
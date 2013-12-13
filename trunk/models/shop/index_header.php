<?php
if(!$IWEB_SHOP_IN) {
	trigger_error('Hacking attempt');
}

if($USER['shop_id']) {
	$url=shop_url($USER['shop_id']);
} else {
	$url='modules.php?app=shop_info';
}
$search_header_type = short_check(get_args("search_type"));
//引入语言包
if(!isset($i_langpackage)){
	$i_langpackage = new indexlp;
}
$ksearch=short_check(get_args("k"));
if($i_langpackage->i_search_keyword==$ksearch){
	$ksearch="";
}

//数据表定义区
$t_keywords_count = $tablePreStr."keywords_count";
if(!isset($dbo)){
	/* 数据库操作 */
	dbtarget('r',$dbServs);
	$dbo=new dbex();
}
$keyword_sql = "select * from $t_keywords_count order by count desc LIMIT 0,5";
$keyword_result = $dbo->getRs($keyword_sql);

//获取天气，定时更新
//$weather = file_get_contents('http://m.weather.com.cn/data/101300501.html', 'r');
//$weather = json_decode($weather);
?>
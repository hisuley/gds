<?php
if(!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

//引入语言包
$m_langpackage=new moduleslp;
$i_langpackage=new indexlp;

//数据表定义区
$t_users = $tablePreStr."users";
$t_user_rss = $tablePreStr."user_rss";
$t_areas = $tablePreStr."areas";


//读写分离定义方法
dbtarget('w',$dbServs);
$dbo=new dbex;
$cat_ids = get_args('cat_id');
$is_enabled = get_args('is_enabled');
if(empty($is_enabled)){
    $is_enabled = 0;
}else{
    $is_enabled = 1;
}
$sql = "SELECT rss_id FROM $t_user_rss WHERE user_id = ".$user_id;
$result = $dbo->getRow($sql);
if(!empty($result['rss_id'])){
    $sql = "UPDATE $t_user_rss SET cat_id = '".implode(',', $cat_ids)."', is_enabled = ".$is_enabled." WHERE rss_id = ".$result['rss_id'];
}else{
    $sql = "INSERT INTO $t_user_rss (user_id, cat_id, is_enabled) VALUES(".$user_id.", '".implode(',', $cat_ids)."',".$is_enabled.")";
}
$dbo->exeUpdate($sql);
action_return(1,"订阅信息".$m_langpackage->m_save_succes,'-1');

exit;
?>
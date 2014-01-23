<?php
if(!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}

//引入公共方法
function get_promote_info(&$dbo,$select_items,$table,$id) {
    $item_sql = get_select_item($select_items);
    $sql="select $item_sql from `$table` where id='$id'";
    return $dbo->getRow($sql);
}

function get_promote_list(&$dbo,$select_items,$table,$shop_id) {
    $item_sql = get_select_item($select_items);
    $sql="select $item_sql from `$table` where shop_id='$shop_id'";
    return $dbo->getRs($sql);
}

function insert_promote(&$dbo,$table,$insert_items){
    $item_sql = get_insert_item($insert_items);
    $sql = "insert into `$table` $item_sql ";
    $dbo->exeUpdate($sql);
    return mysql_insert_id();

}

function update_promote_release(&$dbo,$table,$update_items,$id) {
    $item_sql = get_update_item($update_items);
    $sql = "update `$table` set $item_sql where id=$id";
    return $dbo->exeUpdate($sql);
}

function del_promote(&$dbo,$table,$id) {
    $sql = "delete from `$table` where id=$id";
    return $dbo->exeUpdate($sql);
}

//===========================
function get_promotelog_list(&$dbo,$select_items,$table,$id) {
    $item_sql = get_select_item($select_items);
    $sql="select $item_sql from `$table` where id='$id'";
    return $dbo->getRs($sql);
}
/* 我的促销信息 */
function get_my_promote(&$dbo,$t_promote,$t_goods,$t_promote_log,$t_shop_info,$user_id,$page){
    $sql="select a.*,b.*,c.*,d.lock_flg,d.open_flg from $t_promote as a,$t_goods as b,$t_promote_log as c,$t_shop_info as d where c.user_id=$user_id and c.id=a.id and a.goods_id=b.goods_id and b.shop_id=d.shop_id  and a.is_lock = '0'";
    return $dbo->fetch_page($sql,$page);
}
/* 促销列表信息 */

function get_promote_lst(&$dbo,$t_promote,$t_goods,$shop_id,$page){
    $sql="select a.*,b.* from $t_promote as a,$t_goods as b where a.shop_id='$shop_id' and a.goods_id=b.goods_id";

    return $dbo->fetch_page($sql,10);
}
?>

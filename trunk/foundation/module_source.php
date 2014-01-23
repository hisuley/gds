<?php
if (!$IWEB_SHOP_IN) {
    die('Hacking attempt');
}
/* 添加文章来源 */
function insert_source_info(&$dbo, $table, $insert_items)
{
    $item_sql = get_insert_item($insert_items);
    $sql = "insert into `$table` $item_sql ";
    $dbo->exeUpdate($sql);
    return mysql_insert_id();
}

/* 检测来源名称唯一性 */
function check_source_name(&$dbo, $table, $name, $source_id = 0)
{
    $sql = "SELECT COUNT(*) FROM `$table` WHERE name ='$name'";
    if ($source_id) {
        $sql .= " and source_id <> $source_id";
    }
    return $dbo->getRow($sql);
}

/* 文章来源信息 */
function get_source_info(&$dbo, $table, $source_id)
{
    $sql = "SELECT * FROM `$table` WHERE source_id='$source_id'";
    return $dbo->getRow($sql);
}

/* 删除文章来源信息 */
function del_source_info(&$dbo, $table, $source_id)
{
    $sql = "delete from `$table` where source_id in($source_id)";
    return $dbo->exeUpdate($sql);
}

/* 更新文章来源信息 */
function update_source_info(&$dbo, $table, $update_items, $source_id)
{
    $item_sql = get_update_item($update_items);
    $sql = "update `$table` set $item_sql where source_id='$source_id'";
    return $dbo->exeUpdate($sql);
}

?>
<?php
if (!$IWEB_SHOP_IN) {
    die("Hacking attempt");
}
$host = 'localhost'; //mysql数据库服务器,比如localhost:3306
$user = 'dms'; //mysql数据库默认用户名
$pwd = '8a7316fb3f96f4e3b20249e7a05dd0f92bddc81c'; //mysql数据库默认密码
$db = 'dms_v01'; //默认数据库名
global $tablePreStr;
$tablePreStr = 'imall_'; //表前缀

//当前提供服务的mysql数据库
global $dbServs;
$dbServs = array($host, $db, $user, $pwd);

?>
